<div>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h1 class="text-2xl font-semibold text-gray-900">
                Manajemen Lokasi Gudang
            </h1>
            <div class="flex items-center space-x-4">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari lokasi..." class="w-full sm:w-64 px-4 py-2 border rounded-md shadow-sm">
                @can('manage locations')
                <button wire:click="create" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg whitespace-nowrap">
                    Tambah Lokasi
                </button>
                @endcan
            </div>
        </div>
    </x-slot>

    @if($isOpen)
    <div class="fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50 flex">
        <div class="relative p-8 bg-white w-full max-w-lg m-auto flex-col flex rounded-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">{{ $locationId ? 'Edit Lokasi' : 'Buat Lokasi Baru' }}</h2>
                <button wire:click="closeModal" class="text-gray-700 text-3xl leading-none">&times;</button>
            </div>
            <form wire:submit="store">
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
                    <button type="button" wire:click="closeModal" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                        Batal
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{ $locationId ? 'Perbarui' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Tabel Data --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lokasi</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Zone</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aisle</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rack</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bin</th>
                    @can('manage locations')
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    @endcan
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($locations as $location)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold">{{ $location->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $location->zone }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $location->aisle }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $location->rack }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $location->bin }}</td>
                        @can('manage locations')
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button wire:click="edit({{ $location->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                            <button wire:click="delete({{ $location->id }})" onclick="return confirm('Anda yakin ingin menghapus lokasi ini?')" class="text-red-600 hover:text-red-900 ml-4">Hapus</button>
                        </td>
                        @endcan
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">Tidak ada lokasi ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $locations->links() }}
    </div>
</div>