<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Katalog Produk
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Produk Tersedia</h3>
                        <a href="{{ route('transactions.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Buat Transaksi
                        </a>
                    </div>

                    <!-- Search and Filter -->
                    <div class="mb-6">
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="flex-1">
                                <input type="text" id="search" placeholder="Cari produk..."
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                            </div>
                            <div>
                                <select id="category-filter" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Semua Kategori</option>
                                    <option value="Buah Segar">Buah Segar</option>
                                    <option value="Buah Import">Buah Import</option>
                                    <option value="Sayuran">Sayuran</option>
                                    <option value="Rempah">Rempah</option>
                                    <option value="Susu">Susu</option>
                                    <option value="Daging">Daging</option>
                                    <option value="Seafood">Seafood</option>
                                    <option value="Minuman">Minuman</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="products-grid">
                        @forelse($catalogs as $catalog)
                            <div class="product-card bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden"
                                 data-name="{{ strtolower($catalog->name) }}"
                                 data-category="{{ $catalog->category }}">
                                @if($catalog->image)
                                    <img src="{{ Storage::url($catalog->image) }}" alt="{{ $catalog->name }}" class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif

                                <div class="p-4">
                                    <h4 class="font-semibold text-lg mb-2">{{ $catalog->name }}</h4>
                                    <p class="text-gray-600 text-sm mb-2">{{ Str::limit($catalog->description, 100) }}</p>
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-lg font-bold text-green-600">Rp {{ number_format($catalog->price, 0, ',', '.') }}</span>
                                        <span class="text-sm {{ $catalog->stock > 10 ? 'text-green-600' : ($catalog->stock > 0 ? 'text-yellow-600' : 'text-red-600') }}">
                                            Stok: {{ $catalog->stock }}
                                        </span>
                                    </div>
                                    @if($catalog->category)
                                        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mb-3">{{ $catalog->category }}</span>
                                    @endif

                                    <div class="flex space-x-2">
                                        <a href="{{ route('catalogs.show', $catalog) }}" class="flex-1 bg-gray-500 hover:bg-gray-700 text-white text-center py-2 px-3 rounded text-sm">
                                            Lihat Detail
                                        </a>
                                        @if($catalog->stock > 0)
                                            <button onclick="addToCart({{ $catalog->id }}, '{{ $catalog->name }}', {{ $catalog->price }}, {{ $catalog->stock }})"
                                                    class="flex-1 bg-blue-500 hover:bg-blue-700 text-white py-2 px-3 rounded text-sm">
                                                Tambah ke Keranjang
                                            </button>
                                        @else
                                            <button disabled class="flex-1 bg-gray-300 text-gray-500 py-2 px-3 rounded text-sm cursor-not-allowed">
                                                Stok Habis
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m14 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m14 0H6m14 0l-3-3m-3 3l-3-3m3 3v4"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada produk tersedia</h3>
                                <p class="mt-1 text-sm text-gray-500">Saat ini tidak ada produk dalam katalog.</p>
                            </div>
                        @endforelse
                    </div>

                    @if($catalogs->hasPages())
                        <div class="mt-6">
                            {{ $catalogs->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Shopping Cart Sidebar (Hidden by default) -->
            <div id="cart-sidebar" class="fixed inset-y-0 right-0 w-96 bg-white shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out z-50">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Keranjang Belanja</h3>
                        <button onclick="toggleCart()" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div id="cart-items" class="space-y-3 mb-4">
                        <!-- Cart items will be added here -->
                    </div>
                    <div class="border-t pt-4">
                        <div class="flex justify-between items-center mb-4">
                            <span class="font-medium">Total:</span>
                            <span id="cart-total" class="text-lg font-bold text-green-600">Rp 0</span>
                        </div>
                        <button onclick="proceedToCheckout()" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Lanjut ke Checkout
                        </button>
                    </div>
                </div>
            </div>

            <!-- Cart overlay -->
            <div id="cart-overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40" onclick="toggleCart()"></div>
        </div>
    </div>

    <script>
        let cart = [];

        // Search functionality
        document.getElementById('search').addEventListener('input', function() {
            filterProducts();
        });

        // Category filter
        document.getElementById('category-filter').addEventListener('change', function() {
            filterProducts();
        });

        function filterProducts() {
            const searchTerm = document.getElementById('search').value.toLowerCase();
            const selectedCategory = document.getElementById('category-filter').value;
            const productCards = document.querySelectorAll('.product-card');

            productCards.forEach(card => {
                const productName = card.dataset.name;
                const productCategory = card.dataset.category;

                const matchesSearch = productName.includes(searchTerm);
                const matchesCategory = !selectedCategory || productCategory === selectedCategory;

                if (matchesSearch && matchesCategory) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function addToCart(id, name, price, stock) {
            const existingItem = cart.find(item => item.id === id);

            if (existingItem) {
                if (existingItem.quantity < stock) {
                    existingItem.quantity++;
                } else {
                    alert('Tidak dapat menambah item lagi. Batas stok tercapai.');
                    return;
                }
            } else {
                cart.push({ id, name, price, quantity: 1, stock });
            }

            updateCartDisplay();
            showCart();
        }

        function updateCartDisplay() {
            const cartItems = document.getElementById('cart-items');
            const cartTotal = document.getElementById('cart-total');

            cartItems.innerHTML = '';
            let total = 0;

            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                total += itemTotal;

                cartItems.innerHTML += `
                    <div class="flex justify-between items-center border-b pb-2">
                        <div>
                            <div class="font-medium">${item.name}</div>
                            <div class="text-sm text-gray-500">Rp ${new Intl.NumberFormat('id-ID').format(item.price)} x ${item.quantity}</div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button onclick="updateQuantity(${item.id}, -1)" class="text-red-500 hover:text-red-700">-</button>
                            <span>${item.quantity}</span>
                            <button onclick="updateQuantity(${item.id}, 1)" class="text-green-500 hover:text-green-700">+</button>
                            <button onclick="removeFromCart(${item.id})" class="text-red-500 hover:text-red-700 ml-2">×</button>
                        </div>
                    </div>
                `;
            });

            cartTotal.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        }

        function updateQuantity(id, change) {
            const item = cart.find(item => item.id === id);
            if (item) {
                const newQuantity = item.quantity + change;
                if (newQuantity > 0 && newQuantity <= item.stock) {
                    item.quantity = newQuantity;
                    updateCartDisplay();
                } else if (newQuantity <= 0) {
                    removeFromCart(id);
                } else {
                    alert('Tidak dapat menambah item lagi. Batas stok tercapai.');
                }
            }
        }

        function removeFromCart(id) {
            cart = cart.filter(item => item.id !== id);
            updateCartDisplay();
        }

        function toggleCart() {
            const sidebar = document.getElementById('cart-sidebar');
            const overlay = document.getElementById('cart-overlay');

            if (sidebar.classList.contains('translate-x-full')) {
                showCart();
            } else {
                hideCart();
            }
        }

        function showCart() {
            const sidebar = document.getElementById('cart-sidebar');
            const overlay = document.getElementById('cart-overlay');

            sidebar.classList.remove('translate-x-full');
            overlay.classList.remove('hidden');
        }

        function hideCart() {
            const sidebar = document.getElementById('cart-sidebar');
            const overlay = document.getElementById('cart-overlay');

            sidebar.classList.add('translate-x-full');
            overlay.classList.add('hidden');
        }

        function proceedToCheckout() {
            if (cart.length === 0) {
                alert('Keranjang Anda kosong!');
                return;
            }

            // Store cart in session storage and redirect to transaction create page
            sessionStorage.setItem('cart', JSON.stringify(cart));
            window.location.href = '{{ route("transactions.create") }}';
        }
    </script>
</x-app-layout>
