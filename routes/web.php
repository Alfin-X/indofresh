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

// Debug route
Route::get('/debug', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'Laravel Indofresh is working perfectly!',
        'time' => now()->format('Y-m-d H:i:s'),
        'timezone' => config('app.timezone'),
        'locale' => config('app.locale'),
        'routes_count' => count(app('router')->getRoutes()),
        'server_info' => [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'environment' => config('app.env'),
        ]
    ], 200, [], JSON_PRETTY_PRINT);
});

// Simple test route
Route::get('/test', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'Laravel is working!',
        'time' => now(),
        'timezone' => config('app.timezone'),
        'app_name' => config('app.name'),
        'url' => config('app.url')
    ]);
});

// Health check route
Route::get('/health', function () {
    return response('OK - Indofresh Server is healthy!', 200)
        ->header('Content-Type', 'text/plain');
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

    // Admin-only catalog management (create, edit, update, delete)
    Route::get('/catalogs/create', [CatalogController::class, 'create'])->name('admin.catalogs.create');
    Route::post('/catalogs', [CatalogController::class, 'store'])->name('admin.catalogs.store');
    Route::get('/catalogs/{catalog}/edit', [CatalogController::class, 'edit'])->name('admin.catalogs.edit');
    Route::put('/catalogs/{catalog}', [CatalogController::class, 'update'])->name('admin.catalogs.update');
    Route::delete('/catalogs/{catalog}', [CatalogController::class, 'destroy'])->name('admin.catalogs.destroy');

    // Admin-only transaction management (update payment status)
    Route::patch('/transactions/{transaction}/payment-status', [TransactionController::class, 'updatePaymentStatus'])->name('admin.transactions.update-payment-status');

    // AI Analytics
    Route::get('/ai', [AIController::class, 'dashboard'])->name('admin.ai.dashboard');
    Route::get('/ai/chart-data', [AIController::class, 'getChartData'])->name('admin.ai.chart-data');
    Route::post('/ai/predict-fruit', [AIController::class, 'triggerFruitPrediction'])->name('admin.ai.predict-fruit');

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

// Shared routes for both admin and employee (middleware handled in controllers)
// Catalog routes
Route::get('/catalogs', [CatalogController::class, 'index'])->name('catalogs.index');
Route::get('/catalogs/{catalog}', [CatalogController::class, 'show'])->name('catalogs.show');

// Transaction routes
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');

// Debug routes to test employee access
Route::get('/test-employee', function () {
    $user = auth()->user();
    if (!$user) {
        return 'Not authenticated';
    }
    return 'User: ' . $user->name . ', Role: ' . $user->role . ', isEmployee: ' . ($user->isEmployee() ? 'true' : 'false');
})->middleware('auth');

Route::get('/test-role-middleware', function () {
    $user = auth()->user();
    return 'SUCCESS! User: ' . $user->name . ', Role: ' . $user->role . ' can access this route with role:admin,employee middleware';
})->middleware(['auth', 'role:admin,employee']);

Route::get('/test-catalog-direct', function () {
    $user = auth()->user();
    $catalogs = \App\Models\Catalog::active()->take(5)->get();
    return 'User: ' . $user->name . ' can see ' . $catalogs->count() . ' catalogs';
})->middleware('auth');

// Test routes using TestController
Route::get('/api/test/employee', [App\Http\Controllers\TestController::class, 'testEmployeeAccess']);
Route::get('/api/test/catalog', [App\Http\Controllers\TestController::class, 'testCatalogAccess']);
Route::get('/api/test/role-middleware', [App\Http\Controllers\TestController::class, 'testRoleMiddleware'])
    ->middleware(['auth', 'role:admin,employee']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
