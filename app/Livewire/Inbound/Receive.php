<?php

namespace App\Livewire\Inbound;

use App\Models\Product;
use App\Models\Location;
use App\Models\InventoryBatch;
use App\Models\InventoryMovement;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Carbon\Carbon;

class Receive extends Component
{
    public $productId;
    public $locationId;
    public $quantity;
    public $expiry_date;

    public $searchProduct = '';
    public $searchLocation = '';

    protected $rules = [
        'productId' => 'required|exists:products,id',
        'locationId' => 'required|exists:locations,id',
        'quantity' => 'required|integer|min:1',
        'expiry_date' => 'nullable|date',
    ];

    public function generateLpn()
    {
        // Format: YYYYMMDD-XXX (XXX adalah nomor urut harian)
        $datePart = Carbon::now()->format('Ymd');
        $lastBatch = InventoryBatch::where('lpn', 'like', $datePart . '-%')->latest('id')->first();
        
        $nextNumber = 1;
        if ($lastBatch) {
            $lastNumber = (int) substr($lastBatch->lpn, -3);
            $nextNumber = $lastNumber + 1;
        }

        return $datePart . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    public function receiveProduct()
    {
        $this->validate();

        // 1. Generate LPN
        $lpn = $this->generateLpn();

        // 2. Simpan ke inventory_batches
        $batch = InventoryBatch::create([
            'lpn' => $lpn,
            'product_id' => $this->productId,
            'location_id' => $this->locationId,
            'quantity' => $this->quantity,
            'received_date' => Carbon::today(),
            'expiry_date' => $this->expiry_date,
        ]);

        // 3. Catat transaksi di inventory_movements
        InventoryMovement::create([
            'inventory_batch_id' => $batch->id,
            'type' => 'INBOUND',
            'quantity_change' => $this->quantity, // Kuantitas masuk adalah positif
            'to_location_id' => $this->locationId,
            'user_id' => Auth::id(),
        ]);

        // 4. Reset form dan beri notifikasi
        $this->reset(['productId', 'locationId', 'quantity', 'expiry_date', 'searchProduct', 'searchLocation']);
        
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => "Barang berhasil diterima dengan LPN: " . $lpn,
        ]);
    }

    public function render()
    {
        $products = Product::query()
            ->when($this->searchProduct, function ($query) {
                $query->where('name', 'like', '%' . $this->searchProduct . '%')
                      ->orWhere('sku', 'like', '%' . $this->searchProduct . '%');
            })
            ->limit(5)
            ->get();

        $locations = Location::query()
            ->when($this->searchLocation, function ($query) {
                $query->where('name', 'like', '%' . $this->searchLocation . '%');
            })
            ->limit(5)
            ->get();

        return view('livewire.inbound.receive', [
            'products' => $products,
            'locations' => $locations
        ])->layout('layouts.app');
    }
}