<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use App\Models\InventoryBatch;
use App\Models\InventoryMovement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Adjustment extends Component
{
    public $searchLpn = '';
    public ?InventoryBatch $selectedBatch = null;
    public $newQuantity;
    public $reason = '';

    public function search()
    {
        $this->validate(['searchLpn' => 'required|string']);
        $this->reset(['selectedBatch', 'newQuantity', 'reason']);

        $batch = InventoryBatch::with('product')->where('lpn', $this->searchLpn)->first();

        if ($batch) {
            $this->selectedBatch = $batch;
            $this->newQuantity = $batch->quantity; // Isi kuantitas baru dengan kuantitas saat ini
        } else {
            $this->addError('searchLpn', 'LPN tidak ditemukan di dalam sistem.');
        }
    }

    public function submitAdjustment()
    {
        if (!$this->selectedBatch) {
            return;
        }

        $this->validate([
            'newQuantity' => 'required|integer|min:0',
            'reason' => 'required|string|max:255',
        ]);

        $oldQuantity = $this->selectedBatch->quantity;
        $quantityChange = $this->newQuantity - $oldQuantity;

        // Jika tidak ada perubahan, tidak perlu melakukan apa-apa
        if ($quantityChange == 0) {
            $this->dispatch('alert', [
                'type' => 'warning',
                'message' => 'Tidak ada perubahan kuantitas yang dibuat.',
            ]);
            return;
        }

        try {
            DB::transaction(function () use ($quantityChange) {
                // Perbarui kuantitas di batch
                $this->selectedBatch->update(['quantity' => $this->newQuantity]);

                // Catat pergerakan sebagai 'ADJUSTMENT'
                InventoryMovement::create([
                    'inventory_batch_id' => $this->selectedBatch->id,
                    'type' => 'ADJUSTMENT',
                    'quantity_change' => $quantityChange,
                    'to_location_id' => $this->selectedBatch->location_id, // Lokasi tidak berubah
                    'user_id' => Auth::id(),
                    'notes' => $this->reason, 
                ]);
            });

            $this->dispatch('alert', [
                'type' => 'success',
                'message' => 'Penyesuaian stok berhasil disimpan. Stok baru: ' . $this->newQuantity,
            ]);

            $this->resetAll();

        } catch (\Exception $e) {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'Gagal menyimpan penyesuaian: ' . $e->getMessage(),
            ]);
        }
    }

    public function resetAll()
    {
        $this->reset(['searchLpn', 'selectedBatch', 'newQuantity', 'reason']);
    }

    public function render()
    {
        return view('livewire.inventory.adjustment')->layout('layouts.app');
    }
}