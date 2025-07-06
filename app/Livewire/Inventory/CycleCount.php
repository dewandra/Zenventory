<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use App\Models\Location;
use App\Models\InventoryBatch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CycleCount extends Component
{
    public $activeCycleCount;
    public $itemsToCount = [];

    public function startNewCycle()
    {
        // Ambil 5 lokasi secara acak yang memiliki stok untuk dihitung
        $locationsToCount = Location::has('inventoryBatches')->inRandomOrder()->limit(5)->get();

        if ($locationsToCount->isEmpty()) {
            $this->dispatch('alert', ['type' => 'warning', 'message' => 'Tidak ada lokasi dengan stok untuk dihitung.']);
            return;
        }

        DB::transaction(function () use ($locationsToCount) {
            // PERBAIKAN: Gunakan nama lengkap model
            $cycleCount = \App\Models\CycleCount::create([
                'reference_number' => 'CC-' . time(),
                'user_id' => Auth::id(),
                'status' => 'in_progress',
            ]);

            foreach ($locationsToCount as $location) {
                $batchesInLocation = InventoryBatch::where('location_id', $location->id)->where('quantity', '>', 0)->get();
                foreach ($batchesInLocation as $batch) {
                    $cycleCount->items()->create([
                        'location_id' => $location->id,
                        'product_id' => $batch->product_id,
                        'inventory_batch_id' => $batch->id,
                        'system_quantity' => $batch->quantity,
                        'variance' => -$batch->quantity, // Asumsi awal, belum dihitung
                    ]);
                }
            }
            $this->activeCycleCount = $cycleCount;
        });

        $this->loadItems();
    }

    public function loadItems()
    {
        if ($this->activeCycleCount) {
            $this->itemsToCount = $this->activeCycleCount->items()->with('product', 'location')->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'location_name' => $item->location->name,
                    'product_name' => $item->product->name,
                    'system_quantity' => $item->system_quantity,
                    'counted_quantity' => $item->counted_quantity ?? '',
                ];
            })->toArray();
        }
    }

    public function mount()
    {
        // PERBAIKAN: Gunakan nama lengkap model
        $this->activeCycleCount = \App\Models\CycleCount::where('status', 'in_progress')->latest()->first();
        $this->loadItems();
    }

    public function saveCounts()
    {
        foreach ($this->itemsToCount as $itemData) {
            $item = \App\Models\CycleCountItem::find($itemData['id']);
            if ($item && is_numeric($itemData['counted_quantity'])) {
                $item->counted_quantity = $itemData['counted_quantity'];
                $item->variance = $item->counted_quantity - $item->system_quantity;
                $item->save();
            }
        }

        $this->activeCycleCount->update(['status' => 'requires_review']);
        $this->dispatch('alert', ['type' => 'info', 'message' => 'Hasil hitungan disimpan dan menunggu review.']);
        $this->resetAll();
    }
    
    public function resetAll()
    {
        $this->reset(['activeCycleCount', 'itemsToCount']);
    }

    public function render()
    {
        return view('livewire.inventory.cycle-count')->layout('layouts.app');
    }
}