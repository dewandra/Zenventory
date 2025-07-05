<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\InventoryBatch;
use App\Models\Order;
use App\Models\Location;
use Carbon\Carbon;

class Index extends Component
{
    public $totalOrdersPending;
    public $lowStockItemsCount;
    public $totalValue; // Ini akan disederhanakan untuk contoh
    public $warehouseCapacity;
    public $inventoryAging;
    public $inboundToday;

    public function mount()
    {
        $this->loadKpis();
    }

    public function loadKpis()
    {
        // KPI 1: Pesanan yang Perlu Diproses
        $this->totalOrdersPending = Order::where('status', 'pending')->count();

        // KPI 2: Item Stok Rendah (contoh: stok di bawah 10 unit)
        // Query ini menjumlahkan stok per produk dan menghitung berapa produk yang totalnya di bawah 10
        $lowStockProducts = InventoryBatch::selectRaw('product_id, SUM(quantity) as total_stock')
            ->groupBy('product_id')
            ->having('total_stock', '<', 10)
            ->get();
        $this->lowStockItemsCount = $lowStockProducts->count();

        // KPI 3: Total Nilai Inventaris (Contoh sederhana)
        // Di aplikasi nyata, ini akan dikalikan dengan harga modal per produk.
        $this->totalValue = InventoryBatch::sum('quantity');

        // KPI 4: Kapasitas Gudang
        $totalLocations = Location::count();
        $occupiedLocations = InventoryBatch::where('quantity', '>', 0)->distinct('location_id')->count('location_id');
        $this->warehouseCapacity = $totalLocations > 0 ? round(($occupiedLocations / $totalLocations) * 100) : 0;

        // KPI 5: Umur Stok (Inventory Aging) - Rata-rata
        $this->inventoryAging = InventoryBatch::where('quantity', '>', 0)->avg(
            \DB::raw('DATEDIFF(now(), received_date)')
        );
        $this->inventoryAging = round($this->inventoryAging);

        // KPI 6: Penerimaan Barang Hari Ini
        $this->inboundToday = InventoryBatch::whereDate('received_date', Carbon::today())->count();
    }

    public function render()
    {
        return view('livewire.dashboard.index')->layout('layouts.app');
    }
}