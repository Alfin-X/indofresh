<x-app-layout>
    <div class="max-w-2xl mx-auto py-10">
        <h1 class="text-2xl font-semibold mb-6">Edit Employee Account</h1>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('employees.update', $employee) }}">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
                <input id="name" name="name" type="text" value="{{ old('name', $employee->name) }}" required autofocus
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $employee->email) }}" required
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="phone" class="block font-medium text-sm text-gray-700">Phone</label>
                <input id="phone" name="phone" type="text" value="{{ old('phone', $employee->phone) }}"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                @error('phone')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="address" class="block font-medium text-sm text-gray-700">Address</label>
                <textarea id="address" name="address" rows="3"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">{{ old('address', $employee->address) }}</textarea>
                @error('address')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block font-medium text-sm text-gray-700">New Password (leave blank to keep current)</label>
                <input id="password" name="password" type="password"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Confirm New Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Update Employee
                </button>
                <a href="{{ route('employees.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
