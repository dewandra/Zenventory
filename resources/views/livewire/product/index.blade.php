<div class="flex h-full flex-col space-y-4">
    {{-- KARTU HEADER --}}
    <div class="flex-shrink-0 rounded-lg bg-white p-6 shadow-md">
        {{-- Mengubah judul, placeholder, dan teks tombol sesuai mockup --}}
        <x-page-header title="Inventory Management">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by Item Name, SKU, Batch..." class="w-full sm:w-64 px-4 py-2 border rounded-md shadow-sm">
            @can('manage products')
                <button @click="$dispatch('open-modal', 'product-form')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg whitespace-nowrap">
                    + Add New Item
                </button>
            @endcan
        </x-page-header>
    </div>

    {{-- KARTU KONTEN --}}
    <div class="flex flex-1 flex-col rounded-lg bg-white p-6 shadow-md">
        <x-modal name="product-form" :show="$errors->isNotEmpty()" focusable>
            {{-- Form tidak diubah karena tidak ada di mockup --}}
            <form wire:submit.prevent="store" class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ $productId ? 'Edit Item' : 'Create New Item' }}
                </h2>

                <div class="mt-6 space-y-4">
                    <div>
                        <x-input-label for="sku" value="SKU (Stock Keeping Unit):" />
                        <x-text-input id="sku" wire:model="sku" class="mt-1 block w-full" />
                        @error('sku') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-input-label for="name" value="Item Name:" />
                        <x-text-input id="name" wire:model="name" class="mt-1 block w-full" />
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-input-label for="description" value="Description:" />
                        <textarea id="description" wire:model="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        Cancel
                    </x-secondary-button>
                    <x-primary-button class="ms-3">
                        {{ $productId ? 'Update' : 'Save' }}
                    </x-primary-button>
                </div>
            </form>
        </x-modal>

        <div class="flex-grow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    {{-- Mengubah semua kolom header tabel sesuai mockup --}}
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batch/Lot</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Received Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        @can('manage products')
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php
                        // Karena data ini tidak ada di model Product, kita buat placeholder
                        $placeholderData = [
                            ['batch' => '20230105-002', 'qty' => 45, 'loc' => 'A-101', 'date' => '2023-01-05', 'status' => 'Available', 'status_color' => 'green'],
                            ['batch' => '20230201-003', 'qty' => 70, 'loc' => 'B-205', 'date' => '2023-02-01', 'status' => 'Available', 'status_color' => 'green'],
                            ['batch' => '20230315-001', 'qty' => 50, 'loc' => 'A-102', 'date' => '2023-03-15', 'status' => 'Available', 'status_color' => 'green'],
                            ['batch' => '20230210-001', 'qty' => 25, 'loc' => 'C-301', 'date' => '2023-02-10', 'status' => 'Low Stock', 'status_color' => 'yellow'],
                        ];
                    @endphp
                    @forelse ($products as $index => $product)
                        @php
                            $p_data = $placeholderData[$index % count($placeholderData)];
                        @endphp
                        <tr>
                            {{-- Mengubah semua kolom data tabel sesuai mockup --}}
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-800">{{ $product->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $product->sku }}</td>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold text-blue-600 underline cursor-pointer">{{ $p_data['batch'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $p_data['qty'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $p_data['loc'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $p_data['date'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($p_data['status'] == 'Available') bg-green-100 text-green-800 @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ $p_data['status'] }}
                                </span>
                            </td>
                            @can('manage products')
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="edit({{ $product->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                <button wire:click="confirmDelete({{ $product->id }})" class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                            </td>
                            @endcan
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">No items found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex-shrink-0">
            {{ $products->links() }}
        </div>
    </div>
</div>