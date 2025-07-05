<div class="space-y-6">
    <div class="bg-white p-6 shadow-md rounded-lg">
        <x-page-header title="Rangkuman Stok Inventaris">
            <div class="flex items-center space-x-4">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari Produk..." class="w-full sm:w-80 px-4 py-2 border rounded-md">
                
                <a href="{{ route('reports.export.aging') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg whitespace-nowrap">
                    Ekspor Laporan Umur Stok
                </a>
            </div>
        </x-page-header>
    </div>

    <div class="grid grid-cols-1 @if($selectedProductId) lg:grid-cols-2 @endif gap-6">
        <div class="bg-white p-6 shadow-md rounded-lg flex flex-col">
             <h3 class="font-bold text-xl mb-4 text-gray-800">Stok per Produk</h3>
            <div class="flex-grow overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">SKU</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Stok</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($stockSummary as $stock)
                            <tr wire:click="showDetails({{ $stock->id }}, '{{ addslashes($stock->name) }}')"
                                class="hover:bg-blue-50 cursor-pointer {{ $selectedProductId == $stock->id ? 'bg-blue-100' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap font-semibold">{{ $stock->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $stock->sku }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-lg text-gray-800">{{ number_format($stock->total_quantity) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500">Tidak ada stok ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $stockSummary->links() }}</div>
        </div>

        @if ($selectedProductId)
            <div class="bg-white p-6 shadow-md rounded-lg flex flex-col animate-fade-in-down">
                 <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-xl text-gray-800">Detail Batch untuk: <span class="text-blue-600">{{ $selectedProductName }}</span></h3>
                    <button wire:click="clearDetails" class="text-gray-500 text-2xl leading-none">&times;</button>
                </div>
                <div class="flex-grow overflow-y-auto max-h-96">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 sticky top-0">
                             <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">LPN</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lokasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl. Terima</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($batchDetails as $batch)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-blue-600">{{ $batch->lpn }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $batch->location->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $batch->quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $batch->received_date->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada batch untuk produk ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>