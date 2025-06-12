<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Catalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class AIController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * Show AI dashboard with analytics
     */
    public function dashboard()
    {
        // Sales analytics data
        $salesData = $this->getSalesAnalytics();
        $productAnalytics = $this->getProductAnalytics();
        $revenueAnalytics = $this->getRevenueAnalytics();
        $stockPrediction = $this->getStockPrediction();

        return view('admin.ai.dashboard', compact(
            'salesData',
            'productAnalytics',
            'revenueAnalytics',
            'stockPrediction'
        ));
    }

    /**
     * Get sales analytics data
     */
    private function getSalesAnalytics()
    {
        // Daily sales for the last 30 days
        $dailySales = Transaction::where('payment_status', 'paid')
            ->where('transaction_date', '>=', Carbon::now()->subDays(30))
            ->selectRaw('DATE(transaction_date) as date, COUNT(*) as count, SUM(total_amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Monthly sales for the last 12 months
        $monthlySales = Transaction::where('payment_status', 'paid')
            ->where('transaction_date', '>=', Carbon::now()->subMonths(12))
            ->selectRaw('YEAR(transaction_date) as year, MONTH(transaction_date) as month, COUNT(*) as count, SUM(total_amount) as total')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        return [
            'daily' => $dailySales,
            'monthly' => $monthlySales,
            'total_transactions' => Transaction::where('payment_status', 'paid')->count(),
            'total_revenue' => Transaction::where('payment_status', 'paid')->sum('total_amount'),
            'average_transaction' => Transaction::where('payment_status', 'paid')->avg('total_amount'),
        ];
    }

    /**
     * Get product analytics data
     */
    private function getProductAnalytics()
    {
        // All fruits with sales data (not just best selling)
        $allFruits = Catalog::leftJoin('transaction_items', 'catalogs.id_produk', '=', 'transaction_items.catalog_id_produk')
            ->leftJoin('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->select('catalogs.id_produk', 'catalogs.nama as product_name', 'catalogs.stock', 'catalogs.harga')
            ->selectRaw('COALESCE(SUM(CASE WHEN transactions.payment_status = "paid" THEN transaction_items.quantity ELSE 0 END), 0) as total_sold')
            ->selectRaw('COALESCE(SUM(CASE WHEN transactions.payment_status = "paid" THEN transaction_items.subtotal ELSE 0 END), 0) as total_revenue')
            ->groupBy('catalogs.id_produk', 'catalogs.nama', 'catalogs.stock', 'catalogs.harga')
            ->orderBy('total_sold', 'desc')
            ->get();

        // Category performance
        $categoryPerformance = Catalog::select('keterangan as category')
            ->selectRaw('COUNT(*) as product_count')
            ->whereNotNull('keterangan')
            ->groupBy('keterangan')
            ->get();

        // Low stock products
        $lowStock = Catalog::where('stock', '<=', 10)
            ->orderBy('stock')
            ->get();

        return [
            'all_fruits' => $allFruits,
            'category_performance' => $categoryPerformance,
            'low_stock' => $lowStock,
        ];
    }

    /**
     * Get revenue analytics data
     */
    private function getRevenueAnalytics()
    {
        // Revenue by payment method
        $revenueByPayment = Transaction::where('payment_status', 'paid')
            ->selectRaw('payment_method, COUNT(*) as count, SUM(total_amount) as total')
            ->groupBy('payment_method')
            ->get();

        // Revenue trends
        $currentMonth = Transaction::where('payment_status', 'paid')
            ->whereMonth('transaction_date', Carbon::now()->month)
            ->whereYear('transaction_date', Carbon::now()->year)
            ->sum('total_amount');

        $previousMonth = Transaction::where('payment_status', 'paid')
            ->whereMonth('transaction_date', Carbon::now()->subMonth()->month)
            ->whereYear('transaction_date', Carbon::now()->subMonth()->year)
            ->sum('total_amount');

        $growthRate = $previousMonth > 0 ? (($currentMonth - $previousMonth) / $previousMonth) * 100 : 0;

        return [
            'by_payment_method' => $revenueByPayment,
            'current_month' => $currentMonth,
            'previous_month' => $previousMonth,
            'growth_rate' => $growthRate,
        ];
    }



    /**
     * Get chart data for AJAX requests
     */
    public function getChartData(Request $request)
    {
        $type = $request->get('type');

        switch ($type) {
            case 'monthly_fruit_sales':
                return response()->json($this->getMonthlyFruitSalesChart());
            case 'monthly_revenue':
                return response()->json($this->getMonthlyRevenueChart());
            case 'product_categories':
                return response()->json($this->getProductCategoriesChart());
            case 'payment_methods':
                return response()->json($this->getPaymentMethodsChart());
            case 'stock_prediction':
                return response()->json($this->getStockPrediction());
            default:
                return response()->json(['error' => 'Invalid chart type'], 400);
        }
    }

    private function getMonthlyFruitSalesChart()
    {
        // Get monthly fruit sales data from transaction items
        $data = TransactionItem::join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->join('catalogs', 'transaction_items.catalog_id_produk', '=', 'catalogs.id_produk')
            ->where('transactions.payment_status', 'paid')
            ->where('transactions.transaction_date', '>=', Carbon::now()->subMonths(6))
            ->selectRaw('
                YEAR(transactions.transaction_date) as year,
                MONTH(transactions.transaction_date) as month,
                catalogs.nama as fruit_name,
                SUM(transaction_items.quantity) as total_kg
            ')
            ->groupBy('year', 'month', 'catalogs.nama')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Group data by month and fruit
        $monthlyData = [];
        $fruits = $data->pluck('fruit_name')->unique()->values();

        // Initialize months for last 6 months
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthKey = $date->format('Y-m');
            $monthLabel = $date->format('M Y');

            $monthlyData[$monthKey] = [
                'label' => $monthLabel,
                'data' => []
            ];

            // Initialize each fruit with 0
            foreach ($fruits as $fruit) {
                $monthlyData[$monthKey]['data'][$fruit] = 0;
            }
        }

        // Fill actual data
        foreach ($data as $item) {
            $monthKey = $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
            if (isset($monthlyData[$monthKey])) {
                $monthlyData[$monthKey]['data'][$item->fruit_name] = (float) $item->total_kg;
            }
        }

        // Prepare chart data
        $labels = array_values(array_map(function($month) {
            return $month['label'];
        }, $monthlyData));

        $datasets = [];
        $colors = [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
            '#9966FF', '#FF9F40', '#FF6384', '#C9CBCF'
        ];

        $colorIndex = 0;
        foreach ($fruits as $fruit) {
            $fruitData = [];
            foreach ($monthlyData as $month) {
                $fruitData[] = $month['data'][$fruit];
            }

            $datasets[] = [
                'label' => $fruit,
                'data' => $fruitData,
                'backgroundColor' => $colors[$colorIndex % count($colors)],
                'borderColor' => $colors[$colorIndex % count($colors)],
                'borderWidth' => 2,
                'fill' => false
            ];
            $colorIndex++;
        }

        return [
            'labels' => $labels,
            'datasets' => $datasets
        ];
    }

    private function getMonthlyRevenueChart()
    {
        $data = Transaction::where('payment_status', 'paid')
            ->where('transaction_date', '>=', Carbon::now()->subMonths(6))
            ->selectRaw('YEAR(transaction_date) as year, MONTH(transaction_date) as month, SUM(total_amount) as total')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        return [
            'labels' => $data->map(function($item) {
                return Carbon::createFromDate($item->year, $item->month, 1)->format('M Y');
            }),
            'data' => $data->pluck('total'),
        ];
    }

    private function getProductCategoriesChart()
    {
        $data = TransactionItem::select('catalogs.keterangan as category')
            ->selectRaw('SUM(transaction_items.quantity) as total_sold')
            ->join('catalogs', 'transaction_items.catalog_id_produk', '=', 'catalogs.id_produk')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->where('transactions.payment_status', 'paid')
            ->whereNotNull('catalogs.keterangan')
            ->groupBy('catalogs.keterangan')
            ->get();

        return [
            'labels' => $data->pluck('category'),
            'data' => $data->pluck('total_sold'),
        ];
    }

    private function getPaymentMethodsChart()
    {
        $data = Transaction::where('payment_status', 'paid')
            ->selectRaw('payment_method, COUNT(*) as count')
            ->groupBy('payment_method')
            ->get();

        return [
            'labels' => $data->pluck('payment_method')->map(function($method) {
                return ucfirst($method);
            }),
            'data' => $data->pluck('count'),
        ];
    }



    /**
     * Get stock prediction and recommendations for ALL fruits
     */
    private function getStockPrediction()
    {
        try {
            // Get ALL products from catalog
            $allProducts = Catalog::select('id_produk', 'nama', 'stock', 'harga', 'keterangan')
                ->get()
                ->keyBy('id_produk');

            // Get sales velocity for each product (last 30 days)
            $salesVelocity = TransactionItem::select('catalog_id_produk', 'product_name')
                ->selectRaw('SUM(quantity) as total_sold, AVG(quantity) as avg_per_transaction')
                ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
                ->where('transactions.payment_status', 'paid')
                ->where('transactions.transaction_date', '>=', Carbon::now()->subDays(30))
                ->groupBy('catalog_id_produk', 'product_name')
                ->get()
                ->keyBy('catalog_id_produk');

            $predictions = [];
            $recommendations = [];

            // Process ALL products, not just those with sales
            foreach ($allProducts as $productId => $product) {
                $salesData = $salesVelocity->get($productId);

                // Calculate daily sales rate (0 if no sales)
                $dailySalesRate = $salesData ? $salesData->total_sold / 30 : 0;
                $totalSold30Days = $salesData ? $salesData->total_sold : 0;
                $avgPerTransaction = $salesData ? $salesData->avg_per_transaction : 0;

                // Predict days until stock out
                $daysUntilStockOut = $product->stock > 0 && $dailySalesRate > 0
                    ? $product->stock / $dailySalesRate
                    : 999;

                // Calculate recommended reorder quantity
                // Formula: (daily_sales_rate * lead_time_days * safety_factor) + buffer_stock
                $leadTimeDays = 7; // Assume 7 days lead time
                $safetyFactor = 1.5; // 50% safety buffer
                $bufferStock = 10; // Minimum buffer stock

                $recommendedReorder = ceil(($dailySalesRate * $leadTimeDays * $safetyFactor) + $bufferStock);

                // Determine urgency level
                $urgency = 'low';
                if ($daysUntilStockOut <= 3) {
                    $urgency = 'critical';
                } elseif ($daysUntilStockOut <= 7) {
                    $urgency = 'high';
                } elseif ($daysUntilStockOut <= 14) {
                    $urgency = 'medium';
                }

                $prediction = [
                    'product_id' => $productId,
                    'product_name' => $product->nama,
                    'current_stock' => $product->stock,
                    'daily_sales_rate' => round($dailySalesRate, 2),
                    'days_until_stockout' => round($daysUntilStockOut, 1),
                    'recommended_reorder' => $recommendedReorder,
                    'urgency' => $urgency,
                    'category' => $product->keterangan,
                    'price' => $product->harga,
                    'total_sold_30days' => $totalSold30Days,
                    'avg_per_transaction' => round($avgPerTransaction, 2)
                ];

                $predictions[] = $prediction;

                // Add ALL products to recommendations (not just urgent ones)
                $recommendations[] = $prediction;
            }

            // Sort predictions by urgency and days until stockout
            usort($predictions, function($a, $b) {
                $urgencyOrder = ['critical' => 1, 'high' => 2, 'medium' => 3, 'low' => 4];

                if ($urgencyOrder[$a['urgency']] !== $urgencyOrder[$b['urgency']]) {
                    return $urgencyOrder[$a['urgency']] - $urgencyOrder[$b['urgency']];
                }

                return $a['days_until_stockout'] - $b['days_until_stockout'];
            });

            // Sort recommendations by urgency
            usort($recommendations, function($a, $b) {
                $urgencyOrder = ['critical' => 1, 'high' => 2, 'medium' => 3, 'low' => 4];
                return $urgencyOrder[$a['urgency']] - $urgencyOrder[$b['urgency']];
            });

            // Calculate summary statistics
            $totalProducts = count($predictions);
            $criticalProducts = count(array_filter($predictions, fn($p) => $p['urgency'] === 'critical'));
            $highUrgencyProducts = count(array_filter($predictions, fn($p) => $p['urgency'] === 'high'));
            $totalRecommendedValue = array_sum(array_map(fn($r) => $r['recommended_reorder'] * $r['price'], $recommendations));

            return [
                'predictions' => $predictions,
                'recommendations' => $recommendations, // ALL recommendations for all fruits
                'summary' => [
                    'total_products_analyzed' => $totalProducts,
                    'critical_stock_products' => $criticalProducts,
                    'high_urgency_products' => $highUrgencyProducts,
                    'total_recommended_investment' => $totalRecommendedValue,
                    'analysis_period' => '30 days',
                    'last_updated' => Carbon::now()->format('Y-m-d H:i:s')
                ]
            ];

        } catch (\Exception $e) {
            \Log::error('Stock prediction error', ['error' => $e->getMessage()]);

            return [
                'predictions' => [],
                'recommendations' => [],
                'summary' => [
                    'total_products_analyzed' => 0,
                    'critical_stock_products' => 0,
                    'high_urgency_products' => 0,
                    'total_recommended_investment' => 0,
                    'analysis_period' => '30 days',
                    'last_updated' => Carbon::now()->format('Y-m-d H:i:s'),
                    'error' => 'Unable to generate stock predictions'
                ]
            ];
        }
    }


}
