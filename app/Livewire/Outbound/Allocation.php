<?php

namespace App\Livewire\Outbound;

use Livewire\Component;
use App\Models\Order;
use App\Models\InventoryBatch;
use App\Models\InventoryMovement;
use App\Models\Picklist;
use App\Services\AllocationService;
use App\Exceptions\InsufficientStockException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Allocation extends Component
{
    public $searchOrder = '';
    public ?Order $selectedOrder = null;
    public ?Picklist $activePicklist = null;
    public $allocationError = '';

    protected $messages = [
        'searchOrder.required' => 'Nomor Sales Order wajib diisi sebelum mencari.',
    ];

    public function search()
    {
        $this->validate(['searchOrder' => 'required|string']);
        $this->resetAll();
        
        // --- KODE FINAL YANG DISEDERHANAKAN ---
        $searchTerm = trim($this->searchOrder);
        
        $order = Order::with('details.product')
                      ->where('order_number', $searchTerm)
                      // Menggunakan whereIn biasa yang lebih stabil
                      ->whereIn('status', ['pending', 'processing', 'Pending', 'Processing'])
                      ->first();

        if ($order) {
            $this->selectedOrder = $order;
            $this->activePicklist = Picklist::with('items.product', 'items.location')
                                            ->where('order_id', $order->id)
                                            ->where('status', '!=', 'completed')
                                            ->first();
        } else {
            $this->addError('searchOrder', 'Pesanan tidak ditemukan atau statusnya sudah selesai.');
        }
    }

    // ... (SISA SEMUA FUNGSI LAINNYA TETAP SAMA SEPERTI SEBELUMNYA) ...
    public function generatePicklist(AllocationService $allocationService)
    {
        $this->allocationError = '';
        if (!$this->selectedOrder) return;
        
        try {
            $itemsToPick = new \Illuminate\Support\Collection();
            foreach ($this->selectedOrder->details as $detail) {
                $allocatedItems = $allocationService->allocate($detail->product_id, $detail->quantity_requested);
                $itemsToPick = $itemsToPick->merge($allocatedItems);
            }

            DB::transaction(function () use ($itemsToPick) {
                $picklist = Picklist::create([
                    'picklist_number' => 'PL-' . time() . '-' . $this->selectedOrder->id,
                    'order_id' => $this->selectedOrder->id,
                    'user_id' => Auth::id(),
                    'status' => 'pending',
                ]);

                foreach ($itemsToPick as $item) {
                    $product = \App\Models\Product::find($item['product_id']);
                    $picklist->items()->create([
                        'product_id' => $item['product_id'],
                        'inventory_batch_id' => $item['batch_id'],
                        'location_id' => $item['location_id'],
                        'quantity_to_pick' => $item['quantity_to_pick'],
                        'product_name' => $product->name,
                        'product_sku' => $product->sku,
                        'lpn' => $item['lpn'],
                        'location_name' => $item['location_name'],
                    ]);
                }

                $this->selectedOrder->update(['status' => 'processing']);
                $this->activePicklist = $picklist->load('items.product', 'items.location');
            });

        } catch (InsufficientStockException $e) {
            $this->allocationError = $e->getMessage();
        }
    }

    public function confirmPicking()
    {
        if (!$this->activePicklist) return;

        try {
            DB::transaction(function () {
                foreach ($this->activePicklist->items as $item) {
                    $batch = InventoryBatch::where('id', $item->inventory_batch_id)->lockForUpdate()->first();
                    if (!$batch || $batch->quantity < $item->quantity_to_pick) {
                        throw new \Exception("Stok untuk LPN {$item->lpn} tidak mencukupi.");
                    }
                    $batch->decrement('quantity', $item->quantity_to_pick);

                    InventoryMovement::create([
                        'inventory_batch_id' => $item->inventory_batch_id,
                        'type' => 'OUTBOUND',
                        'quantity_change' => -$item->quantity_to_pick,
                        'from_location_id' => $item->location_id,
                        'user_id' => Auth::id(),
                    ]);
                }

                $this->activePicklist->update(['status' => 'completed', 'completed_at' => now()]);
                $this->selectedOrder->update(['status' => 'completed']);
            });

            $this->dispatch('alert', ['type' => 'success', 'message' => 'Picking untuk Picklist ' . $this->activePicklist->picklist_number . ' berhasil.']);
            $this->resetAll();
        } catch (\Exception $e) {
            $this->dispatch('alert', ['type' => 'error', 'message' => 'Gagal: ' . $e->getMessage()]);
        }
    }

    public function resetAll()
    {
        $this->reset(['searchOrder', 'selectedOrder', 'activePicklist', 'allocationError']);
    }

    public function render()
    {
        return view('livewire.outbound.allocation')->layout('layouts.app');
    }
}