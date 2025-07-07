<div class="space-y-6">
    <div class="bg-white p-8 rounded-xl shadow-lg max-w-4xl mx-auto">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Stock Adjustment</h2>
            <p class="mt-1 text-sm text-gray-600">Use this feature to correct stock quantities if there is a discrepancy between system data and physical count.</p>
        </div>

        <form wire:submit.prevent="search" class="flex items-center gap-x-4">
            <div class="flex-grow">
                <x-text-input type="text" wire:model="searchLpn" id="searchLpn" class="w-full text-lg" placeholder="Enter LPN to be adjusted..." />
                @error('searchLpn') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <button type="submit" wire:loading.attr="disabled" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg text-lg">Search LPN</button>
        </form>

        @if ($selectedBatch)
            <form wire:submit.prevent="submitAdjustment">
                <div class="mt-8 border-t pt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="font-semibold text-lg">Product Information</h3>
                        <p class="mt-2"><strong>LPN:</strong> {{ $selectedBatch->lpn }}</p>
                        <p><strong>Product:</strong> {{ $selectedBatch->product->name }} ({{ $selectedBatch->product->sku }})</p>
                        <p><strong>Location:</strong> {{ $selectedBatch->location->name }}</p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg">Quantity Adjustment</h3>
                        <div class="mt-2">
                            <x-input-label for="current_quantity" value="System On-Hand Quantity" />
                            <x-text-input id="current_quantity" type="number" class="mt-1 block w-full bg-gray-100" value="{{ $selectedBatch->quantity }}" disabled />
                        </div>
                         <div class="mt-4">
                            <x-input-label for="newQuantity" value="Actual Quantity (Physical Count)" />
                            <x-text-input id="newQuantity" type="number" wire:model="newQuantity" class="mt-1 block w-full text-xl font-bold" />
                             @error('newQuantity') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                 <div class="mt-6 border-t pt-6">
                     <x-input-label for="reason" value="Reason for Adjustment" />
                        <select wire:model="reason" id="reason" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">-- Select a Reason --</option>
                            <option value="Cycle Count Result">Cycle Count Result</option>
                            <option value="Damaged Goods">Damaged Goods</option>
                            <option value="Shrinkage (Lost Goods)">Shrinkage (Lost Goods)</option>
                            <option value="Found Extra Stock">Found Extra Stock</option>
                            <option value="Input Error Correction">Input Error Correction</option>
                        </select>
                     @error('reason') <p class="text-red-500 text-xs mt-1">{{ $message }}</p @enderror
                </div>

                <div class="mt-8 flex items-center justify-end gap-x-6 border-t pt-6">
                    <button type="button" wire:click="resetAll" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
                    <button type="submit" wire:loading.attr="disabled" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-8 rounded-lg text-base">
                        Save Adjustment
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>