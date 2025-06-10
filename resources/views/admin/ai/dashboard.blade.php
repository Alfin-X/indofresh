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
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Pelanggan Unik</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $customerAnalytics['total_unique_customers'] }}</div>
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

            <!-- AI Fruit Prediction Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">🤖 Prediksi Penjualan Buah AI</h3>
                        <button onclick="updatePrediction()" id="updateBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                            🔄 Perbarui Prediksi
                        </button>
                    </div>

                    <div id="predictionContent">
                        @if($fruitPrediction['status'] === 'success')
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                <!-- Main Prediction -->
                                <div class="lg:col-span-2">
                                    <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-lg p-6 border border-green-200">
                                        <div class="flex items-center mb-4">
                                            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mr-4">
                                                <span class="text-2xl">🍎</span>
                                            </div>
                                            <div>
                                                <h4 class="text-xl font-bold text-gray-900">Prediksi Penjualan Berikutnya</h4>
                                                <p class="text-sm text-gray-600">Berdasarkan analisis penjualan 30 hari</p>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <div class="text-3xl font-bold text-green-600 mb-2">
                                                {{ $fruitPrediction['prediction']['predicted_fruit'] }}
                                            </div>
                                            <div class="flex items-center mb-3">
                                                <span class="text-sm text-gray-600 mr-2">Kepercayaan:</span>
                                                <div class="flex-1 bg-gray-200 rounded-full h-2 mr-2">
                                                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $fruitPrediction['prediction']['confidence'] * 100 }}%"></div>
                                                </div>
                                                <span class="text-sm font-medium">{{ number_format($fruitPrediction['prediction']['confidence'] * 100, 1) }}%</span>
                                            </div>
                                        </div>

                                        <div class="bg-white rounded p-4 border-l-4 border-blue-500">
                                            <h5 class="font-medium text-gray-900 mb-2">💡 Alasan AI</h5>
                                            <p class="text-sm text-gray-700">{{ $fruitPrediction['prediction']['reasoning'] }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Top Predictions -->
                                <div>
                                    <h5 class="font-medium text-gray-900 mb-3">📊 3 Prediksi Teratas</h5>
                                    <div class="space-y-3">
                                        @foreach($fruitPrediction['prediction']['top_predictions'] as $index => $pred)
                                            <div class="bg-gray-50 rounded-lg p-3 border">
                                                <div class="flex justify-between items-center">
                                                    <div>
                                                        <span class="font-medium text-gray-900">{{ $index + 1 }}. {{ $pred['fruit'] }}</span>
                                                        @if(isset($pred['recent_sales']))
                                                            <div class="text-xs text-gray-500">{{ $pred['recent_sales'] }} penjualan terbaru</div>
                                                        @endif
                                                    </div>
                                                    <div class="text-right">
                                                        <div class="text-sm font-medium">{{ number_format($pred['confidence'] * 100, 1) }}%</div>
                                                        @if(isset($pred['sales_trend']) && $pred['sales_trend'] != 0)
                                                            <div class="text-xs {{ $pred['sales_trend'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                                {{ $pred['sales_trend'] > 0 ? '↗' : '↘' }} {{ number_format(abs($pred['sales_trend'] * 100), 1) }}%
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Data Summary -->
                                    @if(isset($fruitPrediction['data_summary']))
                                        <div class="mt-4 p-3 bg-blue-50 rounded border">
                                            <h6 class="text-sm font-medium text-blue-900 mb-2">📋 Data Analisis</h6>
                                            <div class="text-xs text-blue-700 space-y-1">
                                                <div>Transaksi: {{ $fruitPrediction['data_summary']['total_transactions'] }}</div>
                                                <div>Buah Unik: {{ $fruitPrediction['data_summary']['unique_fruits'] }}</div>
                                                @if($fruitPrediction['data_summary']['date_range']['start'])
                                                    <div>Periode: {{ \Carbon\Carbon::parse($fruitPrediction['data_summary']['date_range']['start'])->locale('id')->format('d M') }} - {{ \Carbon\Carbon::parse($fruitPrediction['data_summary']['date_range']['end'])->locale('id')->format('d M') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @elseif($fruitPrediction['status'] === 'error')
                            <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                                <div class="flex items-center mb-3">
                                    <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-white">⚠</span>
                                    </div>
                                    <h4 class="text-lg font-medium text-red-900">Error Prediksi</h4>
                                </div>
                                <p class="text-red-700 mb-3">{{ $fruitPrediction['message'] }}</p>
                                <p class="text-sm text-red-600">{{ $fruitPrediction['prediction']['reasoning'] }}</p>
                            </div>
                        @else
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                                <div class="flex items-center mb-3">
                                    <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-white">ℹ</span>
                                    </div>
                                    <h4 class="text-lg font-medium text-yellow-900">Prediksi Tidak Tersedia</h4>
                                </div>
                                <p class="text-yellow-700 mb-3">{{ $fruitPrediction['message'] }}</p>
                                <p class="text-sm text-yellow-600">{{ $fruitPrediction['prediction']['reasoning'] }}</p>
                                <button onclick="updatePrediction()" class="mt-3 bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded text-sm">
                                    Coba Buat Prediksi
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Daily Sales Chart -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium mb-4">Penjualan Harian (7 Hari Terakhir)</h3>
                        <canvas id="dailySalesChart" width="400" height="200"></canvas>
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

            <!-- Best Selling Products -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium mb-4">Produk Terlaris</h3>
                        <div class="space-y-3">
                            @foreach($productAnalytics['best_selling']->take(5) as $product)
                                <div class="flex justify-between items-center">
                                    <div>
                                        <div class="font-medium">{{ $product->product_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $product->total_sold }} unit terjual</div>
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
                        <h3 class="text-lg font-medium mb-4">Pelanggan Teratas</h3>
                        <div class="space-y-3">
                            @foreach($customerAnalytics['top_customers']->take(5) as $customer)
                                <div class="flex justify-between items-center">
                                    <div>
                                        <div class="font-medium">{{ $customer->customer_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $customer->transaction_count }} transaksi</div>
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
                        <h3 class="text-lg font-medium mb-4 text-red-600">Peringatan Stok Rendah</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($productAnalytics['low_stock'] as $product)
                                <div class="border border-red-200 rounded p-3 bg-red-50">
                                    <div class="font-medium">{{ $product->name }}</div>
                                    <div class="text-sm text-red-600">Hanya {{ $product->stock }} tersisa di stok</div>
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
                            label: 'Penjualan Harian',
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

        // AI Fruit Prediction Update Function
        function updatePrediction() {
            const updateBtn = document.getElementById('updateBtn');
            const originalText = updateBtn.innerHTML;

            // Show loading state
            updateBtn.innerHTML = '⏳ Memperbarui...';
            updateBtn.disabled = true;

            fetch('{{ route("admin.ai.predict-fruit") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    showNotification('Prediksi berhasil diperbarui!', 'success');

                    // Reload the page to show new prediction
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showNotification('Gagal memperbarui prediksi: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error memperbarui prediksi. Silakan coba lagi.', 'error');
            })
            .finally(() => {
                // Restore button state
                updateBtn.innerHTML = originalText;
                updateBtn.disabled = false;
            });
        }

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

        // Auto-update prediction every 30 minutes
        setInterval(() => {
            console.log('Auto-updating fruit prediction...');
            updatePrediction();
        }, 30 * 60 * 1000); // 30 minutes
    </script>
</x-app-layout>
