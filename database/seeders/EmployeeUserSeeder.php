<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class EmployeeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'employee@example.com'],
            [
                'name' => 'Employee Test',
                'password' => Hash::make('employeepassword'),
                'role' => 'employee',
                'phone' => '081234567890',
                'address' => 'Jl. Test Employee No. 123',
            ]
        );

        // Create additional test employees
        User::updateOrCreate(
            ['email' => 'john.employee@example.com'],
            [
                'name' => 'John Employee',
                'password' => Hash::make('password123'),
                'role' => 'employee',
                'phone' => '081234567891',
                'address' => 'Jl. Employee Street No. 456',
            ]
        );
    }
}
