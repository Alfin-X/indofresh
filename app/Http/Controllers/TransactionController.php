<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Catalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Allow both admin and employee to access all transaction methods
        $this->middleware(function ($request, $next) {
            $user = auth()->user();

            // Allow access for both admin and employee
            if ($user->isAdmin() || $user->isEmployee()) {
                return $next($request);
            }

            abort(403, 'Unauthorized access. Only admin and employee can access transactions.');
        });
    }

    /**
     * Display a listing of transactions
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $transactions = Transaction::with('creator', 'items')->latest()->paginate(15);
            return view('admin.transactions.index', compact('transactions'));
        } else {
            $transactions = Transaction::with('creator', 'items')
                ->where('created_by', $user->id)
                ->latest()
                ->paginate(15);
            return view('employee.transactions.index', compact('transactions'));
        }
    }

    /**
     * Show the form for creating a new transaction
     */
    public function create()
    {
        $catalogs = Catalog::active()->inStock()->get();
        $user = auth()->user();

        if ($user->isAdmin()) {
            return view('admin.transactions.create', compact('catalogs'));
        } else {
            return view('employee.transactions.create', compact('catalogs'));
        }
    }

    /**
     * Store a newly created transaction
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'payment_method' => ['required', 'in:cash,transfer,card,e-wallet'],
            'payment_status' => ['required', 'in:pending,paid,cancelled'],
            'notes' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.catalog_id' => ['required', 'exists:catalogs,id_produk'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ], [
            'customer_name.required' => 'Data harus diisi',
            'payment_method.required' => 'Data harus diisi',
            'payment_status.required' => 'Data harus diisi',
            'items.required' => 'Data harus diisi',
            'items.*.catalog_id.required' => 'Data harus diisi',
            'items.*.quantity.required' => 'Data harus diisi',
        ]);

        DB::beginTransaction();

        try {
            // Generate transaction code
            $transactionCode = Transaction::generateTransactionCode();

            // Calculate total amount
            $totalAmount = 0;
            $transactionItems = [];

            foreach ($request->items as $item) {
                $catalog = Catalog::where('id_produk', $item['catalog_id'])->firstOrFail();

                // Check stock availability
                if ($catalog->stock < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$catalog->nama}");
                }

                $subtotal = $catalog->harga * $item['quantity'];
                $totalAmount += $subtotal;

                $transactionItems[] = [
                    'catalog_id_produk' => $catalog->id_produk,
                    'product_name' => $catalog->nama,
                    'quantity' => $item['quantity'],
                    'unit_price' => $catalog->harga,
                    'subtotal' => $subtotal,
                ];

                // Update stock
                $catalog->decrement('stock', $item['quantity']);
            }

            // Create transaction
            $transaction = Transaction::create([
                'transaction_code' => $transactionCode,
                'customer_name' => $request->customer_name,
                'total_amount' => $totalAmount,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_status,
                'transaction_date' => now(),
                'notes' => $request->notes,
                'created_by' => auth()->id(),
            ]);

            // Create transaction items
            foreach ($transactionItems as $item) {
                $transaction->items()->create($item);
            }

            DB::commit();

            return redirect()->route('transactions.show', $transaction)
                ->with('success', 'Transaksi berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified transaction
     */
    public function show(Transaction $transaction)
    {
        $transaction->load('creator', 'items.catalog');
        $user = auth()->user();

        // Check if employee can only view their own transactions
        if ($user->isEmployee() && $transaction->created_by !== $user->id) {
            abort(403, 'Unauthorized access to this transaction.');
        }

        if ($user->isAdmin()) {
            return view('admin.transactions.show', compact('transaction'));
        } else {
            return view('employee.transactions.show', compact('transaction'));
        }
    }

    /**
     * Update transaction payment status
     */
    public function updatePaymentStatus(Request $request, Transaction $transaction)
    {
        $request->validate([
            'payment_status' => ['required', 'in:pending,paid,cancelled'],
        ], [
            'payment_status.required' => 'Data harus diisi',
        ]);

        $transaction->update([
            'payment_status' => $request->payment_status,
        ]);

        return back()->with('success', 'Status pembayaran berhasil diubah.');
    }
}
