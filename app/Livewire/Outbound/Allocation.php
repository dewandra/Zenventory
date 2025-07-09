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
use Illuminate\Support\Collection;

class Allocation extends Component
{
    public $searchOrder = '';
    public ?Order $selectedOrder = null;
    public ?Picklist $activePicklist = null;
    public $allocationError = '';

    protected $messages = [
        'searchOrder.required' => 'The Sales Order number cannot be empty.',
    ];

    public function search()
    {
        // Trim input terlebih dahulu
        $this->searchOrder = trim($this->searchOrder);

        // Validasi menggunakan Laravel
        $this->validate([
            'searchOrder' => 'required|string',
        ]);

        // Reset hanya variabel yang diperlukan (bukan searchOrder)
        $this->reset(['selectedOrder', 'activePicklist', 'allocationError']);

        $searchTerm = $this->searchOrder;

        $order = Order::with('details.product')
            ->whereRaw('LOWER(order_number) = ?', [strtolower($searchTerm)])
            ->first();

        if ($order) {
            $currentStatus = strtolower(trim($order->status));

            if ($currentStatus === 'pending' || $currentStatus === 'processing') {
                $this->selectedOrder = $order;

                $this->activePicklist = Picklist::with('items.product', 'items.location')
                    ->where('order_id', $order->id)
                    ->where('status', '!=', 'completed')
                    ->first();
            } else {
                $this->addError('searchOrder', 'Order found, but its status is "' . $order->status . '" and cannot be processed.');
            }
        } else {
            $this->addError('searchOrder', 'Order not found or its status is already completed.');
        }
    }

    public function generatePicklist(AllocationService $allocationService)
    {
        $this->allocationError = '';
        if (!$this->selectedOrder) return;

        try {
            $itemsToPick = new Collection();

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

                // Ambil semua ID batch terlebih dahulu
            $batchIds = $this->activePicklist->items->pluck('inventory_batch_id');

            // Ambil semua data batch dalam satu kali query
            $batches = InventoryBatch::whereIn('id', $batchIds)->lockForUpdate()->get()->keyBy('id');

                foreach ($this->activePicklist->items as $item) {
                    $batch = $batches->get($item->inventory_batch_id);

                    if (!$batch || $batch->quantity < $item->quantity_to_pick) {
                        throw new \Exception("Insufficient stock for LPN {$item->lpn}.");
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

            $this->dispatch('alert', [
                'type' => 'success',
                'message' => 'Picking for Picklist ' . $this->activePicklist->picklist_number . ' completed successfully.',
            ]);

            $this->resetAll();
        } catch (\Exception $e) {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'Failed: ' . $e->getMessage(),
            ]);
        }
    }

    public function resetAll()
    {
        $this->reset([
            'searchOrder',
            'selectedOrder',
            'activePicklist',
            'allocationError',
        ]);
    }

    public function render()
    {
        return view('livewire.outbound.allocation')->layout('layouts.app');
    }
}