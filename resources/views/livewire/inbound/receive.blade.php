<div class="space-y-6">
    {{-- KARTU FORMULIR SEKARANG MENJADI SATU-SATUNYA ELEMEN UTAMA --}}
    <div class="bg-white p-8 rounded-xl shadow-lg max-w-3xl mx-auto">

        {{-- JUDUL DIPINDAHKAN KE DALAM KARTU --}}
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Receive New Stock</h2>
            <p class="mt-1 text-sm text-gray-600">Enter the details of the incoming products to add them to the inventory.</p>
        </div>

        <form wire:submit.prevent="receiveProduct" class="space-y-8">
            {{-- Langkah 1: Detail Produk --}}
            <div class="border-t border-gray-200 pt-8">
                <h3 class="text-lg font-semibold leading-7 text-gray-900">Step 1: Product Information</h3>
                <p class="mt-1 text-sm text-gray-600">Find the product you are receiving and specify the quantity.</p>

                <div class="mt-6 grid grid-cols-1 gap-y-6 sm:grid-cols-6">
                    {{-- Product Search --}}
                    <div class="sm:col-span-4">
                        <label for="searchProduct" class="block text-sm font-medium leading-6 text-gray-900">Product</label>
                        <div class="mt-2">
                            <x-text-input type="text" wire:model.live.debounce.300ms="searchProduct" id="searchProduct" placeholder="Search by name or SKU..." class="w-full" />
                            @if(strlen($searchProduct) > 2 && $products->count() > 0)
                                <div class="mt-2 border border-gray-300 rounded-md shadow-sm max-h-48 overflow-y-auto bg-white z-10">
                                    @foreach($products as $product)
                                        <div wire:click="$set('productId', {{ $product->id }}); $set('searchProduct', '{{ addslashes($product->name) }} ({{ $product->sku }})'); $set('products', [])"
                                            class="p-3 hover:bg-blue-50 cursor-pointer border-b border-gray-200 last:border-b-0 {{ $productId == $product->id ? 'bg-blue-100 font-semibold' : '' }}">
                                            {{ $product->name }} <span class="text-gray-500">({{ $product->sku }})</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            @error('productId') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Quantity --}}
                    <div class="sm:col-span-2">
                        <label for="quantity" class="block text-sm font-medium leading-6 text-gray-900">Quantity</label>
                        <div class="mt-2">
                            <x-text-input type="number" wire:model.lazy="quantity" id="quantity" class="w-full" placeholder="e.g., 100" />
                            @error('quantity') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Expiry Date --}}
                    <div class="sm:col-span-3">
                        <label for="expiry_date" class="block text-sm font-medium leading-6 text-gray-900">Expiry Date <span class="text-gray-500 font-normal">(Optional)</span></label>
                        <div class="mt-2">
                            <x-text-input type="date" wire:model.lazy="expiry_date" id="expiry_date" class="w-full" />
                            @error('expiry_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Langkah 2: Detail Lokasi --}}
            <div class="border-t border-gray-200 pt-8">
                <h3 class="text-lg font-semibold leading-7 text-gray-900">Step 2: Placement</h3>
                <p class="mt-1 text-sm text-gray-600">Select the destination location for this batch.</p>

                <div class="mt-6 grid grid-cols-1 gap-y-6 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                        <label for="searchLocation" class="block text-sm font-medium leading-6 text-gray-900">Put-away Location</label>
                        <div class="mt-2">
                            <x-text-input type="text" wire:model.live.debounce.300ms="searchLocation" id="searchLocation" placeholder="Search location name (e.g., A-01-R01-B01)" class="w-full" />
                            @if(strlen($searchLocation) > 1 && $locations->count() > 0)
                                <div class="mt-2 border border-gray-300 rounded-md shadow-sm max-h-48 overflow-y-auto bg-white z-10">
                                    @foreach($locations as $location)
                                        <div wire:click="$set('locationId', {{ $location->id }}); $set('searchLocation', '{{ $location->name }}'); $set('locations', [])"
                                            class="p-3 hover:bg-blue-50 cursor-pointer border-b border-gray-200 last:border-b-0 {{ $locationId == $location->id ? 'bg-blue-100 font-semibold' : '' }}">
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
                <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg transition duration-150 ease-in-out shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Confirm & Add to Inventory
                </button>
            </div>
        </form>
    </div>
</div>