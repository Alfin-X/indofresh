<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('catalogs.update', $catalog) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block font-medium text-sm text-gray-700">Product Name</label>
                            <input id="name" name="name" type="text" value="{{ old('name', $catalog->name) }}" required autofocus
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                            @error('name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block font-medium text-sm text-gray-700">Description</label>
                            <textarea id="description" name="description" rows="4"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">{{ old('description', $catalog->description) }}</textarea>
                            @error('description')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="price" class="block font-medium text-sm text-gray-700">Price (Rp)</label>
                                <input id="price" name="price" type="number" step="0.01" min="0" value="{{ old('price', $catalog->price) }}" required
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                @error('price')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="stock" class="block font-medium text-sm text-gray-700">Stock</label>
                                <input id="stock" name="stock" type="number" min="0" value="{{ old('stock', $catalog->stock) }}" required
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                @error('stock')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="category" class="block font-medium text-sm text-gray-700">Category</label>
                            <select id="category" name="category"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                <option value="">Select Category</option>
                                <option value="Fruits" {{ old('category', $catalog->category) == 'Fruits' ? 'selected' : '' }}>Fruits</option>
                                <option value="Vegetables" {{ old('category', $catalog->category) == 'Vegetables' ? 'selected' : '' }}>Vegetables</option>
                                <option value="Herbs" {{ old('category', $catalog->category) == 'Herbs' ? 'selected' : '' }}>Herbs</option>
                                <option value="Dairy" {{ old('category', $catalog->category) == 'Dairy' ? 'selected' : '' }}>Dairy</option>
                                <option value="Meat" {{ old('category', $catalog->category) == 'Meat' ? 'selected' : '' }}>Meat</option>
                                <option value="Seafood" {{ old('category', $catalog->category) == 'Seafood' ? 'selected' : '' }}>Seafood</option>
                                <option value="Beverages" {{ old('category', $catalog->category) == 'Beverages' ? 'selected' : '' }}>Beverages</option>
                                <option value="Others" {{ old('category', $catalog->category) == 'Others' ? 'selected' : '' }}>Others</option>
                            </select>
                            @error('category')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="image" class="block font-medium text-sm text-gray-700">Product Image</label>
                            @if($catalog->image)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($catalog->image) }}" alt="{{ $catalog->name }}" class="w-32 h-32 object-cover rounded">
                                    <p class="text-sm text-gray-500 mt-1">Current image</p>
                                </div>
                            @endif
                            <input id="image" name="image" type="file" accept="image/*"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                            <p class="text-sm text-gray-500 mt-1">Leave empty to keep current image. Max file size: 2MB. Supported formats: JPEG, PNG, JPG, GIF</p>
                            @error('image')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="status" value="1" {{ old('status', $catalog->status) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">Active (visible to customers)</span>
                            </label>
                            @error('status')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Product
                            </button>
                            <a href="{{ route('catalogs.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
