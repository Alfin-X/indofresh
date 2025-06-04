<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Catalog') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Product Management</h3>
                        <a href="{{ route('catalogs.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Add New Product
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @forelse($catalogs as $catalog)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden">
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
                                        <span class="text-sm text-gray-500">Stock: {{ $catalog->stock }}</span>
                                    </div>
                                    @if($catalog->category)
                                        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mb-3">{{ $catalog->category }}</span>
                                    @endif
                                    
                                    <div class="flex space-x-2">
                                        <a href="{{ route('catalogs.show', $catalog) }}" class="flex-1 bg-gray-500 hover:bg-gray-700 text-white text-center py-1 px-2 rounded text-sm">
                                            View
                                        </a>
                                        <a href="{{ route('catalogs.edit', $catalog) }}" class="flex-1 bg-yellow-500 hover:bg-yellow-700 text-white text-center py-1 px-2 rounded text-sm">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('catalogs.destroy', $catalog) }}" 
                                              onsubmit="return confirm('Are you sure you want to delete this product?')" 
                                              class="flex-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded text-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m14 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m14 0H6m14 0l-3-3m-3 3l-3-3m3 3v4"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No products</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating a new product.</p>
                                <div class="mt-6">
                                    <a href="{{ route('catalogs.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                        Add Product
                                    </a>
                                </div>
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
        </div>
    </div>
</x-app-layout>
