<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('AI Analytics Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Sales Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Total Transactions</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $salesData['total_transactions'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Total Revenue</div>
                                <div class="text-2xl font-bold text-gray-900">Rp {{ number_format($salesData['total_revenue'], 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Average Transaction</div>
                                <div class="text-2xl font-bold text-gray-900">Rp {{ number_format($salesData['average_transaction'], 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Unique Customers</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $customerAnalytics['total_unique_customers'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Growth -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-medium mb-4">Revenue Growth</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">Rp {{ number_format($revenueAnalytics['current_month'], 0, ',', '.') }}</div>
                            <div class="text-sm text-gray-500">This Month</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">Rp {{ number_format($revenueAnalytics['previous_month'], 0, ',', '.') }}</div>
                            <div class="text-sm text-gray-500">Previous Month</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold {{ $revenueAnalytics['growth_rate'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $revenueAnalytics['growth_rate'] >= 0 ? '+' : '' }}{{ number_format($revenueAnalytics['growth_rate'], 1) }}%
                            </div>
                            <div class="text-sm text-gray-500">Growth Rate</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Daily Sales Chart -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium mb-4">Daily Sales (Last 7 Days)</h3>
                        <canvas id="dailySalesChart" width="400" height="200"></canvas>
                    </div>
                </div>

                <!-- Payment Methods Chart -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium mb-4">Payment Methods</h3>
                        <canvas id="paymentMethodsChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- Best Selling Products -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium mb-4">Best Selling Products</h3>
                        <div class="space-y-3">
                            @foreach($productAnalytics['best_selling']->take(5) as $product)
                                <div class="flex justify-between items-center">
                                    <div>
                                        <div class="font-medium">{{ $product->product_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $product->total_sold }} units sold</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-medium">Rp {{ number_format($product->total_revenue, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Top Customers -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium mb-4">Top Customers</h3>
                        <div class="space-y-3">
                            @foreach($customerAnalytics['top_customers']->take(5) as $customer)
                                <div class="flex justify-between items-center">
                                    <div>
                                        <div class="font-medium">{{ $customer->customer_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $customer->transaction_count }} transactions</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-medium">Rp {{ number_format($customer->total_spent, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Low Stock Alert -->
            @if($productAnalytics['low_stock']->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium mb-4 text-red-600">Low Stock Alert</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($productAnalytics['low_stock'] as $product)
                                <div class="border border-red-200 rounded p-3 bg-red-50">
                                    <div class="font-medium">{{ $product->name }}</div>
                                    <div class="text-sm text-red-600">Only {{ $product->stock }} left in stock</div>
                                    <div class="text-sm text-gray-500">{{ $product->category }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Daily Sales Chart
        fetch('{{ route("admin.ai.chart-data") }}?type=daily_sales')
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('dailySalesChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Daily Sales',
                            data: data.data,
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });

        // Payment Methods Chart
        fetch('{{ route("admin.ai.chart-data") }}?type=payment_methods')
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('paymentMethodsChart').getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            data: data.data,
                            backgroundColor: [
                                'rgb(59, 130, 246)',
                                'rgb(16, 185, 129)',
                                'rgb(245, 158, 11)',
                                'rgb(239, 68, 68)'
                            ]
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });
            });
    </script>
</x-app-layout>
