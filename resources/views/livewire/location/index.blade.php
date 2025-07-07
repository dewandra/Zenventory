<div class="flex h-full flex-col space-y-4">
    {{-- HEADER CARD --}}
    <div class="flex-shrink-0 rounded-lg bg-white p-6 shadow-md">
        <x-page-header title="Location Management">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by Location Name..." class="w-full sm:w-64 px-4 py-2 border rounded-md shadow-sm">
            @can('manage locations')
                <button @click="$dispatch('open-modal', 'location-form')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg whitespace-nowrap">
                    + Add New Location
                </button>
            @endcan
        </x-page-header>
    </div>

    {{-- CONTENT CARD --}}
    <div class="flex flex-1 flex-col rounded-lg bg-white p-6 shadow-md">
        <x-modal name="location-form" :show="$errors->isNotEmpty()" focusable>
            <form wire:submit.prevent="store" class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ $locationId ? 'Edit Location' : 'Create New Location' }}
                </h2>

                <div class="mt-6 space-y-4">
                    <div>
                        <x-input-label for="name" value="Location Name (Unique):" />
                        <x-text-input id="name" wire:model="name" class="mt-1 block w-full" placeholder="Example: Z1-A01-R01-B01" />
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="zone" value="Zone:" />
                            <x-text-input id="zone" wire:model="zone" class="mt-1 block w-full" />
                        </div>
                        <div>
                            <x-input-label for="aisle" value="Aisle:" />
                            <x-text-input id="aisle" wire:model="aisle" class="mt-1 block w-full" />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="rack" value="Rack:" />
                            <x-text-input id="rack" wire:model="rack" class="mt-1 block w-full" />
                        </div>
                        <div>
                            <x-input-label for="bin" value="Bin:" />
                            <x-text-input id="bin" wire:model="bin" class="mt-1 block w-full" />
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        Cancel
                    </x-secondary-button>
                    <x-primary-button class="ms-3">
                        {{ $locationId ? 'Update' : 'Save' }}
                    </x-primary-button>
                </div>
            </form>
        </x-modal>

        <div class="flex-grow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Zone</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aisle</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rack</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bin</th>
                        @can('manage locations')
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($locations as $location)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-800">{{ $location->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $location->zone }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $location->aisle }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $location->rack }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $location->bin }}</td>
                            @can('manage locations')
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="edit({{ $location->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                <button wire:click="confirmDelete({{ $location->id }})" class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                            </td>
                            @endcan
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">No locations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex-shrink-0">
            {{ $locations->links() }}
        </div>
    </div>
</div>