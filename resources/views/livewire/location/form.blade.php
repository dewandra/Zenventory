<div class="fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50 flex animate-fade-in-down">
    <div class="relative p-8 bg-white w-full max-w-lg m-auto flex-col flex rounded-lg">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">{{ $locationId ? 'Edit Lokasi' : 'Buat Lokasi Baru' }}</h2>
            <button wire:click="closeModal()" class="text-gray-700 text-3xl leading-none">&times;</button>
        </div>
        <form wire:submit.prevent="store">
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Lokasi (Unik):</label>
                <input type="text" id="name" wire:model="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" placeholder="Contoh: A-01-01-A">
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="zone" class="block text-gray-700 text-sm font-bold mb-2">Zone:</label>
                    <input type="text" id="zone" wire:model="zone" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                </div>
                 <div class="mb-4">
                    <label for="aisle" class="block text-gray-700 text-sm font-bold mb-2">Aisle (Lorong):</label>
                    <input type="text" id="aisle" wire:model="aisle" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                </div>
            </div>
             <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="rack" class="block text-gray-700 text-sm font-bold mb-2">Rack (Rak):</label>
                    <input type="text" id="rack" wire:model="rack" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                </div>
                 <div class="mb-4">
                    <label for="bin" class="block text-gray-700 text-sm font-bold mb-2">Bin (Ambalan):</label>
                    <input type="text" id="bin" wire:model="bin" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                </div>
            </div>
            <div class="flex justify-end pt-4">
                <button type="button" wire:click="closeModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Batal
                </button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ $locationId ? 'Perbarui' : 'Simpan' }}
                </button>
            </div>
        </form>
    </div>
</div>