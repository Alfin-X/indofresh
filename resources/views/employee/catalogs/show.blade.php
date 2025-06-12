<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Produk
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Product Image -->
                        <div>
                            @if($catalog->gambar)
                                <img src="data:image/jpeg;base64,{{ base64_encode($catalog->gambar) }}" alt="{{ $catalog->nama }}" class="w-full h-96 object-cover rounded-lg shadow-md">
                            @else
                                <div class="w-full h-96 bg-gray-200 rounded-lg shadow-md flex items-center justify-center">
                                    <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Product Information -->
                        <div>
                            <div class="mb-6">
                                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $catalog->nama }}</h1>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <h4 class="font-medium text-gray-900">ID Produk</h4>
                                    <p class="text-lg text-gray-700">{{ $catalog->id_produk }}</p>
                                </div>

                                <div>
                                    <h4 class="font-medium text-gray-900">Stock</h4>
                                    <p class="text-lg text-gray-700">{{ $catalog->stock }} unit</p>
                                </div>

                                <div>
                                    <h4 class="font-medium text-gray-900">Keterangan</h4>
                                    <p class="text-lg text-gray-700">{{ $catalog->keterangan }}</p>
                                </div>

                                <div>
                                    <h4 class="font-medium text-gray-900">Harga</h4>
                                    <p class="text-2xl font-bold text-green-600">Rp {{ number_format($catalog->harga, 0, ',', '.') }}</p>
                                </div>

                                @if($catalog->created_at)
                                    <div>
                                        <h4 class="font-medium text-gray-900">Tanggal Ditambahkan</h4>
                                        <p class="text-gray-700">{{ $catalog->created_at->format('d F Y') }}</p>
                                    </div>
                                @endif

                                @if($catalog->updated_at && $catalog->updated_at != $catalog->created_at)
                                    <div>
                                        <h4 class="font-medium text-gray-900">Terakhir Diperbarui</h4>
                                        <p class="text-gray-700">{{ $catalog->updated_at->format('d F Y') }}</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-8 flex space-x-3">
                                <a href="{{ route('catalogs.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Kembali ke Katalog
                                </a>
                                @if($catalog->stock > 0)
                                    <button onclick="addToCart('{{ $catalog->id_produk }}', '{{ $catalog->nama }}', {{ $catalog->harga }})"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Tambah ke Keranjang
                                    </button>
                                    <a href="{{ route('transactions.create') }}?product={{ $catalog->id_produk }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        Buat Transaksi
                                    </a>
                                @else
                                    <button disabled class="bg-gray-300 text-gray-500 font-bold py-2 px-4 rounded cursor-not-allowed">
                                        Stok Habis
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add to Cart functionality (if exists in the parent layout) -->
    @push('scripts')
    <script>
        function addToCart(productId, productName, price) {
            // Check if cart functionality exists
            if (typeof window.addToCart === 'function') {
                window.addToCart(productId, productName, price);
            } else {
                // Fallback: redirect to transaction create page
                window.location.href = "{{ route('transactions.create') }}?product=" + productId;
            }
        }
    </script>
    @endpush
</x-app-layout>
