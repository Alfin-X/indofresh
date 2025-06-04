<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('transactions.store') }}" id="transaction-form">
                        @csrf

                        <!-- Customer Information -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium mb-4">Customer Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="customer_name" class="block font-medium text-sm text-gray-700">Customer Name *</label>
                                    <input id="customer_name" name="customer_name" type="text" value="{{ old('customer_name') }}" required
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                </div>
                                <div>
                                    <label for="customer_phone" class="block font-medium text-sm text-gray-700">Phone</label>
                                    <input id="customer_phone" name="customer_phone" type="text" value="{{ old('customer_phone') }}"
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                </div>
                                <div>
                                    <label for="customer_email" class="block font-medium text-sm text-gray-700">Email</label>
                                    <input id="customer_email" name="customer_email" type="email" value="{{ old('customer_email') }}"
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                </div>
                            </div>
                        </div>

                        <!-- Product Selection -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium mb-4">Products</h3>
                            <div id="product-items">
                                <div class="product-item border border-gray-200 rounded p-4 mb-4">
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                                        <div>
                                            <label class="block font-medium text-sm text-gray-700">Product</label>
                                            <select name="items[0][catalog_id]" class="product-select border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" required>
                                                <option value="">Select Product</option>
                                                @foreach($catalogs as $catalog)
                                                    <option value="{{ $catalog->id }}" data-price="{{ $catalog->price }}" data-stock="{{ $catalog->stock }}">
                                                        {{ $catalog->name }} (Stock: {{ $catalog->stock }}) - Rp {{ number_format($catalog->price, 0, ',', '.') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block font-medium text-sm text-gray-700">Quantity</label>
                                            <input type="number" name="items[0][quantity]" min="1" class="quantity-input border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" required>
                                        </div>
                                        <div>
                                            <label class="block font-medium text-sm text-gray-700">Subtotal</label>
                                            <input type="text" class="subtotal-display border-gray-300 rounded-md shadow-sm w-full bg-gray-100" readonly>
                                        </div>
                                        <div>
                                            <button type="button" class="remove-item bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" style="display: none;">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="add-item" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Add Another Product
                            </button>
                        </div>

                        <!-- Payment Information -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium mb-4">Payment Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="payment_method" class="block font-medium text-sm text-gray-700">Payment Method *</label>
                                    <select id="payment_method" name="payment_method" required
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                        <option value="">Select Payment Method</option>
                                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                        <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Credit/Debit Card</option>
                                        <option value="e-wallet" {{ old('payment_method') == 'e-wallet' ? 'selected' : '' }}>E-Wallet</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="payment_status" class="block font-medium text-sm text-gray-700">Payment Status *</label>
                                    <select id="payment_status" name="payment_status" required
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                        <option value="pending" {{ old('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <label for="notes" class="block font-medium text-sm text-gray-700">Notes</label>
                            <textarea id="notes" name="notes" rows="3"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">{{ old('notes') }}</textarea>
                        </div>

                        <!-- Total -->
                        <div class="mb-6 bg-gray-50 p-4 rounded">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-medium">Total Amount:</span>
                                <span id="total-amount" class="text-2xl font-bold text-green-600">Rp 0</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Transaction
                            </button>
                            <a href="{{ route('transactions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let itemCount = 1;

        function calculateSubtotal(item) {
            const select = item.querySelector('.product-select');
            const quantityInput = item.querySelector('.quantity-input');
            const subtotalDisplay = item.querySelector('.subtotal-display');
            
            const selectedOption = select.options[select.selectedIndex];
            const price = selectedOption.dataset.price || 0;
            const quantity = quantityInput.value || 0;
            const subtotal = price * quantity;
            
            subtotalDisplay.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal);
            
            calculateTotal();
        }

        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.product-item').forEach(item => {
                const select = item.querySelector('.product-select');
                const quantityInput = item.querySelector('.quantity-input');
                
                const selectedOption = select.options[select.selectedIndex];
                const price = selectedOption.dataset.price || 0;
                const quantity = quantityInput.value || 0;
                
                total += price * quantity;
            });
            
            document.getElementById('total-amount').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        }

        document.getElementById('add-item').addEventListener('click', function() {
            const productItems = document.getElementById('product-items');
            const newItem = productItems.querySelector('.product-item').cloneNode(true);
            
            // Update name attributes
            newItem.querySelectorAll('select, input').forEach(input => {
                if (input.name) {
                    input.name = input.name.replace(/\[\d+\]/, `[${itemCount}]`);
                }
                input.value = '';
            });
            
            // Show remove button
            newItem.querySelector('.remove-item').style.display = 'block';
            
            productItems.appendChild(newItem);
            itemCount++;
            
            // Add event listeners to new item
            addItemEventListeners(newItem);
        });

        function addItemEventListeners(item) {
            const select = item.querySelector('.product-select');
            const quantityInput = item.querySelector('.quantity-input');
            const removeBtn = item.querySelector('.remove-item');
            
            select.addEventListener('change', () => calculateSubtotal(item));
            quantityInput.addEventListener('input', () => calculateSubtotal(item));
            
            removeBtn.addEventListener('click', function() {
                item.remove();
                calculateTotal();
            });
        }

        // Add event listeners to initial item
        document.querySelectorAll('.product-item').forEach(addItemEventListeners);
    </script>
</x-app-layout>
