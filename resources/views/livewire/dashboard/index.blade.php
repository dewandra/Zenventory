<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center">
        <h1 class="text-2xl font-semibold text-gray-900">Dashboard Overview</h1>
        <span class="text-sm text-gray-500">Data per: {{ now()->format('d M Y, H:i') }}</span>
    </div>

    <div wire:poll.15s="loadKpis" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-blue-600 text-white p-6 rounded-xl shadow-lg transform hover:scale-105 transition-transform duration-300">
            <div class="flex justify-between items-center">
                <p class="text-sm font-light text-blue-200 uppercase tracking-wider">Pesanan Pending</p>
                <span class="bg-blue-800 text-white text-xs font-bold px-2 py-1 rounded-full">UTAMA</span>
            </div>
            <p class="text-4xl font-bold mt-2">{{ $totalOrdersPending }}</p>
            <p class="text-xs font-light text-blue-200 mt-1">Pesanan yang perlu dialokasikan</p>
        </div>

        <div class="bg-yellow-500 text-white p-6 rounded-xl shadow-lg transform hover:scale-105 transition-transform duration-300">
             <div class="flex justify-between items-center">
                <p class="text-sm font-light text-yellow-100 uppercase tracking-wider">Stok Menipis</p>
                 <span class="bg-yellow-700 text-white text-xs font-bold px-2 py-1 rounded-full">PERHATIAN</span>
            </div>
            <p class="text-4xl font-bold mt-2">{{ $lowStockItemsCount }}</p>
            <p class="text-xs font-light text-yellow-100 mt-1">Produk dengan stok di bawah ambang batas</p>
        </div>

        <div class="bg-green-500 text-white p-6 rounded-xl shadow-lg transform hover:scale-105 transition-transform duration-300">
            <p class="text-sm font-light text-green-200 uppercase tracking-wider">Penerimaan Hari Ini</p>
            <p class="text-4xl font-bold mt-2">{{ $inboundToday }}</p>
            <p class="text-xs font-light text-green-200 mt-1">Jumlah batch (LPN) yang diterima</p>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
         <div class="bg-gray-700 text-white p-5 rounded-xl shadow-md">
            <p class="text-sm text-gray-300">Total Unit di Gudang</p>
            <p class="text-2xl font-bold">{{ number_format($totalValue) }}</p>
        </div>
        <div class="bg-gray-700 text-white p-5 rounded-xl shadow-md">
            <p class="text-sm text-gray-300">Kapasitas Gudang Terpakai</p>
            <p class="text-2xl font-bold">{{ $warehouseCapacity }}%</p>
        </div>
        <div class="bg-gray-700 text-white p-5 rounded-xl shadow-md">
            <p class="text-sm text-gray-300">Rata-rata Umur Stok</p>
            <p class="text-2xl font-bold">{{ $inventoryAging ?? 0 }} hari</p>
        </div>
    </div>
</div>