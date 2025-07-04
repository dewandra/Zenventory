<x-app-layout>
    <div class="space-y-8">
        {{-- Header Halaman --}}
        <x-page-header title="Dashboard Overview">
            {{-- Kosongkan slot jika tidak ada tombol di kanan --}}
        </x-page-header>

        {{-- Baris Pertama KPI Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-blue-500 text-white p-6 rounded-xl shadow-lg">
                <p class="text-sm font-light text-blue-100">Total Inventory Value</p>
                <p class="text-3xl font-bold mt-1">$1,250,000</p>
                <p class="text-xs font-light text-blue-200 mt-2">Based on average cost</p>
            </div>
            <div class="bg-green-500 text-white p-6 rounded-xl shadow-lg">
                <p class="text-sm font-light text-green-100">Orders to Process</p>
                <p class="text-3xl font-bold mt-1">85</p>
                <p class="text-xs font-light text-green-200 mt-2">Pending picking & shipping</p>
            </div>
            <div class="bg-purple-500 text-white p-6 rounded-xl shadow-lg">
                <p class="text-sm font-light text-purple-100">Inbound Shipments Today</p>
                <p class="text-3xl font-bold mt-1">6</p>
                <p class="text-xs font-light text-purple-200 mt-2">Expected arrivals</p>
            </div>
        </div>

        {{-- Baris Kedua KPI Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-yellow-500 text-white p-6 rounded-xl shadow-lg">
                <p class="text-sm font-light text-yellow-100">Low Stock Items</p>
                <p class="text-3xl font-bold mt-1">7</p>
                <p class="text-xs font-light text-yellow-200 mt-2">Requires reorder</p>
            </div>
            <div class="bg-pink-500 text-white p-6 rounded-xl shadow-lg">
                <p class="text-sm font-light text-pink-100">FIFO Compliance Rate</p>
                <p class="text-3xl font-bold mt-1">98.5%</p>
                <p class="text-xs font-light text-pink-200 mt-2">Last 30 days picking accuracy</p>
            </div>
             <div class="bg-gray-700 text-white p-6 rounded-xl shadow-lg">
                <p class="text-sm font-light text-gray-200">Available Storage</p>
                <p class="text-3xl font-bold mt-1">75%</p>
                <p class="text-xs font-light text-gray-300 mt-2">Warehouse capacity used</p>
            </div>
        </div>

        {{-- Konten Utama (Aktivitas & Grafik) --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                {{-- Recent Activity --}}
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <h2 class="font-bold text-xl mb-4 text-gray-800">Recent Activity</h2>
                    <ul class="space-y-4">
                        <li class="flex items-start space-x-3">
                            {{-- Ikon baru untuk 'Received' --}}
                            <div class="bg-blue-100 p-2 rounded-full"><svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v4m-6-4H6a2 2 0 01-2-2V7a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2h-2m-4-4h4m-4-8h4" /></svg></div>
                            <div>
                                <p class="text-gray-800">Received 50 units of Product A <span class="font-bold">(Batch #20230315-001)</span></p>
                                <p class="text-sm text-gray-500">Location: A-102 | 10 mins ago</p>
                            </div>
                        </li>
                         <li class="flex items-start space-x-3">
                             {{-- Ikon baru untuk 'Picked' --}}
                            <div class="bg-green-100 p-2 rounded-full"><svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z" /></svg></div>
                            <div>
                                <p class="text-gray-800">Picked 10 units of Product B <span class="font-bold">(Batch #20230201-003)</span> for Order #ORD002</p>
                                <p class="text-sm text-gray-500">Location: B-205 | 30 mins ago</p>
                            </div>
                        </li>
                         <li class="flex items-start space-x-3">
                           <div class="bg-yellow-100 p-2 rounded-full"><svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg></div>
                            <div>
                                <p class="text-gray-800">Stock adjusted for Product C: <span class="font-bold">-5 units (Damage)</span></p>
                                <p class="text-sm text-gray-500">Location: C-301 | 1 hour ago</p>
                            </div>
                        </li>
                    </ul>
                </div>
                
                {{-- Top 5 Slow-Moving Items (Sesuai Mockup) --}}
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <h2 class="font-bold text-xl mb-4 text-gray-800">Top 5 Slow-Moving Items</h2>
                    <ul class="space-y-4">
                        {{-- Data statis sebagai contoh --}}
                        <li class="space-y-1">
                            <p class="text-sm font-medium text-gray-600 flex justify-between"><span>Product Z (SKU006)</span> <span>25 units/month</span></p>
                            <div class="w-full bg-gray-200 rounded-full h-2.5"><div class="bg-red-400 h-2.5 rounded-full" style="width: 25%"></div></div>
                        </li>
                        <li class="space-y-1">
                            <p class="text-sm font-medium text-gray-600 flex justify-between"><span>Product Y (SKU005)</span> <span>35 units/month</span></p>
                            <div class="w-full bg-gray-200 rounded-full h-2.5"><div class="bg-red-400 h-2.5 rounded-full" style="width: 35%"></div></div>
                        </li>
                        <li class="space-y-1">
                            <p class="text-sm font-medium text-gray-600 flex justify-between"><span>Product X (SKU004)</span> <span>45 units/month</span></p>
                            <div class="w-full bg-gray-200 rounded-full h-2.5"><div class="bg-yellow-400 h-2.5 rounded-full" style="width: 45%"></div></div>
                        </li>
                        <li class="space-y-1">
                            <p class="text-sm font-medium text-gray-600 flex justify-between"><span>Product C (SKU003)</span> <span>55 units/month</span></p>
                            <div class="w-full bg-gray-200 rounded-full h-2.5"><div class="bg-yellow-400 h-2.5 rounded-full" style="width: 55%"></div></div>
                        </li>
                        <li class="space-y-1">
                            <p class="text-sm font-medium text-gray-600 flex justify-between"><span>Product F (SKU009)</span> <span>65 units/month</span></p>
                            <div class="w-full bg-gray-200 rounded-full h-2.5"><div class="bg-green-400 h-2.5 rounded-full" style="width: 65%"></div></div>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Grafik Volume Mingguan --}}
            <div class="bg-white p-6 rounded-xl shadow-lg">
                <h2 class="font-bold text-xl mb-4 text-gray-800">Weekly Inbound/Outbound Volume</h2>
                <div class="h-64 flex items-end space-x-2">
                    {{-- Representasi visual sederhana dari grafik batang --}}
                    <div class="flex-1 h-3/4 bg-blue-400 rounded-t-lg"></div>
                    <div class="flex-1 h-2/4 bg-blue-400 rounded-t-lg"></div>
                    <div class="flex-1 h-full bg-blue-400 rounded-t-lg"></div>
                    <div class="flex-1 h-3/5 bg-blue-400 rounded-t-lg"></div>
                    <div class="flex-1 h-5/6 bg-blue-400 rounded-t-lg"></div>
                    <div class="flex-1 h-1/2 bg-blue-400 rounded-t-lg"></div>
                    <div class="flex-1 h-4/5 bg-blue-400 rounded-t-lg"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">Note: For a real application, a charting library like Chart.js would be used here.</p>
            </div>
        </div>
    </div>
</x-app-layout>