<div class="space-y-6">
    <div class="bg-white p-8 rounded-xl shadow-lg max-w-4xl mx-auto">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Cycle Counting (Hitungan Siklus)</h2>
                <p class="mt-1 text-sm text-gray-600">Jaga akurasi stok dengan melakukan perhitungan fisik secara berkala.</p>
            </div>
        </div>

        @if (!$activeCycleCount)
            <div class="text-center">
                <p class="mb-4">Tidak ada sesi hitungan yang aktif. Mulai sesi baru untuk menghitung beberapa lokasi acak.</p>
                <button wire:click="startNewCycle" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg text-lg">
                    Mulai Sesi Hitungan Baru
                </button>
            </div>
        @else
            <div>
                <h3 class="font-semibold text-lg">Sesi Aktif: {{ $activeCycleCount->reference_number }}</h3>
                <p class="text-sm text-gray-500">Silakan hitung fisik barang di lokasi berikut dan masukkan jumlahnya.</p>
                
                <div class="mt-6 space-y-4">
                    @foreach ($itemsToCount as $index => $item)
                        <div class="grid grid-cols-3 gap-4 items-center p-4 rounded-md bg-gray-50">
                            <div>
                                <label class="block text-xs text-gray-500">Lokasi & Produk</label>
                                <span class="font-bold block">{{ $item['location_name'] }}</span>
                                <span class="text-sm">{{ $item['product_name'] }}</span>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500">Stok Sistem</label>
                                <span class="font-bold text-lg">{{ $item['system_quantity'] }}</span>
                            </div>
                            <div>
                                <label for="count-{{ $item['id'] }}" class="block text-xs text-gray-500">Jumlah Hitungan Fisik</label>
                                <x-text-input type="number" wire:model.defer="itemsToCount.{{ $index }}.counted_quantity" id="count-{{ $item['id'] }}" class="w-full mt-1 text-lg font-bold" />
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 flex justify-end gap-4">
                    <button wire:click="resetAll" type="button" class="text-gray-600">Batalkan</button>
                    <button wire:click="saveCounts" type="button" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
                        Simpan Hasil Hitungan
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>