<x-app-layout>
    <div class="max-w-4xl mx-auto py-10">
        <h1 class="text-2xl font-semibold mb-6">Daftar Akun Pegawai</h1>

        <div class="mb-4">
            <a href="{{ route('employees.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                Buat Akun Pegawai Baru
            </a>
        </div>

        <table class="min-w-full bg-white border border-gray-200 rounded">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b border-gray-200 text-left">Nama</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-left">Email</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($employees as $employee)
                    <tr>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $employee->name }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $employee->email }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="py-4 px-4 text-center text-gray-500">Tidak ada akun pegawai.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
