<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Profile Information -->
                <div class="md:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-medium text-gray-900">Profile Information</h3>
                                <a href="{{ route('employee.profile.edit') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Edit Profile
                                </a>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Name</label>
                                    <div class="mt-1 text-sm text-gray-900">{{ $employee->name }}</div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <div class="mt-1 text-sm text-gray-900">{{ $employee->email }}</div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                                    <div class="mt-1 text-sm text-gray-900">{{ $employee->phone ?? 'Not provided' }}</div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Address</label>
                                    <div class="mt-1 text-sm text-gray-900">{{ $employee->address ?? 'Not provided' }}</div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Role</label>
                                    <div class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ ucfirst($employee->role) }}
                                        </span>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Member Since</label>
                                    <div class="mt-1 text-sm text-gray-900">{{ $employee->created_at->format('F d, Y') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="space-y-6">
                    <!-- Account Actions -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Account Actions</h3>
                            <div class="space-y-3">
                                <a href="{{ route('employee.profile.edit') }}" class="block w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">
                                    Edit Profile
                                </a>
                                <a href="{{ route('employee.profile.change-password') }}" class="block w-full bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded text-center">
                                    Change Password
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Work Statistics -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">My Statistics</h3>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Total Transactions</span>
                                    <span class="font-medium">{{ \App\Models\Transaction::where('created_by', $employee->id)->count() }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">This Month</span>
                                    <span class="font-medium">{{ \App\Models\Transaction::where('created_by', $employee->id)->thisMonth()->count() }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Today</span>
                                    <span class="font-medium">{{ \App\Models\Transaction::where('created_by', $employee->id)->today()->count() }}</span>
                                </div>
                                <div class="border-t pt-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Total Sales</span>
                                        <span class="font-medium text-green-600">
                                            Rp {{ number_format(\App\Models\Transaction::where('created_by', $employee->id)->where('payment_status', 'paid')->sum('total_amount'), 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Links</h3>
                            <div class="space-y-3">
                                <a href="{{ route('catalogs.index') }}" class="block w-full bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-center">
                                    View Products
                                </a>
                                <a href="{{ route('transactions.create') }}" class="block w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center">
                                    New Transaction
                                </a>
                                <a href="{{ route('transactions.index') }}" class="block w-full bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-center">
                                    My Transactions
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
