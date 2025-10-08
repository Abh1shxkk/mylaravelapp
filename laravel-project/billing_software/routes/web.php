<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Manager\DashboardController as ManagerDashboardController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\LoginController;



// ==============================================
// COMMON / PUBLIC ROUTES
// ==============================================
Route::get('/', [CommonController::class, 'index'])->name('home');

// Guest (only not logged in users can access)
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('authenticate', [LoginController::class, 'authenticate'])->name('authenticate');
});


Route::get('profile', [AdminDashboardController::class, 'profile'])->name('admin.profile');

// Authenticated (logged in users)
Route::middleware('auth')->group(function () {
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
});

// ==============================================
// USER ROUTES
// ==============================================
Route::prefix('user')->group(function () {
    Route::middleware('user.guest')->group(function () {
        // (Add user guest routes if needed)
    });

    Route::middleware('user.auth')->group(function () {
        Route::get('dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
        Route::get('logout', [LoginController::class, 'userLogout'])->name('user.logout');
    });
});

// ==============================================
// MANAGER ROUTES
// ==============================================
Route::prefix('manager')->group(function () {
    Route::middleware('manager.guest')->group(function () {
        // (Add manager guest routes if needed)
    });

    Route::middleware('manager.auth')->group(function () {
        Route::get('dashboard', [ManagerDashboardController::class, 'index'])->name('manager.dashboard');
        Route::get('logout', [LoginController::class, 'managerLogout'])->name('manager.logout');
    });
});

// ==============================================
// ADMIN ROUTES
// ==============================================
Route::prefix('admin')->group(function () {
    Route::middleware('admin.guest')->group(function () {
        Route::get('login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });

    Route::middleware('admin.auth')->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('settings', [AdminDashboardController::class, 'adminSettings'])->name('admin.settings');

        // Companies Routes
        Route::resource('companies', CompanyController::class)->names([
            'index' => 'admin.companies.index',
            'create' => 'admin.companies.create',
            'store' => 'admin.companies.store',
            'show' => 'admin.companies.show',
            'edit' => 'admin.companies.edit',
            'update' => 'admin.companies.update',
            'destroy' => 'admin.companies.destroy',
        ]);

        // Customers Routes
        Route::resource('customers', CustomerController::class)->names([
            'index' => 'admin.customers.index',
            'create' => 'admin.customers.create',
            'store' => 'admin.customers.store',
            'show' => 'admin.customers.show',
            'edit' => 'admin.customers.edit',
            'update' => 'admin.customers.update',
            'destroy' => 'admin.customers.destroy',
        ]);

        // Items Routes
        Route::resource('items', ItemController::class)->names([
            'index' => 'admin.items.index',
            'create' => 'admin.items.create',
            'store' => 'admin.items.store',
            'show' => 'admin.items.show',
            'edit' => 'admin.items.edit',
            'update' => 'admin.items.update',
            'destroy' => 'admin.items.destroy',
        ]);

        // Suppliers Routes
        Route::resource('suppliers', SupplierController::class)->names([
            'index' => 'admin.suppliers.index',
            'create' => 'admin.suppliers.create',
            'store' => 'admin.suppliers.store',
            'show' => 'admin.suppliers.show',
            'edit' => 'admin.suppliers.edit',
            'update' => 'admin.suppliers.update',
            'destroy' => 'admin.suppliers.destroy',
        ]);

        // Invoices Routes
        Route::resource('invoices', InvoiceController::class)->names([
            'index' => 'admin.invoices.index',
            'create' => 'admin.invoices.create',
            'store' => 'admin.invoices.store',
            'show' => 'admin.invoices.show',
            'edit' => 'admin.invoices.edit',
            'update' => 'admin.invoices.update',
            'destroy' => 'admin.invoices.destroy',
        ]);

        Route::get('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    });
});