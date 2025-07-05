<?php

namespace App\Livewire\Outbound;

use Livewire\Component;
use App\Models\Order;
use App\Models\InventoryBatch;
use App\Models\InventoryMovement;
use App\Services\AllocationService;
use App\Exceptions\InsufficientStockException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class Allocation extends Component
{
    public $searchOrder = '';
    public ?Order $selectedOrder = null;
    public ?Collection $picklist = null;
    public $allocationError = '';

    // Tambahkan pesan validasi custom
    protected $messages = [
        'searchOrder.required' => 'Nomor Sales Order wajib diisi sebelum mencari.',
    ];

    public function search()
    {
        // Validasi akan menggunakan pesan custom di atas
        $this->validate(['searchOrder' => 'required|string']);
        
        $this->reset(['selectedOrder', 'picklist', 'allocationError']);
        $order = Order::with('details.product')
                      ->where('order_number', $this->searchOrder)
                      ->where('status', 'pending')
                      ->first();

        if ($order) {
            $this->selectedOrder = $order;
        } else {
            $this->addError('searchOrder', 'Pesanan tidak ditemukan atau statusnya bukan "pending".');
        }
    }

    public function generatePicklist(AllocationService $allocationService)
    {
        $this->picklist = new Collection();
        $this->allocationError = '';
        
        try {
            $fullPicklist = new Collection();
            foreach ($this->selectedOrder->details as $detail) {
                $allocatedItems = $allocationService->allocate($detail->product_id, $detail->quantity_requested);
                
                $allocatedItemsWithProduct = $allocatedItems->map(function ($item) use ($detail) {
                    $item['product_name'] = $detail->product->name;
                    $item['product_sku'] = $detail->product->sku;
                    return $item;
                });
                
                $fullPicklist = $fullPicklist->merge($allocatedItemsWithProduct);
            }
            $this->picklist = $fullPicklist->sortBy('bin')->sortBy('rack')->sortBy('aisle')->sortBy('zone')->values();

        } catch (InsufficientStockException $e) {
            $this->allocationError = $e->getMessage();
            $this->picklist = null;
        }
    }

    public function confirmPicking()
    {
        if ($this->picklist === null || $this->picklist->isEmpty()) {
            $this->dispatch('alert', ['type' => 'error', 'message' => 'Tidak ada picklist untuk dikonfirmasi.']);
            return;
        }

        try {
            DB::transaction(function () {
                foreach ($this->picklist as $item) {
                    $batch = InventoryBatch::where('id', $item['batch_id'])->lockForUpdate()->first();

                    if (!$batch || $batch->quantity < $item['quantity_to_pick']) {
                        throw new \Exception("Stok untuk LPN {$item['lpn']} tidak lagi mencukupi. Harap batalkan dan buat ulang picklist.");
                    }

                    $batch->decrement('quantity', $item['quantity_to_pick']);

                    InventoryMovement::create([
                        'inventory_batch_id' => $item['batch_id'],
                        'type' => 'OUTBOUND',
                        'quantity_change' => -$item['quantity_to_pick'],
                        'from_location_id' => $item['location_id'],
                        'user_id' => Auth::id(),
                    ]);
                }

                $this->selectedOrder->update(['status' => 'completed']);
            });

            $this->dispatch('alert', [
                'type' => 'success',
                'message' => 'Picking untuk Pesanan ' . $this->selectedOrder->order_number . ' berhasil dikonfirmasi.',
            ]);

            $this->resetAll();

        } catch (\Exception $e) {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'Gagal: ' . $e->getMessage(),
            ]);
        }
    }

    public function resetAll()
    {
        $this->reset(['searchOrder', 'selectedOrder', 'picklist', 'allocationError']);
    }

    public function render()
    {
        return view('livewire.outbound.allocation')->layout('layouts.app');
    }
}