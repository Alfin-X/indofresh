<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
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
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Employee management
    Route::resource('employees', EmployeeController::class);

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

    // Logout
    Route::post('/logout', function () {
        auth()->logout();
        return redirect('/login');
    })->name('employee.logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
