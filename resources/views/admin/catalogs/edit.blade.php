<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Produk
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form id="updateForm" method="POST" action="{{ route('admin.catalogs.update', $catalog) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="id_produk" class="block font-medium text-sm text-gray-700">ID Produk</label>
                            <input id="id_produk" name="id_produk" type="text" value="{{ $catalog->id_produk }}" readonly
                                class="border-gray-300 bg-gray-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                            <p class="text-sm text-gray-500 mt-1">ID Produk tidak dapat diubah</p>
                        </div>

                        <div class="mb-4">
                            <label for="nama" class="block font-medium text-sm text-gray-700">Nama Produk (maksimal 20 karakter)</label>
                            <input id="nama" name="nama" type="text" value="{{ old('nama', $catalog->nama) }}" required autofocus maxlength="20"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                            @error('nama')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="stock" class="block font-medium text-sm text-gray-700">Stock</label>
                                <input id="stock" name="stock" type="number" min="0" value="{{ old('stock', $catalog->stock) }}" required
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                @error('stock')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="harga" class="block font-medium text-sm text-gray-700">Harga (Rp)</label>
                                <input id="harga" name="harga" type="number" min="0" value="{{ old('harga', $catalog->harga) }}" required
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                @error('harga')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="keterangan" class="block font-medium text-sm text-gray-700">Keterangan (maksimal 50 karakter)</label>
                            <input id="keterangan" name="keterangan" type="text" value="{{ old('keterangan', $catalog->keterangan) }}" required maxlength="50"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                            @error('keterangan')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="gambar" class="block font-medium text-sm text-gray-700">Gambar Produk</label>
                            @if($catalog->gambar)
                                <div class="mb-2">
                                    <img src="data:image/jpeg;base64,{{ base64_encode($catalog->gambar) }}" alt="{{ $catalog->nama }}" class="w-32 h-32 object-cover rounded">
                                    <p class="text-sm text-gray-500 mt-1">Gambar saat ini</p>
                                </div>
                            @endif
                            <input id="gambar" name="gambar" type="file" accept="image/*"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                            <p class="text-sm text-gray-500 mt-1">Biarkan kosong untuk mempertahankan gambar saat ini. Ukuran file maksimal: 2MB. Format yang didukung: JPEG, PNG, JPG, GIF</p>
                            @error('gambar')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="button" onclick="confirmUpdate()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Perbarui Produk
                            </button>
                            <a href="{{ route('catalogs.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmUpdate() {
            if (confirm('Apakah Anda yakin ingin memperbarui data produk ini?')) {
                // Submit form using AJAX
                const form = document.getElementById('updateForm');
                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (response.ok) {
                        alert('Produk berhasil diubah.');
                        window.location.href = '/catalogs';
                    } else {
                        alert('Terjadi kesalahan saat memperbarui produk.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memperbarui produk.');
                });
            }
            // If user clicks "Batal", do nothing (stay on the form)
        }

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
