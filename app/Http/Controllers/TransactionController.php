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
        $this->middleware('role:admin,employee');
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
            'customer_phone' => ['nullable', 'string', 'max:20'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'payment_method' => ['required', 'in:cash,transfer,card,e-wallet'],
            'payment_status' => ['required', 'in:pending,paid,cancelled'],
            'notes' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.catalog_id' => ['required', 'exists:catalogs,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        DB::beginTransaction();
        
        try {
            // Generate transaction code
            $transactionCode = Transaction::generateTransactionCode();
            
            // Calculate total amount
            $totalAmount = 0;
            $transactionItems = [];
            
            foreach ($request->items as $item) {
                $catalog = Catalog::findOrFail($item['catalog_id']);
                
                // Check stock availability
                if ($catalog->stock < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$catalog->name}");
                }
                
                $subtotal = $catalog->price * $item['quantity'];
                $totalAmount += $subtotal;
                
                $transactionItems[] = [
                    'catalog_id' => $catalog->id,
                    'product_name' => $catalog->name,
                    'quantity' => $item['quantity'],
                    'unit_price' => $catalog->price,
                    'subtotal' => $subtotal,
                ];
                
                // Update stock
                $catalog->decrement('stock', $item['quantity']);
            }
            
            // Create transaction
            $transaction = Transaction::create([
                'transaction_code' => $transactionCode,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
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
                ->with('success', 'Transaction created successfully.');
                
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
        ]);

        $transaction->update([
            'payment_status' => $request->payment_status,
        ]);

        return back()->with('success', 'Payment status updated successfully.');
    }
}
