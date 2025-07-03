<div>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h1 class="text-2xl font-semibold text-gray-900">
                Manajemen Lokasi Gudang
            </h1>
            <div class="flex items-center space-x-4">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari lokasi..." class="w-full sm:w-64 px-4 py-2 border rounded-md shadow-sm">
                @can('manage locations')
                {{-- Tombol ini sekarang menggunakan Alpine.js untuk dispatch event --}}
                <button x-data @click="$dispatch('open-modal', 'location-form')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg whitespace-nowrap">
                    Tambah Lokasi
                </button>
                @endcan
            </div>
        </div>
    </x-slot>

    {{-- Gunakan komponen <x-modal> --}}
    <x-modal name="location-form" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit.prevent="store" class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ $locationId ? 'Edit Lokasi' : 'Buat Lokasi Baru' }}
            </h2>

            <div class="mt-6 space-y-4">
                <div>
                    <x-input-label for="name" value="Nama Lokasi (Unik):" />
                    <x-text-input id="name" wire:model="name" class="mt-1 block w-full" placeholder="Contoh: Z1-A01-R01-B01" />
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="zone" value="Zone:" />
                        <x-text-input id="zone" wire:model="zone" class="mt-1 block w-full" />
                    </div>
                    <div>
                        <x-input-label for="aisle" value="Aisle (Lorong):" />
                        <x-text-input id="aisle" wire:model="aisle" class="mt-1 block w-full" />
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="rack" value="Rack (Rak):" />
                        <x-text-input id="rack" wire:model="rack" class="mt-1 block w-full" />
                    </div>
                    <div>
                        <x-input-label for="bin" value="Bin (Ambalan):" />
                        <x-text-input id="bin" wire:model="bin" class="mt-1 block w-full" />
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Batal
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ $locationId ? 'Perbarui' : 'Simpan' }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

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
                            <button wire:click="confirmDelete({{ $location->id }})" class="text-red-600 hover:text-red-900 ml-4">Hapus</button>
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