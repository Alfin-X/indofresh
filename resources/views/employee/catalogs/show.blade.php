<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Product Image -->
                        <div>
                            @if($catalog->image)
                                <img src="{{ Storage::url($catalog->image) }}" alt="{{ $catalog->name }}" class="w-full h-96 object-cover rounded-lg shadow-md">
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
                                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $catalog->name }}</h1>
                                @if($catalog->category)
                                    <span class="inline-block bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">
                                        {{ $catalog->category }}
                                    </span>
                                @endif
                                <div class="mt-2">
                                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full {{ $catalog->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $catalog->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Description</h3>
                                    <p class="text-gray-700">{{ $catalog->description ?: 'No description available.' }}</p>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <h4 class="font-medium text-gray-900">Price</h4>
                                        <p class="text-2xl font-bold text-green-600">Rp {{ number_format($catalog->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900">Stock</h4>
                                        <p class="text-2xl font-bold {{ $catalog->stock > 10 ? 'text-green-600' : ($catalog->stock > 0 ? 'text-yellow-600' : 'text-red-600') }}">
                                            {{ $catalog->stock }} units
                                        </p>
                                    </div>
                                </div>

                                @if($catalog->created_at)
                                    <div>
                                        <h4 class="font-medium text-gray-900">Added Date</h4>
                                        <p class="text-gray-700">{{ $catalog->created_at->format('F j, Y') }}</p>
                                    </div>
                                @endif

                                @if($catalog->updated_at && $catalog->updated_at != $catalog->created_at)
                                    <div>
                                        <h4 class="font-medium text-gray-900">Last Updated</h4>
                                        <p class="text-gray-700">{{ $catalog->updated_at->format('F j, Y') }}</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-8 flex space-x-3">
                                <a href="{{ route('catalogs.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Back to Catalog
                                </a>
                                @if($catalog->stock > 0 && $catalog->status)
                                    <button onclick="addToCart({{ $catalog->id }}, '{{ $catalog->name }}', {{ $catalog->price }}, {{ $catalog->stock }})" 
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Add to Cart
                                    </button>
                                    <a href="{{ route('transactions.create') }}?product={{ $catalog->id }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        Create Transaction
                                    </a>
                                @else
                                    <button disabled class="bg-gray-300 text-gray-500 font-bold py-2 px-4 rounded cursor-not-allowed">
                                        {{ !$catalog->status ? 'Product Inactive' : 'Out of Stock' }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Product Statistics (Employee View) -->
                    <div class="mt-8 border-t pt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Product Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-900">Availability Status</h4>
                                <p class="text-lg font-semibold {{ $catalog->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $catalog->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                                </p>
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ $catalog->stock }} units available
                                </p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-900">Product Status</h4>
                                <p class="text-lg font-semibold {{ $catalog->status ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $catalog->status ? 'Active' : 'Inactive' }}
                                </p>
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ $catalog->status ? 'Available for sale' : 'Not available for sale' }}
                                </p>
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
        function addToCart(productId, productName, price, stock) {
            // Check if cart functionality exists
            if (typeof window.addToCart === 'function') {
                window.addToCart(productId, productName, price, stock);
            } else {
                // Fallback: redirect to transaction create page
                window.location.href = "{{ route('transactions.create') }}?product=" + productId;
            }
        }
    </script>
    @endpush
</x-app-layout>
