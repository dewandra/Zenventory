<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\InventoryBatch;
use App\Models\InventoryMovement;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    // KPI Cards
    public $totalOrdersPending;
    public $lowStockItemsCount;
    public $inboundToday;

    // Properti untuk data Chart
    public $inboundOutboundData = [];
    public $topProductsData = [];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        // 1. KPI Cards
        $this->totalOrdersPending = Cache::remember('dashboard.totalOrdersPending', now()->addMinutes(10), function () {
            return Order::where('status', 'pending')->count();
        });
        $this->lowStockItemsCount = Cache::remember('dashboard.lowStockItemsCount', now()->addMinutes(10), function () {
            return InventoryBatch::selectRaw('product_id, SUM(quantity) as total_stock')
                ->groupBy('product_id')
                ->having('total_stock', '<', 10)
                ->get()->count();
        });
        $this->inboundToday = Cache::remember('dashboard.inboundToday', now()->addMinutes(10), function () {
            return InventoryMovement::where('type', 'INBOUND')->whereDate('created_at', Carbon::today())->sum('quantity_change');
        });

        // 2. Data untuk Chart Baru
        $this->prepareInboundOutboundChart();
        $this->prepareTopProductsChart();

        // Kirim event ke frontend untuk me-render ulang chart
        $this->dispatch('charts-updated', [
            'inboundOutbound' => $this->inboundOutboundData,
            'topProducts' => $this->topProductsData,
        ]);
    }

    private function prepareInboundOutboundChart()
    {
        $dates = collect(range(6, 0))->map(fn ($i) => Carbon::now()->subDays($i)->format('Y-m-d'));

        $inbound = InventoryMovement::where('type', 'INBOUND')
            ->whereBetween('created_at', [$dates->first(), $dates->last() . ' 23:59:59'])
            ->groupBy('date')
            ->orderBy('date')
            ->get([DB::raw('DATE(created_at) as date'), DB::raw('SUM(quantity_change) as total')])
            ->pluck('total', 'date');

        $outbound = InventoryMovement::where('type', 'OUTBOUND')
            ->whereBetween('created_at', [$dates->first(), $dates->last() . ' 23:59:59'])
            ->groupBy('date')
            ->orderBy('date')
            ->get([DB::raw('DATE(created_at) as date'), DB::raw('SUM(ABS(quantity_change)) as total')])
            ->pluck('total', 'date');

        $this->inboundOutboundData = [
            'categories' => $dates->map(fn ($date) => Carbon::parse($date)->format('d M'))->toArray(),
            'series' => [
                ['name' => 'Inbound', 'data' => $dates->map(fn ($date) => $inbound->get($date, 0))->toArray()],
                ['name' => 'Outbound', 'data' => $dates->map(fn ($date) => $outbound->get($date, 0))->toArray()],
            ]
        ];
    }

    private function prepareTopProductsChart()
    {
        $topProducts = InventoryBatch::with('product')
            ->select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->where('quantity', '>', 0)
            ->groupBy('product_id')
            ->orderBy('total_quantity', 'desc')
            ->limit(5)
            ->get();
        
        $this->topProductsData = [
            'labels' => $topProducts->pluck('product.name')->toArray(),
            // PERBAIKAN: Gunakan map() untuk memastikan semua data adalah angka
            'series' => $topProducts->pluck('total_quantity')->map(fn($quantity) => (int) $quantity)->toArray(),
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.index')->layout('layouts.app');
    }
}