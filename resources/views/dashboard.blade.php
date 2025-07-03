<x-app-layout>
    <div class="space-y-8">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Overview</h1>

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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white p-6 rounded-xl shadow-lg">
                    <h2 class="font-bold text-xl mb-4 text-gray-800">Recent Activity</h2>
                    <ul class="space-y-4">
                        <li class="flex items-start space-x-3">
                            <div class="bg-blue-100 p-2 rounded-full"><svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg></div>
                            <div>
                                <p class="text-gray-800">Received 50 units of Product A <span class="font-bold">(Batch #20230315-001)</span></p>
                                <p class="text-sm text-gray-500">Location: A-102 | 10 mins ago</p>
                            </div>
                        </li>
                         <li class="flex items-start space-x-3">
                            <div class="bg-green-100 p-2 rounded-full"><svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z"></path></svg></div>
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
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg">
                <h2 class="font-bold text-xl mb-4 text-gray-800">Weekly Inbound/Outbound Volume</h2>
                <div class="h-64 flex items-end space-x-2">
                    <div class="flex-1 h-3/4 bg-blue-400 rounded-t-lg"></div>
                    <div class="flex-1 h-2/4 bg-blue-400 rounded-t-lg"></div>
                    <div class="flex-1 h-full bg-blue-400 rounded-t-lg"></div>
                    <div class="flex-1 h-3/5 bg-blue-400 rounded-t-lg"></div>
                    <div class="flex-1 h-5/6 bg-blue-400 rounded-t-lg"></div>
                    <div class="flex-1 h-1/2 bg-blue-400 rounded-t-lg"></div>
                    <div class="flex-1 h-4/5 bg-blue-400 rounded-t-lg"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">Note: For a real application, a charting library like Chart.js or D3.js would be used here.</p>
            </div>
        </div>
    </div>
</x-app-layout>