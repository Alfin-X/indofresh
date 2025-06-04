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
                            <div class="flex justify-between items-start mb-4">
                                <h1 class="text-3xl font-bold text-gray-900">{{ $catalog->name }}</h1>
                                <div class="flex space-x-2">
                                    @if($catalog->status)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Inactive
                                        </span>
                                    @endif
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

                                @if($catalog->category)
                                    <div>
                                        <h4 class="font-medium text-gray-900">Category</h4>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            {{ $catalog->category }}
                                        </span>
                                    </div>
                                @endif

                                <div>
                                    <h4 class="font-medium text-gray-900">Created</h4>
                                    <p class="text-gray-700">{{ $catalog->created_at->format('F d, Y') }}</p>
                                </div>

                                <div>
                                    <h4 class="font-medium text-gray-900">Last Updated</h4>
                                    <p class="text-gray-700">{{ $catalog->updated_at->format('F d, Y') }}</p>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-8 flex space-x-3">
                                <a href="{{ route('catalogs.edit', $catalog) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                    Edit Product
                                </a>
                                <a href="{{ route('catalogs.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Back to Catalog
                                </a>
                                <form method="POST" action="{{ route('catalogs.destroy', $catalog) }}" 
                                      onsubmit="return confirm('Are you sure you want to delete this product?')" 
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        Delete Product
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Sales Information -->
                    <div class="mt-8 border-t pt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Sales Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-900">Total Sold</h4>
                                <p class="text-2xl font-bold text-blue-600">
                                    {{ $catalog->transactionItems()->sum('quantity') }} units
                                </p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-900">Total Revenue</h4>
                                <p class="text-2xl font-bold text-green-600">
                                    Rp {{ number_format($catalog->transactionItems()->sum('subtotal'), 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-900">Transactions</h4>
                                <p class="text-2xl font-bold text-purple-600">
                                    {{ $catalog->transactionItems()->distinct('transaction_id')->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
