<div class="space-y-6">
    <div class="bg-white p-8 rounded-xl shadow-lg max-w-4xl mx-auto">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Return Management</h2>
            <p class="mt-1 text-sm text-gray-600">Process items returned by customers to determine whether to restock or scrap them.</p>
        </div>

        @if (!$selectedReturn)
            <h3 class="font-semibold text-lg">Returns Awaiting Processing</h3>
            <div class="mt-4 space-y-3">
                @forelse ($returns as $return)
                    <div wire:click="selectReturn({{ $return->id }})" class="p-4 border rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-200">
                        <div class="flex justify-between">
                            <p class="font-bold text-blue-600">{{ $return->return_number }}</p>
                            <p class="text-xs text-gray-500">{{ $return->created_at->format('d M Y') }}</p>
                        </div>
                        <p class="text-sm text-gray-600">Customer: {{ $return->customer_name }} | Item Count: {{ $return->items->count() }}</p>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-gray-500">There are no returns to process at the moment. 🎉</p>
                    </div>
                @endforelse
            </div>
        @else
            <div>
                <div class="flex justify-between items-center">
                    <h3 class="font-semibold text-lg">Processing Return: <span class="text-blue-600">{{ $selectedReturn->return_number }}</span></h3>
                    <button wire:click="resetAll" class="text-sm text-blue-600 hover:underline">← Back to List</button>
                </div>
                
                <div class="mt-6 space-y-4">
                    @foreach ($selectedReturn->items as $item)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center bg-gray-50 p-4 rounded-lg border">
                            <div>
                                <p class="font-bold">{{ $item->product->name }}</p>
                                <p class="text-sm text-gray-500">Return Quantity: <span class="font-semibold">{{ $item->quantity }}</span></p>
                            </div>
                            <div class="col-span-2">
                                <label for="disposition-{{ $item->id }}" class="block text-xs text-gray-600">Action (Disposition)</label>
                                <select wire:model="itemsToProcess.{{ $item->id }}.disposition" id="disposition-{{ $item->id }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                                    <option value="">-- Select Action --</option>
                                    <option value="restock">Restock Item</option>
                                    <option value="damage">Scrap Item (Damaged)</option>
                                </select>
                            </div>
                        </div>
                    @endforeach
                </div>
                 <div class="mt-8 flex justify-end">
                    <button wire:click="processReturn" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
                        Complete Return Process
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>