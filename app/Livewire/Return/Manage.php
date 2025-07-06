<?php

namespace App\Livewire\Return;

use Livewire\Component;
use App\Models\ReturnModel; // Gunakan nama kelas yang baru
use App\Models\Location;
use App\Models\Product;
use App\Models\InventoryBatch;
use App\Models\InventoryMovement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Manage extends Component
{
    public $returns;
    public $selectedReturn;
    public $itemsToProcess = [];

    public function mount()
    {
        $this->returns = ReturnModel::with('items.product')->where('status', '!=', 'processed')->latest()->get();
    }

    public function selectReturn($returnId)
    {
        $this->selectedReturn = ReturnModel::with('items.product')->find($returnId);
        foreach ($this->selectedReturn->items as $item) {
            $this->itemsToProcess[$item->id] = [
                'disposition' => '',
                'quantity' => $item->quantity
            ];
        }
    }

    public function processReturn()
    {
        if (!$this->selectedReturn) return;

        DB::transaction(function () {
            foreach ($this->itemsToProcess as $itemId => $data) {
                $item = \App\Models\ReturnItem::find($itemId);

                if ($data['disposition'] == 'restock') {
                    // Barang dimasukkan kembali ke stok
                    $lpn = 'RTN-' . time() . '-' . $item->id;
                    // Idealnya ada lokasi 'karantina', untuk sekarang kita asumsikan masuk ke lokasi pertama
                    $locationId = Location::first()->id; 

                    $batch = InventoryBatch::create([
                        'lpn' => $lpn,
                        'product_id' => $item->product_id,
                        'location_id' => $locationId,
                        'quantity' => $data['quantity'],
                        'received_date' => now(),
                        'expiry_date' => null, // expiry_date bisa ditambahkan sebagai inputan jika perlu
                    ]);

                    InventoryMovement::create([
                        'inventory_batch_id' => $batch->id,
                        'type' => 'RETURN_RESTOCK',
                        'quantity_change' => $data['quantity'],
                        'to_location_id' => $locationId,
                        'user_id' => Auth::id(),
                        'notes' => 'Return from ' . $this->selectedReturn->return_number,
                    ]);

                }
                
                $item->update(['disposition' => $data['disposition']]);
            }
            
            $this->selectedReturn->update(['status' => 'processed']);
        });

        $this->dispatch('alert', ['type' => 'success', 'message' => 'Proses retur berhasil diselesaikan.']);
        $this->resetAll();
    }

    public function resetAll()
    {
        $this->reset(['selectedReturn', 'itemsToProcess']);
        $this->mount(); // Muat ulang daftar retur
    }
    
    public function render()
    {
        return view('livewire.return.manage')->layout('layouts.app');
    }
}