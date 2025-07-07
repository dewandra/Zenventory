<div class="flex h-full flex-col space-y-4">
    {{-- HEADER CARD --}}
    <div class="flex-shrink-0 rounded-xl bg-white p-6 shadow-lg">
        <x-page-header title="Inbound History">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by LPN, Product Name, or SKU..." class="w-full sm:w-80 px-4 py-2 border rounded-md shadow-sm">
        </x-page-header>
    </div>

    {{-- CONTENT CARD / TABLE --}}
    <div class="flex flex-1 flex-col rounded-xl bg-white p-6 shadow-lg">
        <div class="flex-grow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">LPN</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Received Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expiry Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($batches as $batch)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold text-blue-600">{{ $batch->lpn }}</td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-800">
                                {{ $batch->product->name }}
                                <span class="block text-sm text-gray-500">{{ $batch->product->sku }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $batch->quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $batch->location->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $batch->received_date->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                {{ $batch->expiry_date ? $batch->expiry_date->format('d M Y') : 'N/A' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                No inbound history found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex-shrink-0">
            {{ $batches->links() }}
        </div>
    </div>
</div>