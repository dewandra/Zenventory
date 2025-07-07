<div class="space-y-6">
    <div class="bg-white p-8 rounded-xl shadow-lg max-w-4xl mx-auto">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Cycle Counting</h2>
                <p class="mt-1 text-sm text-gray-600">Maintain stock accuracy by performing periodic physical counts.</p>
            </div>
        </div>

        @if (!$activeCycleCount)
            <div class="text-center">
                <p class="mb-4">There are no active counting sessions. Start a new session to count a few random locations.</p>
                <button wire:click="startNewCycle" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg text-lg">
                    Start New Counting Session
                </button>
            </div>
        @else
            <div>
                <h3 class="font-semibold text-lg">Active Session: {{ $activeCycleCount->reference_number }}</h3>
                <p class="text-sm text-gray-500">Please physically count the items in the following locations and enter the quantities.</p>
                
                <div class="mt-6 space-y-4">
                    @foreach ($itemsToCount as $index => $item)
                        <div class="grid grid-cols-3 gap-4 items-center p-4 rounded-md bg-gray-50">
                            <div>
                                <label class="block text-xs text-gray-500">Location & Product</label>
                                <span class="font-bold block">{{ $item['location_name'] }}</span>
                                <span class="text-sm">{{ $item['product_name'] }}</span>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500">System Stock</label>
                                <span class="font-bold text-lg">{{ $item['system_quantity'] }}</span>
                            </div>
                            <div>
                                <label for="count-{{ $item['id'] }}" class="block text-xs text-gray-500">Physical Count Quantity</label>
                                <x-text-input type="number" wire:model.defer="itemsToCount.{{ $index }}.counted_quantity" id="count-{{ $item['id'] }}" class="w-full mt-1 text-lg font-bold" />
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 flex justify-end gap-4">
                    <button wire:click="resetAll" type="button" class="text-gray-600">Cancel</button>
                    <button wire:click="saveCounts" type="button" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
                        Save Count Results
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>