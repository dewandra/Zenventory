<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use App\Models\InventoryBatch;
use App\Models\InventoryMovement;

class TraceLpn extends Component
{
    public $searchLpn = '';
    public ?InventoryBatch $batchInfo = null;
    public $movements = [];

    public function trace()
    {
        $this->validate(['searchLpn' => 'required|string']);
        $this->reset(['batchInfo', 'movements']);

        // Cari batch berdasarkan LPN
        $batch = InventoryBatch::with('product', 'location')
                               ->where('lpn', $this->searchLpn)
                               ->first();

        if ($batch) {
            $this->batchInfo = $batch;
            // Ambil semua riwayat pergerakan untuk batch ini
            $this->movements = InventoryMovement::with(['user', 'fromLocation', 'toLocation'])
                                                ->where('inventory_batch_id', $batch->id)
                                                ->orderBy('created_at', 'asc')
                                                ->get();
        } else {
            $this->addError('searchLpn', 'LPN tidak ditemukan.');
        }
    }

    public function render()
    {
        return view('livewire.inventory.trace-lpn')->layout('layouts.app');
    }
}