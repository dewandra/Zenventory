<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// --- PERUBAHAN DI SINI ---
// Arahkan rute utama ('/') langsung ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', \App\Livewire\Dashboard\Index::class)
     ->middleware(['auth', 'verified'])
     ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Products
    Route::get('/products', \App\Livewire\Product\Index::class)->name('products.index')->middleware('can:manage products');
    
    // Locations
    Route::get('/locations', \App\Livewire\Location\Index::class)->name('locations.index')->middleware('can:manage locations');
    
    // Inbound
    Route::get('/inbound/receive', \App\Livewire\Inbound\Receive::class)->name('inbound.receive')->middleware('can:perform inbound');
    Route::get('/inbound/history', \App\Livewire\Inbound\History::class)->name('inbound.history')->middleware('can:perform inbound');
    
    // Outbound
    Route::get('/orders', \App\Livewire\Order\Index::class)->name('orders.index')->middleware('can:perform outbound');
    Route::get('/outbound/allocation', \App\Livewire\Outbound\Allocation::class)->name('outbound.allocation')->middleware('can:perform outbound');

    // Inventory Control
    Route::get('/inventory/trace', \App\Livewire\Inventory\TraceLpn::class)->name('inventory.trace')->middleware('can:view reports');
    Route::get('/inventory/stock', \App\Livewire\Inventory\StockView::class)->name('inventory.stock')->middleware('can:view reports');
    Route::get('/inventory/cycle-count', \App\Livewire\Inventory\CycleCount::class)->name('inventory.cycle-count')->middleware('can:manage products');
    Route::get('/inventory/adjustment', \App\Livewire\Inventory\Adjustment::class)->name('inventory.adjustment')->middleware('can:manage products');
    Route::get('/inventory/returns', \App\Livewire\Return\Manage::class)->name('inventory.returns')->middleware('can:manage products');
});

// Reports
Route::get('/reports/export/inventory-aging', [ReportController::class, 'exportInventoryAging'])->name('reports.export.aging');

require __DIR__.'/auth.php';