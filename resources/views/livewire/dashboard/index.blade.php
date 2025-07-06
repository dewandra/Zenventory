<div class="space-y-8">
    {{-- Header Row --}}
    <div class="flex flex-col md:flex-row md:justify-between md:items-center">
        <h1 class="text-2xl font-semibold text-gray-900">Dashboard Overview</h1>
        <span class="text-sm text-gray-500">Data as of: {{ now()->format('d M Y, H:i') }}</span>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-blue-600 text-white p-6 rounded-xl shadow-lg">
            <p class="text-sm font-light text-blue-200 uppercase tracking-wider">Pending Orders</p>
            <p class="text-4xl font-bold mt-2">{{ number_format($totalOrdersPending) }}</p>
            <p class="text-xs font-light text-blue-200 mt-1">Orders to be allocated</p>
        </div>

        <div class="bg-yellow-500 text-white p-6 rounded-xl shadow-lg">
            <p class="text-sm font-light text-yellow-100 uppercase tracking-wider">Low Stock Items</p>
            <p class="text-4xl font-bold mt-2">{{ number_format($lowStockItemsCount) }}</p>
            <p class="text-xs font-light text-yellow-100 mt-1">Products below the threshold</p>
        </div>

        <div class="bg-green-500 text-white p-6 rounded-xl shadow-lg">
            <p class="text-sm font-light text-green-200 uppercase tracking-wider">Units Received Today</p>
            <p class="text-4xl font-bold mt-2">{{ number_format($inboundToday) }}</p>
            <p class="text-xs font-light text-green-200 mt-1">Total units received today</p>
        </div>
    </div>
    
    {{-- Main Chart Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-lg">
            <h3 class="font-semibold text-gray-800">Warehouse Activity (Last 7 Days)</h3>
            <div id="inbound-outbound-chart" class="mt-4"></div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg">
            <h3 class="font-semibold text-gray-800">Top 5 Products</h3>
            <div id="top-products-chart" class="mt-4"></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // The script for chart initialization remains the same.
    document.addEventListener('livewire:init', () => {
        
        function initInboundOutboundChart(data) {
            const options = {
                chart: { type: 'area', height: 350, toolbar: { show: false } },
                series: data.series,
                xaxis: { categories: data.categories },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth' },
                colors: ['#3B82F6', '#10B981'],
                fill: { type: 'gradient', gradient: { opacityFrom: 0.6, opacityTo: 0.05 } },
                legend: { position: 'top', horizontalAlign: 'left' }
            };
            const chart = new ApexCharts(document.querySelector("#inbound-outbound-chart"), options);
            chart.render();
        }

        function initTopProductsChart(data) {
            const options = {
                chart: { type: 'donut', height: 350 },
                series: data.series,
                labels: data.labels,
                legend: { position: 'bottom' },
                responsive: [{ breakpoint: 480, options: { chart: { width: 200 }, legend: { position: 'bottom' } } }]
            };
            const chart = new ApexCharts(document.querySelector("#top-products-chart"), options);
            chart.render();
        }

        initInboundOutboundChart(@json($inboundOutboundData));
        initTopProductsChart(@json($topProductsData));
    });
</script>
@endpush