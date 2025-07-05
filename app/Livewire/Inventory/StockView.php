<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\InventoryBatch;
use Illuminate\Support\Facades\DB;

class StockView extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedProductId;
    public $selectedProductName;
    public $batchDetails = [];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function showDetails($productId, $productName)
    {
        $this->selectedProductId = $productId;
        $this->selectedProductName = $productName;

        // Ambil semua batch untuk produk yang dipilih
        $this->batchDetails = InventoryBatch::with('location')
            ->where('product_id', $productId)
            ->where('quantity', '>', 0)
            ->orderBy('received_date', 'asc')
            ->get();
    }

    public function clearDetails()
    {
        $this->reset(['selectedProductId', 'selectedProductName', 'batchDetails']);
    }

    public function render()
    {
        // Query untuk mendapatkan ringkasan stok per produk
        $stockSummary = Product::query()
            ->select([
                'products.id',
                'products.name',
                'products.sku',
                // Hitung total kuantitas dari semua batch yang terkait
                DB::raw('SUM(inventory_batches.quantity) as total_quantity')
            ])
            ->join('inventory_batches', 'products.id', '=', 'inventory_batches.product_id')
            ->where('inventory_batches.quantity', '>', 0)
            ->when($this->search, function ($query) {
                $query->where('products.name', 'like', '%' . $this->search . '%')
                      ->orWhere('products.sku', 'like', '%' . $this->search . '%');
            })
            ->groupBy('products.id', 'products.name', 'products.sku')
            ->orderBy('products.name')
            ->paginate(15);

        return view('livewire.inventory.stock-view', [
            'stockSummary' => $stockSummary
        ])->layout('layouts.app');
    }
}