<div class="space-y-6">
    <div class="bg-white p-6 shadow-md rounded-lg">
        <x-page-header title="Manajemen Sales Order">
            <button wire:click="create" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                + Buat Pesanan Baru
            </button>
        </x-page-header>
    </div>

    <x-modal name="order-form" max-width="4xl" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit.prevent="store" class="p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                {{ $orderId ? 'Edit Pesanan' : 'Buat Pesanan Baru' }}
            </h2>

            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <x-input-label for="order_number" value="Nomor Pesanan (SO)" />
                        <x-text-input id="order_number" wire:model="order_number" class="mt-1 block w-full" />
                        @error('order_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-input-label for="customer_name" value="Nama Pelanggan" />
                        <x-text-input id="customer_name" wire:model="customer_name" class="mt-1 block w-full" />
                        @error('customer_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-input-label for="status" value="Status" />
                        <select wire:model="status" id="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                         @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="border-t pt-6">
                    <h3 class="font-semibold text-lg">Detail Produk</h3>
                    @error('details') <div class="text-red-500 text-sm mt-2">{{ $message }}</div> @enderror

                    <div class="mt-4 space-y-4">
                        @foreach ($details as $index => $detail)
                            <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-md" wire:key="detail-{{ $index }}">
                                <div class="flex-grow relative">
                                    <x-input-label value="Produk" />
                                    <x-text-input type="text"
                                        wire:model.live.debounce.300ms="details.{{ $index }}.product_name"
                                        placeholder="Ketik untuk mencari produk..."
                                        class="w-full mt-1" />
                                    @if(!empty($products) && $errors->isEmpty())
                                    <div class="absolute z-10 w-full bg-white border rounded-md mt-1 max-h-48 overflow-y-auto">
                                        @foreach($products as $product)
                                        <div wire:click="selectProduct({{ $index }}, {{ $product->id }}, '{{ addslashes($product->name) }}')" class="p-2 hover:bg-gray-100 cursor-pointer">
                                            {{ $product->name }} ({{ $product->sku }})
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                     @error('details.'.$index.'.product_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div style="width: 120px;">
                                    <x-input-label value="Jumlah" />
                                    <x-text-input type="number" wire:model="details.{{ $index }}.quantity_requested" class="w-full mt-1" />
                                    @error('details.'.$index.'.quantity_requested') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="pt-7">
                                    <button type="button" wire:click="removeDetail({{ $index }})" class="text-red-500 hover:text-red-700">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" wire:click="addDetail" class="mt-4 text-sm text-blue-600 hover:underline">+ Tambah Produk</button>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                <x-primary-button class="ms-3">{{ $orderId ? 'Perbarui' : 'Simpan' }}</x-primary-button>
            </div>
        </form>
    </x-modal>

    <div class="bg-white p-6 shadow-md rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nomor SO</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelanggan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($orders as $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold">{{ $order->order_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->customer_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($order->status == 'completed') bg-green-100 text-green-800
                                    @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada pesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $orders->links() }}</div>
    </div>
</div>