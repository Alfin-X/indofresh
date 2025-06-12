<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dasbor Analitik AI
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
                                <div class="text-sm font-medium text-gray-500">Total Transaksi</div>
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
                                <div class="text-sm font-medium text-gray-500">Total Pendapatan</div>
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
                                <div class="text-sm font-medium text-gray-500">Rata-rata Transaksi</div>
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
                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Produk Aktif</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $productAnalytics['category_performance']->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Growth -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-medium mb-4">Pertumbuhan Pendapatan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">Rp {{ number_format($revenueAnalytics['current_month'], 0, ',', '.') }}</div>
                            <div class="text-sm text-gray-500">Bulan Ini</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">Rp {{ number_format($revenueAnalytics['previous_month'], 0, ',', '.') }}</div>
                            <div class="text-sm text-gray-500">Bulan Sebelumnya</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold {{ $revenueAnalytics['growth_rate'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $revenueAnalytics['growth_rate'] >= 0 ? '+' : '' }}{{ number_format($revenueAnalytics['growth_rate'], 1) }}%
                            </div>
                            <div class="text-sm text-gray-500">Tingkat Pertumbuhan</div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Stock Prediction Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">📦 Prediksi & Rekomendasi Stok</h3>
                        <button onclick="updateStockPrediction()" id="updateStockBtn" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                            🔄 Perbarui Analisis
                        </button>
                    </div>

                    <!-- Summary Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white text-sm">📊</span>
                                </div>
                                <div>
                                    <div class="text-sm text-blue-600">Produk Dianalisis</div>
                                    <div class="text-xl font-bold text-blue-900">{{ $stockPrediction['summary']['total_products_analyzed'] }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white text-sm">🚨</span>
                                </div>
                                <div>
                                    <div class="text-sm text-red-600">Stok Kritis</div>
                                    <div class="text-xl font-bold text-red-900">{{ $stockPrediction['summary']['critical_stock_products'] }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-200">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white text-sm">⚠️</span>
                                </div>
                                <div>
                                    <div class="text-sm text-yellow-600">Perlu Perhatian</div>
                                    <div class="text-xl font-bold text-yellow-900">{{ $stockPrediction['summary']['high_urgency_products'] }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white text-sm">💰</span>
                                </div>
                                <div>
                                    <div class="text-sm text-green-600">Investasi Disarankan</div>
                                    <div class="text-lg font-bold text-green-900">Rp {{ number_format($stockPrediction['summary']['total_recommended_investment'], 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stock Recommendations for ALL Fruits -->
                    @if(count($stockPrediction['recommendations']) > 0)
                        <div class="mb-6">
                            <h4 class="text-md font-medium mb-3 text-gray-900">🍎 Rekomendasi Stok Semua Buah untuk Bulan Berikutnya</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($stockPrediction['recommendations'] as $rec)
                                    <div class="border rounded-lg p-4
                                        {{ $rec['urgency'] === 'critical' ? 'border-red-300 bg-red-50' : '' }}
                                        {{ $rec['urgency'] === 'high' ? 'border-yellow-300 bg-yellow-50' : '' }}
                                        {{ $rec['urgency'] === 'medium' ? 'border-blue-300 bg-blue-50' : '' }}
                                        {{ $rec['urgency'] === 'low' ? 'border-green-300 bg-green-50' : '' }}">
                                        <div class="flex justify-between items-start mb-2">
                                            <span class="font-medium text-gray-900">{{ $rec['product_name'] }}</span>
                                            <span class="px-2 py-1 text-xs rounded-full
                                                {{ $rec['urgency'] === 'critical' ? 'bg-red-200 text-red-800' : '' }}
                                                {{ $rec['urgency'] === 'high' ? 'bg-yellow-200 text-yellow-800' : '' }}
                                                {{ $rec['urgency'] === 'medium' ? 'bg-blue-200 text-blue-800' : '' }}
                                                {{ $rec['urgency'] === 'low' ? 'bg-green-200 text-green-800' : '' }}">
                                                {{ strtoupper($rec['urgency']) }}
                                            </span>
                                        </div>
                                        <div class="text-sm text-gray-600 space-y-1 mb-3">
                                            <div>Stok saat ini: <span class="font-medium">{{ $rec['current_stock'] }} kg</span></div>
                                            <div>Penjualan harian: <span class="font-medium">{{ $rec['daily_sales_rate'] }} kg/hari</span></div>
                                            <div>Perkiraan habis dalam:
                                                <span class="font-medium {{ $rec['days_until_stockout'] <= 7 ? 'text-red-600' : ($rec['days_until_stockout'] <= 14 ? 'text-yellow-600' : 'text-green-600') }}">
                                                    {{ $rec['days_until_stockout'] > 999 ? '∞' : number_format($rec['days_until_stockout'], 1) }} hari
                                                </span>
                                            </div>
                                        </div>
                                        <div class="border-t pt-3">
                                            <div class="text-center">
                                                <div class="text-lg font-bold text-green-600">{{ $rec['recommended_reorder'] }} kg</div>
                                                <div class="text-sm text-gray-500">Rekomendasi order bulan depan</div>
                                                <div class="text-sm text-gray-600">≈ Rp {{ number_format($rec['recommended_reorder'] * $rec['price'], 0, ',', '.') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Detailed Analysis -->
                    <div class="border-t pt-4">
                        <h4 class="text-md font-medium mb-3 text-gray-900">📈 Analisis Detail Semua Produk</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Penjualan/Hari</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hari Tersisa</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rekomendasi</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($stockPrediction['predictions'] as $pred)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $pred['product_name'] }}</div>
                                                <div class="text-xs text-gray-500">{{ $pred['product_id'] }}</div>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-900">{{ $pred['current_stock'] }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-900">{{ $pred['daily_sales_rate'] }}</td>
                                            <td class="px-4 py-3 text-sm">
                                                <span class="{{ $pred['days_until_stockout'] <= 7 ? 'text-red-600 font-medium' : 'text-gray-900' }}">
                                                    {{ $pred['days_until_stockout'] > 999 ? '∞' : number_format($pred['days_until_stockout'], 1) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-900">{{ $pred['recommended_reorder'] }} unit</td>
                                            <td class="px-4 py-3">
                                                <span class="px-2 py-1 text-xs rounded-full
                                                    {{ $pred['urgency'] === 'critical' ? 'bg-red-100 text-red-800' : '' }}
                                                    {{ $pred['urgency'] === 'high' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $pred['urgency'] === 'medium' ? 'bg-blue-100 text-blue-800' : '' }}
                                                    {{ $pred['urgency'] === 'low' ? 'bg-green-100 text-green-800' : '' }}">
                                                    {{ strtoupper($pred['urgency']) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Analysis Info -->
                    <div class="mt-4 p-3 bg-gray-50 rounded border">
                        <div class="text-xs text-gray-600">
                            <strong>Metodologi:</strong> Analisis berdasarkan penjualan {{ $stockPrediction['summary']['analysis_period'] }} terakhir.
                            Lead time diasumsikan 7 hari dengan safety factor 1.5x.
                            Terakhir diperbarui: {{ \Carbon\Carbon::parse($stockPrediction['summary']['last_updated'])->locale('id')->format('d M Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Monthly Fruit Sales Chart -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium mb-4">Penjualan Buah Bulanan (6 Bulan Terakhir)</h3>
                        <canvas id="monthlyFruitSalesChart" width="400" height="200"></canvas>
                    </div>
                </div>

                <!-- Payment Methods Chart -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium mb-4">Metode Pembayaran</h3>
                        <canvas id="paymentMethodsChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- All Fruits Performance -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-medium mb-4">📊 Performa Semua Buah</h3>
                    <div class="space-y-3">
                        @foreach($productAnalytics['all_fruits'] as $product)
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="font-medium">{{ $product->product_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $product->total_sold }} kg terjual | Stok: {{ $product->stock }} kg</div>
                                </div>
                                <div class="text-right">
                                    <div class="font-medium">Rp {{ number_format($product->total_revenue, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Low Stock Alert -->
            @if($productAnalytics['low_stock']->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium mb-4 text-red-600">Peringatan Stok Rendah</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($productAnalytics['low_stock'] as $product)
                                <div class="border border-red-200 rounded p-3 bg-red-50">
                                    <div class="font-medium">{{ $product->nama }}</div>
                                    <div class="text-sm text-red-600">Hanya {{ $product->stock }} tersisa di stok</div>
                                    <div class="text-sm text-gray-500">{{ $product->keterangan }}</div>
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
        // Monthly Fruit Sales Chart
        fetch('{{ route("admin.ai.chart-data") }}?type=monthly_fruit_sales')
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('monthlyFruitSalesChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: data.datasets
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Penjualan Buah per Bulan (kg)'
                            },
                            legend: {
                                display: true,
                                position: 'top'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Jumlah (kg)'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Bulan'
                                }
                            }
                        },
                        interaction: {
                            mode: 'index',
                            intersect: false,
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



        // Notification function
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
                type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
            }`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <span class="mr-2">${type === 'success' ? '✅' : '❌'}</span>
                    <span>${message}</span>
                </div>
            `;

            document.body.appendChild(notification);

            // Remove notification after 3 seconds
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Stock Prediction Update Function
        function updateStockPrediction() {
            const updateBtn = document.getElementById('updateStockBtn');
            const originalText = updateBtn.innerHTML;

            // Show loading state
            updateBtn.innerHTML = '⏳ Menganalisis...';
            updateBtn.disabled = true;

            fetch('{{ route("admin.ai.chart-data") }}?type=stock_prediction', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                showNotification('Analisis stok berhasil diperbarui!', 'success');

                // Reload the page to show new analysis
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error memperbarui analisis stok. Silakan coba lagi.', 'error');
            })
            .finally(() => {
                // Restore button state
                updateBtn.innerHTML = originalText;
                updateBtn.disabled = false;
            });
        }


    </script>
</x-app-layout>
