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
        $customerAnalytics = $this->getCustomerAnalytics();
        
        return view('admin.ai.dashboard', compact(
            'salesData',
            'productAnalytics', 
            'revenueAnalytics',
            'customerAnalytics'
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
        // Best selling products
        $bestSelling = TransactionItem::select('catalog_id', 'product_name')
            ->selectRaw('SUM(quantity) as total_sold, SUM(subtotal) as total_revenue')
            ->whereHas('transaction', function($query) {
                $query->where('payment_status', 'paid');
            })
            ->groupBy('catalog_id', 'product_name')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();

        // Category performance
        $categoryPerformance = Catalog::select('category')
            ->selectRaw('COUNT(*) as product_count')
            ->whereNotNull('category')
            ->groupBy('category')
            ->get();

        // Low stock products
        $lowStock = Catalog::where('stock', '<=', 10)
            ->where('status', true)
            ->orderBy('stock')
            ->get();

        return [
            'best_selling' => $bestSelling,
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
     * Get customer analytics data
     */
    private function getCustomerAnalytics()
    {
        // Top customers by transaction count
        $topCustomers = Transaction::where('payment_status', 'paid')
            ->selectRaw('customer_name, customer_phone, COUNT(*) as transaction_count, SUM(total_amount) as total_spent')
            ->groupBy('customer_name', 'customer_phone')
            ->orderBy('total_spent', 'desc')
            ->limit(10)
            ->get();

        // New vs returning customers (simplified)
        $totalCustomers = Transaction::where('payment_status', 'paid')
            ->distinct('customer_name', 'customer_phone')
            ->count();

        return [
            'top_customers' => $topCustomers,
            'total_unique_customers' => $totalCustomers,
        ];
    }

    /**
     * Get chart data for AJAX requests
     */
    public function getChartData(Request $request)
    {
        $type = $request->get('type');
        
        switch ($type) {
            case 'daily_sales':
                return response()->json($this->getDailySalesChart());
            case 'monthly_revenue':
                return response()->json($this->getMonthlyRevenueChart());
            case 'product_categories':
                return response()->json($this->getProductCategoriesChart());
            case 'payment_methods':
                return response()->json($this->getPaymentMethodsChart());
            default:
                return response()->json(['error' => 'Invalid chart type'], 400);
        }
    }

    private function getDailySalesChart()
    {
        $data = Transaction::where('payment_status', 'paid')
            ->where('transaction_date', '>=', Carbon::now()->subDays(7))
            ->selectRaw('DATE(transaction_date) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'labels' => $data->pluck('date')->map(function($date) {
                return Carbon::parse($date)->format('M d');
            }),
            'data' => $data->pluck('count'),
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
        $data = TransactionItem::select('catalogs.category')
            ->selectRaw('SUM(transaction_items.quantity) as total_sold')
            ->join('catalogs', 'transaction_items.catalog_id', '=', 'catalogs.id')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->where('transactions.payment_status', 'paid')
            ->whereNotNull('catalogs.category')
            ->groupBy('catalogs.category')
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
}
