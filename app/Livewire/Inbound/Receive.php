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
    
    public $products = [];
    public $locations = [];

    protected $rules = [
        'productId' => 'required|exists:products,id',
        'locationId' => 'required|exists:locations,id',
        'quantity' => 'required|integer|min:1',
        'expiry_date' => 'nullable|date',
    ];

    /**
     * Fungsi ini dijalankan setiap kali ada perubahan pada properti yang di-binding
     * dengan wire:model.live.
     */
    public function updated($name)
    {
        // Jika mengubah kolom pencarian produk
        if ($name === 'searchProduct' && strlen($this->searchProduct) > 2) {
            $this->products = Product::where('name', 'like', '%' . $this->searchProduct . '%')
                  ->orWhere('sku', 'like', '%' . $this->searchProduct . '%')
                  ->limit(5)
                  ->get();
        } else {
            $this->products = [];
        }

        // Jika mengubah kolom pencarian lokasi
        if ($name === 'searchLocation' && strlen($this->searchLocation) > 1) {
            $this->locations = Location::where('name', 'like', '%' . $this->searchLocation . '%')
                ->limit(5)
                ->get();
        } else {
            $this->locations = [];
        }
    }

    /**
     * Mengisi form setelah produk dipilih dari dropdown dan menutup dropdown.
     */
    public function selectProductAndClose($productId, $productName)
    {
        $this->productId = $productId;
        $this->searchProduct = $productName;
        $this->products = []; // Sembunyikan dropdown
    }

    /**
     * Mengisi form setelah lokasi dipilih dari dropdown dan menutup dropdown.
     */
    public function selectLocationAndClose($locationId, $locationName)
    {
        $this->locationId = $locationId;
        $this->searchLocation = $locationName;
        $this->locations = []; // Sembunyikan dropdown
    }

    /**
     * Membuat LPN unik berdasarkan tanggal hari ini.
     */
    public function generateLpn()
    {
        $datePart = Carbon::now()->format('Ymd');
        $lastBatch = InventoryBatch::where('lpn', 'like', $datePart . '-%')->latest('id')->first();
        
        $nextNumber = 1;
        if ($lastBatch) {
            $lastNumber = (int) substr($lastBatch->lpn, -3);
            $nextNumber = $lastNumber + 1;
        }

        return $datePart . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Memproses penerimaan produk.
     */
    public function receiveProduct()
    {
        $this->validate();

        $lpn = $this->generateLpn();

        $batch = InventoryBatch::create([
            'lpn' => $lpn,
            'product_id' => $this->productId,
            'location_id' => $this->locationId,
            'quantity' => $this->quantity,
            'received_date' => Carbon::today(),
            'expiry_date' => $this->expiry_date,
        ]);

        InventoryMovement::create([
            'inventory_batch_id' => $batch->id,
            'type' => 'INBOUND',
            'quantity_change' => $this->quantity,
            'to_location_id' => $this->locationId,
            'user_id' => Auth::id(),
        ]);

        $this->dispatch('alert', [
            'type' => 'success',
            'message' => "Barang berhasil diterima dengan LPN: " . $lpn,
        ]);
        
        $this->resetForm();
    }
    
    /**
     * Mengosongkan semua input pada form.
     */
    public function resetForm()
    {
        $this->reset(['productId', 'locationId', 'quantity', 'expiry_date', 'searchProduct', 'searchLocation', 'products', 'locations']);
    }

    public function render()
    {
        return view('livewire.inbound.receive', [
            // Properti 'products' dan 'locations' sudah di-handle oleh fungsi updated()
        ])->layout('layouts.app');
    }
}