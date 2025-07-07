<div class="space-y-6">
    <div class="bg-white p-8 rounded-xl shadow-lg max-w-5xl mx-auto">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Outbound Allocation & Picking</h2>
            <p class="mt-1 text-sm text-gray-600">Search for an order number to start the stock allocation process.</p>
        </div>

        <div class="mb-6">
            <div class="flex items-center gap-x-4">
                <div class="flex-grow">
                    <label for="searchOrder" class="sr-only">Search Order Number</label>
                    <x-text-input type="text" wire:model.live="searchOrder" wire:keydown.enter="search" id="searchOrder" class="w-full text-lg" placeholder="Enter Sales Order Number..." />
                    @error('searchOrder') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <button type="button" wire:click="search" wire:loading.attr="disabled" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg text-lg">
                    <span wire:loading.remove wire:target="search">Search</span>
                    <span wire:loading wire:target="search">Searching...</span>
                </button>
            </div>
        </div>
        
        @if ($selectedOrder)
            <div class="border-t border-gray-200 pt-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Order Details: {{ $selectedOrder->order_number }}</h3>
                        <p class="text-sm text-gray-600">Customer: <span class="font-medium">{{ $selectedOrder->customer_name ?? 'N/A' }}</span> | Status: <span class="font-medium text-yellow-600">{{ ucfirst($selectedOrder->status) }}</span></p>
                    </div>
                    <button wire:click="resetAll" class="text-sm text-blue-600 hover:underline">Search Another Order</button>
                </div>
                
                <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                    <h4 class="font-semibold text-gray-700">Order Items:</h4>
                    <ul class="mt-2 space-y-2 list-disc list-inside">
                        @foreach ($selectedOrder->details as $detail)
                            <li><span class="font-bold">{{ $detail->quantity_requested }}</span> units - {{ $detail->product->name }} ({{ $detail->product->sku }})</li>
                        @endforeach
                    </ul>
                </div>

                @if (!$activePicklist)
                    <div class="mt-6 flex justify-end items-center">
                         @if ($allocationError)
                            <p class="text-sm text-red-600 font-semibold mr-4 animate-pulse">{{ $allocationError }}</p>
                        @endif
                        <button wire:click="generatePicklist" wire:loading.attr="disabled" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg text-base">
                            <span wire:loading.remove wire:target="generatePicklist">🚀 Generate Picklist</span>
                            <span wire:loading wire:target="generatePicklist">Processing...</span>
                        </button>
                    </div>
                @endif
            </div>
        @endif
        
        @if ($activePicklist)
            <div class="border-t border-gray-200 mt-6 pt-6 print-section">
                <div class="flex justify-between items-center no-print">
                    <div>
                        <h3 class="text-xl font-semibold leading-7 text-gray-900">✅ Picklist Created: {{ $activePicklist->picklist_number }}</h3>
                        <p class="text-sm text-gray-500">Status: <span class="font-semibold">{{ ucfirst($activePicklist->status) }}</span></p>
                    </div>
                    <button onclick="window.print()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg">🖨️ Print</button>
                </div>
                <div class="mt-6 flow-root">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                            <tr>
                                <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Location</th>
                                <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Product</th>
                                <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">LPN</th>
                                <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Quantity to Pick</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($activePicklist->items as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-lg font-bold text-gray-900 sm:pl-0">{{ $item->location_name }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-800">
                                        {{ $item->product_name }}
                                        <span class="block text-xs text-gray-500">{{ $item->product_sku }}</span>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $item->lpn }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-2xl font-bold text-blue-600 text-center">{{ $item->quantity_to_pick }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($activePicklist->status != 'completed')
                <div class="mt-8 flex items-center justify-end gap-x-6 border-t border-gray-200 pt-6 no-print">
                    <button type="button" wire:click="resetAll" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
                    <button type="button" wire:click="confirmPicking" wire:loading.attr="disabled" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg text-base">
                        Confirm Picking Complete
                    </button>
                </div>
                @endif
            </div>
        @endif
    </div>
    <style>
        @media print {
            .no-print { display: none; }
            body { margin: 0; }
            .print-section {
                box-shadow: none;
                border: none;
            }
        }
    </style>
</div>