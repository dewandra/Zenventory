<div class="space-y-6">
    <div class="bg-white p-8 rounded-xl shadow-lg max-w-5xl mx-auto">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Outbound Order History</h2>
            <p class="mt-1 text-sm text-gray-600">Search for an order number to see its details and picklist history.</p>
        </div>

        <form wire:submit.prevent="search" class="mb-6">
            <div class="flex items-center gap-x-4">
                <div class="flex-grow">
                    <x-text-input type="text" wire:model="searchTerm" id="searchTerm" class="w-full text-lg" placeholder="Enter Sales Order Number..." />
                    @error('searchTerm') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <button type="submit" wire:loading.attr="disabled" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg text-lg">
                    Search
                </button>
            </div>
        </form>

        @if ($foundOrder)
            <div class="border-t border-gray-200 pt-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Order Details: {{ $foundOrder->order_number }}</h3>
                        <p class="text-sm text-gray-600">Customer: <span class="font-medium">{{ $foundOrder->customer_name ?? 'N/A' }}</span> | Status: <span class="font-medium text-green-600">{{ ucfirst($foundOrder->status) }}</span></p>
                    </div>
                    <button wire:click="resetSearch" class="text-sm text-blue-600 hover:underline">Search Another</button>
                </div>

                {{-- Picklist Section --}}
                @forelse ($picklists as $picklist)
                    <div class="mt-6 border border-gray-200 p-4 rounded-lg">
                        <div class="flex justify-between items-center">
                            <h4 class="text-lg font-semibold text-gray-700">Picklist: {{ $picklist->picklist_number }}</h4>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $picklist->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($picklist->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500">Created on: {{ $picklist->created_at->format('d M Y, H:i') }}</p>

                        <table class="min-w-full divide-y divide-gray-300 mt-4">
                            <thead>
                                <tr>
                                    <th class="py-2 text-left text-sm font-semibold text-gray-900">Location</th>
                                    <th class="py-2 text-left text-sm font-semibold text-gray-900">Product</th>
                                    <th class="py-2 text-left text-sm font-semibold text-gray-900">LPN</th>
                                    <th class="py-2 text-center text-sm font-semibold text-gray-900">Quantity</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($picklist->items as $item)
                                    <tr>
                                        <td class="py-2 font-bold">{{ $item->location_name }}</td>
                                        <td class="py-2">{{ $item->product_name }}</td>
                                        <td class="py-2 text-gray-600">{{ $item->lpn }}</td>
                                        <td class="py-2 text-center font-bold text-blue-600">{{ $item->quantity_to_pick }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @empty
                    <div class="mt-6 text-center text-gray-500 border-dashed border-2 p-4 rounded-lg">
                        No picklist history for this order.
                    </div>
                @endforelse
            </div>
        @endif
    </div>
</div>