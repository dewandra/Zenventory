<div class="space-y-6">
    <div class="bg-white p-8 rounded-xl shadow-lg max-w-4xl mx-auto">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Lacak Riwayat LPN (License Plate Number)</h2>
            <p class="mt-1 text-sm text-gray-600">Masukkan LPN untuk melihat seluruh jejak pergerakan stok dari awal hingga akhir.</p>
        </div>

        <form wire:submit.prevent="trace" class="flex items-center gap-x-4">
            <div class="flex-grow">
                <x-text-input type="text" wire:model="searchLpn" id="searchLpn" class="w-full text-lg" placeholder="Contoh: 20240705-001" />
                @error('searchLpn') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <button type="submit" wire:loading.attr="disabled" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg text-lg">Lacak</button>
        </form>

        @if ($batchInfo)
            <div class="mt-8 border-t pt-6">
                <h3 class="text-xl font-semibold text-gray-800">Detail LPN: {{ $batchInfo->lpn }}</h3>
                <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">Produk:</span>
                        <strong class="block text-gray-900">{{ $batchInfo->product->name }} ({{ $batchInfo->product->sku }})</strong>
                    </div>
                    <div>
                        <span class="text-gray-500">Sisa Stok Saat Ini:</span>
                        <strong class="block text-gray-900">{{ $batchInfo->quantity }} unit</strong>
                    </div>
                     <div>
                        <span class="text-gray-500">Lokasi Terakhir:</span>
                        <strong class="block text-gray-900">{{ $batchInfo->location->name }}</strong>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <h4 class="font-semibold text-gray-700 mb-4">Timeline Pergerakan</h4>
                <div class="border-l-2 border-gray-200 pl-6">
                    @foreach ($movements as $movement)
                        <div class="relative mb-8">
                            <div class="absolute -left-7 w-4 h-4 rounded-full
                                @if($movement->type == 'INBOUND') bg-blue-500
                                @elseif($movement->type == 'OUTBOUND') bg-green-500
                                @else bg-yellow-500 @endif">
                            </div>
                            <p class="text-sm text-gray-500">{{ $movement->created_at->format('d M Y, H:i') }} - oleh {{ $movement->user->name ?? 'Sistem' }}</p>
                            <h5 class="font-bold text-lg text-gray-800 mt-1">
                                {{ ucfirst(strtolower($movement->type)) }}
                                ({{ $movement->quantity_change > 0 ? '+' : '' }}{{ $movement->quantity_change }} unit)
                            </h5>
                            <p class="text-gray-600">
                                @if ($movement->type == 'INBOUND')
                                    Diterima dan ditempatkan di lokasi <span class="font-semibold">{{ $movement->toLocation->name }}</span>.
                                @elseif ($movement->type == 'OUTBOUND')
                                    Diambil dari lokasi <span class="font-semibold">{{ $movement->fromLocation->name }}</span> untuk pesanan.
                                @elseif ($movement->type == 'ADJUSTMENT')
                                    Penyesuaian stok di lokasi <span class="font-semibold">{{ $movement->toLocation->name ?? $movement->fromLocation->name }}</span>.
                                @else
                                    Pergerakan dari <span class="font-semibold">{{ $movement->fromLocation->name ?? 'N/A' }}</span> ke <span class="font-semibold">{{ $movement->toLocation->name ?? 'N/A' }}</span>.
                                @endif
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>