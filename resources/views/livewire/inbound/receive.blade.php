<div class="space-y-6">
    <div class="bg-white p-8 rounded-xl shadow-lg max-w-3xl mx-auto">

        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Penerimaan Stok Baru</h2>
            <p class="mt-1 text-sm text-gray-600">Masukkan detail produk yang masuk untuk menambahkannya ke inventaris.</p>
        </div>

        <form wire:submit.prevent="receiveProduct" class="space-y-8">
            
            {{-- Bagian Pencarian Produk --}}
            <div class="border-t border-gray-200 pt-8">
                <h3 class="text-lg font-semibold leading-7 text-gray-900">Langkah 1: Informasi Produk</h3>
                <p class="mt-1 text-sm text-gray-600">Cari produk yang Anda terima dan tentukan jumlahnya.</p>

                <div class="mt-6 grid grid-cols-1 gap-y-6 sm:grid-cols-6">
                    <div class="sm:col-span-4 relative" x-data="{ open: true }">
                        <label for="searchProduct" class="block text-sm font-medium leading-6 text-gray-900">Produk</label>
                        <div class="mt-2">
                            <x-text-input 
                                type="text" 
                                wire:model.live.debounce.300ms="searchProduct" 
                                id="searchProduct" 
                                placeholder="Cari berdasarkan nama atau SKU..." 
                                class="w-full"
                                @click.away="open = false"
                                @focus="open = true"
                            />
                            
                            {{-- Dropdown Hasil Pencarian Produk --}}
                            {{-- PERBAIKAN: Menggunakan fungsi count() PHP, bukan metode ->count() --}}
                            @if(strlen($searchProduct) > 2 && count($products) > 0)
                                <div x-show="open" class="absolute mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto z-10">
                                    @foreach($products as $product)
                                        <div 
                                            wire:click="selectProductAndClose('{{ $product->id }}', '{{ addslashes($product->name) }} ({{ $product->sku }})')"
                                            class="p-3 hover:bg-blue-50 cursor-pointer border-b border-gray-200 last:border-b-0"
                                        >
                                            {{ $product->name }} <span class="text-gray-500">({{ $product->sku }})</span>
                                        </div>
                                    @endforeach
                                </div>
                            {{-- PERBAIKAN: Menggunakan fungsi count() PHP, bukan metode ->count() --}}
                            @elseif(strlen($searchProduct) > 2 && count($products) == 0)
                                <div x-show="open" class="absolute mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg p-3 text-gray-500">
                                    Produk tidak ditemukan.
                                </div>
                            @endif

                            @error('productId') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Kuantitas & Tanggal Kedaluwarsa --}}
                    <div class="sm:col-span-2">
                        <label for="quantity" class="block text-sm font-medium leading-6 text-gray-900">Kuantitas</label>
                        <div class="mt-2">
                            <x-text-input type="number" wire:model.lazy="quantity" id="quantity" class="w-full" placeholder="e.g., 100" />
                            @error('quantity') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="sm:col-span-3">
                        <label for="expiry_date" class="block text-sm font-medium leading-6 text-gray-900">Tanggal Kedaluwarsa <span class="text-gray-500 font-normal">(Opsional)</span></label>
                        <div class="mt-2">
                            <x-text-input type="date" wire:model.lazy="expiry_date" id="expiry_date" class="w-full" />
                            @error('expiry_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bagian Lokasi --}}
            <div class="border-t border-gray-200 pt-8">
                <h3 class="text-lg font-semibold leading-7 text-gray-900">Langkah 2: Penempatan</h3>
                <p class="mt-1 text-sm text-gray-600">Pilih lokasi tujuan untuk batch ini.</p>

                <div class="mt-6 grid grid-cols-1 gap-y-6 sm:grid-cols-6">
                    <div class="sm:col-span-4 relative" x-data="{ open: true }">
                        <label for="searchLocation" class="block text-sm font-medium leading-6 text-gray-900">Lokasi Penempatan</label>
                        <div class="mt-2">
                            <x-text-input 
                                type="text" 
                                wire:model.live.debounce.300ms="searchLocation" 
                                id="searchLocation" 
                                placeholder="Cari nama lokasi (e.g., A-01-R01-B01)" 
                                class="w-full"
                                @click.away="open = false"
                                @focus="open = true"
                            />
                            {{-- PERBAIKAN: Menggunakan fungsi count() PHP, bukan metode ->count() --}}
                            @if(strlen($searchLocation) > 1 && count($locations) > 0)
                                <div x-show="open" class="absolute mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto z-10">
                                    @foreach($locations as $location)
                                        <div 
                                            wire:click="selectLocationAndClose('{{ $location->id }}', '{{ $location->name }}')"
                                            class="p-3 hover:bg-blue-50 cursor-pointer border-b border-gray-200 last:border-b-0"
                                        >
                                            {{ $location->name }}
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                             @error('locationId') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-6 flex items-center justify-end gap-x-6 border-t border-gray-200 pt-6">
                <button type="button" wire:click="resetForm" class="text-sm font-semibold leading-6 text-gray-900">Batal</button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Konfirmasi & Tambah ke Inventaris
                </button>
            </div>
        </form>
    </div>
</div>