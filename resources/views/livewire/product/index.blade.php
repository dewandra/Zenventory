<div class="flex h-full flex-col space-y-4">
    {{-- KARTU HEADER --}}
    <div class="flex-shrink-0 rounded-lg bg-white p-6 shadow-md">
        <x-page-header title="Manajemen Produk">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari produk..." class="w-full sm:w-64 px-4 py-2 border rounded-md shadow-sm">
            @can('manage products')
                <button @click="$dispatch('open-modal', 'product-form')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg whitespace-nowrap">
                    Tambah Produk
                </button>
            @endcan
        </x-page-header>
    </div>

    {{-- KARTU KONTEN --}}
    <div class="flex flex-1 flex-col rounded-lg bg-white p-6 shadow-md">
        <x-modal name="product-form" :show="$errors->isNotEmpty()" focusable>
            <form wire:submit.prevent="store" class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ $productId ? 'Edit Produk' : 'Buat Produk Baru' }}
                </h2>

                <div class="mt-6 space-y-4">
                    <div>
                        <x-input-label for="sku" value="SKU (Kode Produk):" />
                        <x-text-input id="sku" wire:model="sku" class="mt-1 block w-full" />
                        @error('sku') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-input-label for="name" value="Nama Produk:" />
                        <x-text-input id="name" wire:model="name" class="mt-1 block w-full" />
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-input-label for="description" value="Deskripsi:" />
                        <textarea id="description" wire:model="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        Batal
                    </x-secondary-button>
                    <x-primary-button class="ms-3">
                        {{ $productId ? 'Perbarui' : 'Simpan' }}
                    </x-primary-button>
                </div>
            </form>
        </x-modal>

        <div class="flex-grow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                        @can('manage products')
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($products as $product)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $product->sku }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $product->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ Str::limit($product->description, 50) }}</td>
                            @can('manage products')
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="edit({{ $product->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                <button wire:click="confirmDelete({{ $product->id }})" class="text-red-600 hover:text-red-900 ml-4">Hapus</button>
                            </td>
                            @endcan
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">Tidak ada produk ditemukan.</td>
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