<x-app-layout>
    <div class="max-w-2xl mx-auto py-10">
        <h1 class="text-2xl font-semibold mb-6">Ubah Akun Pegawai</h1>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('employees.update', $employee) }}">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label for="id_pegawai" class="block font-medium text-sm text-gray-700">ID Pegawai</label>
                <input id="id_pegawai" name="id_pegawai" type="text" value="{{ old('id_pegawai', $employee->id_pegawai) }}" required autofocus maxlength="6"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                @error('id_pegawai')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="nama_pegawai" class="block font-medium text-sm text-gray-700">Nama Pegawai</label>
                <input id="nama_pegawai" name="nama_pegawai" type="text" value="{{ old('nama_pegawai', $employee->name) }}" required maxlength="20"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                @error('nama_pegawai')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $employee->email) }}" required maxlength="20"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="block font-medium text-sm text-gray-700">Password Baru (kosongkan jika tidak ingin mengubah)</label>
                <input id="password" name="password" type="password" maxlength="20"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Perbarui Pegawai
                </button>
                <a href="{{ route('employees.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
