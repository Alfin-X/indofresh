<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AIController;
use App\Http\Controllers\EmployeeProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'employee') {
        return redirect()->route('employee.dashboard');
    }
    abort(403);
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication routes provided by Breeze
require __DIR__.'/auth.php';

// Admin routes
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    // Admin dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Admin profile management
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::get('/profile/edit', [AdminController::class, 'editProfile'])->name('admin.profile.edit');
    Route::patch('/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
    Route::get('/profile/change-password', [AdminController::class, 'changePasswordForm'])->name('admin.profile.change-password');
    Route::patch('/profile/password', [AdminController::class, 'updatePassword'])->name('admin.profile.update-password');

    // Employee management
    Route::resource('employees', EmployeeController::class);

    // Catalog management
    Route::resource('catalogs', CatalogController::class);

    // Transaction management
    Route::resource('transactions', TransactionController::class);
    Route::patch('/transactions/{transaction}/payment-status', [TransactionController::class, 'updatePaymentStatus'])->name('transactions.update-payment-status');

    // AI Analytics
    Route::get('/ai', [AIController::class, 'dashboard'])->name('admin.ai.dashboard');
    Route::get('/ai/chart-data', [AIController::class, 'getChartData'])->name('admin.ai.chart-data');

    // Logout
    Route::post('/logout', function () {
        auth()->logout();
        return redirect('/login');
    })->name('admin.logout');
});

// Employee routes
Route::prefix('employee')->middleware(['auth', 'role:employee'])->group(function () {
    // Employee dashboard
    Route::get('/dashboard', function () {
        return view('employee.dashboard');
    })->name('employee.dashboard');

    // Employee profile management
    Route::get('/profile', [EmployeeProfileController::class, 'show'])->name('employee.profile');
    Route::get('/profile/edit', [EmployeeProfileController::class, 'edit'])->name('employee.profile.edit');
    Route::patch('/profile', [EmployeeProfileController::class, 'update'])->name('employee.profile.update');
    Route::get('/profile/change-password', [EmployeeProfileController::class, 'changePasswordForm'])->name('employee.profile.change-password');
    Route::patch('/profile/password', [EmployeeProfileController::class, 'updatePassword'])->name('employee.profile.update-password');



    // Logout
    Route::post('/logout', function () {
        auth()->logout();
        return redirect('/login');
    })->name('employee.logout');
});

// Shared routes for both admin and employee
Route::middleware(['auth', 'role:admin,employee'])->group(function () {
    // Catalog routes (shared between admin and employee)
    Route::get('/catalogs', [CatalogController::class, 'index'])->name('catalogs.index');
    Route::get('/catalogs/{catalog}', [CatalogController::class, 'show'])->name('catalogs.show');

    // Transaction routes (shared between admin and employee)
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
