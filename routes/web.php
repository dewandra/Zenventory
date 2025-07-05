<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', \App\Livewire\Dashboard\Index::class)
     ->middleware(['auth', 'verified'])
     ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.
    destroy');

    Route::get('/products', \App\Livewire\Product\Index::class)
        ->name('products.index')
        ->middleware('can:manage products');

    Route::get('/locations', \App\Livewire\Location\Index::class)
        ->name('locations.index')
        ->middleware('can:manage locations');

    Route::get('/inbound/receive', \App\Livewire\Inbound\Receive::class)
        ->name('inbound.receive')
        ->middleware('can:perform inbound');

    Route::get('/inbound/history', \App\Livewire\Inbound\History::class)
        ->name('inbound.history')
        ->middleware('can:perform inbound');

    Route::get('/outbound/allocation', \App\Livewire\Outbound\Allocation::class)
        ->name('outbound.allocation')
        ->middleware('can:perform outbound');

    Route::get('/orders', \App\Livewire\Order\Index::class)
        ->name('orders.index')
        ->middleware('can:perform outbound');

    Route::get('/inventory/trace', \App\Livewire\Inventory\TraceLpn::class)
        ->name('inventory.trace')
        ->middleware('can:view reports');
        
        Route::get('/inventory/stock', \App\Livewire\Inventory\StockView::class)
     ->name('inventory.stock')
     ->middleware('can:view reports');

     Route::get('/inventory/adjustment', \App\Livewire\Inventory\Adjustment::class)
     ->name('inventory.adjustment')
     ->middleware('can:manage products');

     
});

Route::get('/reports/export/inventory-aging', [ReportController::class, 'exportInventoryAging'])->name('reports.export.aging');


require __DIR__ . '/auth.php';
