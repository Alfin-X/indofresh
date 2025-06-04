<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaction Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Transaction Header -->
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $transaction->transaction_code }}</h3>
                            <p class="text-gray-600">{{ $transaction->transaction_date->format('F d, Y - H:i') }}</p>
                        </div>
                        <div class="text-right">
                            @if($transaction->payment_status === 'paid')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    Paid
                                </span>
                            @elseif($transaction->payment_status === 'pending')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    Pending
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    Cancelled
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-900 mb-3">Customer Information</h4>
                            <div class="space-y-2">
                                <div>
                                    <span class="text-sm text-gray-600">Name:</span>
                                    <span class="ml-2 font-medium">{{ $transaction->customer_name }}</span>
                                </div>
                                @if($transaction->customer_phone)
                                    <div>
                                        <span class="text-sm text-gray-600">Phone:</span>
                                        <span class="ml-2 font-medium">{{ $transaction->customer_phone }}</span>
                                    </div>
                                @endif
                                @if($transaction->customer_email)
                                    <div>
                                        <span class="text-sm text-gray-600">Email:</span>
                                        <span class="ml-2 font-medium">{{ $transaction->customer_email }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-900 mb-3">Transaction Information</h4>
                            <div class="space-y-2">
                                <div>
                                    <span class="text-sm text-gray-600">Payment Method:</span>
                                    <span class="ml-2 font-medium">{{ ucfirst($transaction->payment_method) }}</span>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600">Total Amount:</span>
                                    <span class="ml-2 font-bold text-green-600">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction Items -->
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-900 mb-3">Items</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($transaction->items as $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $item->product_name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $item->quantity }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-900">Total:</td>
                                        <td class="px-6 py-3 text-sm font-bold text-green-600">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Notes -->
                    @if($transaction->notes)
                        <div class="mb-6">
                            <h4 class="font-semibold text-gray-900 mb-3">Notes</h4>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-gray-700">{{ $transaction->notes }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex justify-between items-center">
                        <a href="{{ route('transactions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to My Transactions
                        </a>
                        
                        <a href="{{ route('transactions.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Create New Transaction
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
