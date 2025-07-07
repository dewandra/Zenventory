<div class="flex h-full flex-col space-y-4">
    {{-- HEADER CARD --}}
    <div class="flex-shrink-0 rounded-lg bg-white p-6 shadow-md">
        <x-page-header title="Product Management">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by Name or SKU..." class="w-full sm:w-64 px-4 py-2 border rounded-md shadow-sm">
            @can('manage products')
                <button @click="$dispatch('open-modal', 'product-form')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg whitespace-nowrap">
                    + Add New Product
                </button>
            @endcan
        </x-page-header>
    </div>

    {{-- CONTENT CARD --}}
    <div class="flex flex-1 flex-col rounded-lg bg-white p-6 shadow-md">
        {{-- Modal Form --}}
        <x-modal name="product-form" :show="$errors->isNotEmpty()" focusable>
            <form wire:submit.prevent="store" class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ $productId ? 'Edit Product' : 'Create New Product' }}
                </h2>

                <div class="mt-6 space-y-4">
                    <div>
                        <x-input-label for="sku" value="SKU (Stock Keeping Unit):" />
                        <x-text-input id="sku" wire:model="sku" class="mt-1 block w-full" />
                        @error('sku') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-input-label for="name" value="Product Name:" />
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

        {{-- Table --}}
        <div class="flex-grow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        @can('manage products')
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($products as $product)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-800">{{ $product->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $product->sku }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ Str::limit($product->description, 50) }}</td>
                            @can('manage products')
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="edit({{ $product->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                <button wire:click="confirmDelete({{ $product->id }})" class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                            </td>
                            @endcan
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">No products found.</td>
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