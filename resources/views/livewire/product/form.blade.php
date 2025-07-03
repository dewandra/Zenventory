<div class="fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50 flex animate-fade-in-down">
    <div class="relative p-8 bg-white w-full max-w-lg m-auto flex-col flex rounded-lg">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">{{ $productId ? 'Edit Produk' : 'Buat Produk Baru' }}</h2>
            <button wire:click="closeModal()" class="text-gray-700 text-3xl leading-none">&times;</button>
        </div>
        <form wire:submit.prevent="store">
            <div class="mb-4">
                <label for="sku" class="block text-gray-700 text-sm font-bold mb-2">SKU (Kode Produk):</label>
                <input type="text" id="sku" wire:model="sku" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                @error('sku') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Produk:</label>
                <input type="text" id="name" wire:model="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi:</label>
                <textarea id="description" wire:model="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"></textarea>
            </div>
            <div class="flex justify-end pt-4">
                <button type="button" wire:click="closeModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Batal
                </button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ $productId ? 'Perbarui' : 'Simpan' }}
                </button>
            </div>
        </form>
    </div>
</div>