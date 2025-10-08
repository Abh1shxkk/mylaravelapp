<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\ProfileController;

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('welcome');
});

// Admin
Route::middleware(['admin'])->group(function () {
    Route::view('/admin/dashboard', 'admin.dashboard');
    Route::prefix('admin')->name('admin.')->group(function(){
        Route::resource('companies', CompanyController::class);
        Route::resource('customers', CustomerController::class);
        Route::resource('items', ItemController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('invoices', InvoiceController::class);
    });
    Route::post('/profile/update', [ProfileController::class,'update'])->name('profile.update');
    Route::get('/password/change', [ProfileController::class,'showChangePassword'])->name('password.change.form');
    Route::post('/password/change', [ProfileController::class,'changePassword'])->name('password.change');
});

// User
Route::middleware(['user'])->group(function () {
    Route::view('/user/dashboard', 'user.dashboard');
});
