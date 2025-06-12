<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.catalogs.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="id_produk" class="block font-medium text-sm text-gray-700">ID Produk (6 karakter)</label>
                            <input id="id_produk" name="id_produk" type="text" value="{{ old('id_produk') }}" required autofocus maxlength="6"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                            @error('id_produk')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="nama" class="block font-medium text-sm text-gray-700">Nama Produk (maksimal 20 karakter)</label>
                            <input id="nama" name="nama" type="text" value="{{ old('nama') }}" required maxlength="20"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                            @error('nama')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="stock" class="block font-medium text-sm text-gray-700">Stock</label>
                                <input id="stock" name="stock" type="number" min="0" value="{{ old('stock') }}" required
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                @error('stock')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="harga" class="block font-medium text-sm text-gray-700">Harga (Rp)</label>
                                <input id="harga" name="harga" type="number" min="0" value="{{ old('harga') }}" required
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                @error('harga')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="keterangan" class="block font-medium text-sm text-gray-700">Keterangan (maksimal 50 karakter)</label>
                            <input id="keterangan" name="keterangan" type="text" value="{{ old('keterangan') }}" required maxlength="50"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                            @error('keterangan')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="gambar" class="block font-medium text-sm text-gray-700">Gambar Produk</label>
                            <input id="gambar" name="gambar" type="file" accept="image/*"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                            <p class="text-sm text-gray-500 mt-1">Max file size: 2MB. Supported formats: JPEG, PNG, JPG, GIF</p>
                            @error('gambar')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Product
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

    <script>
        // Set custom validation messages for HTML5 validation
        document.addEventListener('DOMContentLoaded', function() {
            const requiredInputs = document.querySelectorAll('input[required], textarea[required]');

            requiredInputs.forEach(function(input) {
                input.addEventListener('invalid', function() {
                    if (this.validity.valueMissing) {
                        this.setCustomValidity('Data tidak boleh kosong');
                    } else {
                        this.setCustomValidity('');
                    }
                });

                input.addEventListener('input', function() {
                    this.setCustomValidity('');
                });
            });
        });
    </script>
</x-app-layout>
