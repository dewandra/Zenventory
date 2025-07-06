<div class="space-y-6">
    <div class="bg-white p-8 rounded-xl shadow-lg max-w-5xl mx-auto">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Riwayat Pesanan Keluar</h2>
            <p class="mt-1 text-sm text-gray-600">Cari nomor pesanan untuk melihat detail dan riwayat picklist.</p>
        </div>

        <form wire:submit.prevent="search" class="mb-6">
            <div class="flex items-center gap-x-4">
                <div class="flex-grow">
                    <x-text-input type="text" wire:model="searchTerm" id="searchTerm" class="w-full text-lg" placeholder="Masukkan Nomor Sales Order..." />
                    @error('searchTerm') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <button type="submit" wire:loading.attr="disabled" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg text-lg">
                    Cari
                </button>
            </div>
        </form>

        @if ($foundOrder)
            <div class="border-t border-gray-200 pt-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Detail Pesanan: {{ $foundOrder->order_number }}</h3>
                        <p class="text-sm text-gray-600">Customer: <span class="font-medium">{{ $foundOrder->customer_name ?? 'N/A' }}</span> | Status: <span class="font-medium text-green-600">{{ ucfirst($foundOrder->status) }}</span></p>
                    </div>
                    <button wire:click="resetSearch" class="text-sm text-blue-600 hover:underline">Cari Lagi</button>
                </div>

                {{-- Bagian Picklist --}}
                @forelse ($picklists as $picklist)
                    <div class="mt-6 border border-gray-200 p-4 rounded-lg">
                        <div class="flex justify-between items-center">
                            <h4 class="text-lg font-semibold text-gray-700">Picklist: {{ $picklist->picklist_number }}</h4>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $picklist->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($picklist->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500">Dibuat pada: {{ $picklist->created_at->format('d M Y, H:i') }}</p>

                        <table class="min-w-full divide-y divide-gray-300 mt-4">
                            <thead>
                                <tr>
                                    <th class="py-2 text-left text-sm font-semibold text-gray-900">Lokasi</th>
                                    <th class="py-2 text-left text-sm font-semibold text-gray-900">Produk</th>
                                    <th class="py-2 text-left text-sm font-semibold text-gray-900">LPN</th>
                                    <th class="py-2 text-center text-sm font-semibold text-gray-900">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($picklist->items as $item)
                                    <tr>
                                        <td class="py-2 font-bold">{{ $item->location_name }}</td>
                                        <td class="py-2">{{ $item->product_name }}</td>
                                        <td class="py-2 text-gray-600">{{ $item->lpn }}</td>
                                        <td class="py-2 text-center font-bold text-blue-600">{{ $item->quantity_to_pick }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @empty
                    <div class="mt-6 text-center text-gray-500 border-dashed border-2 p-4 rounded-lg">
                        Tidak ada riwayat picklist untuk pesanan ini.
                    </div>
                @endforelse
            </div>
        @endif
    </div>
</div>