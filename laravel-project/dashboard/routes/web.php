<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

// Home redirect
Route::get('/', function () {
    return redirect('/dashboard/login');
});

// Simple auth routes
Route::get('/dashboard/login', [AuthController::class, 'showLogin'])->name('dashboard.login');
Route::post('/dashboard/login', [AuthController::class, 'login']);

Route::get('/dashboard/register', [AuthController::class, 'showRegister'])->name('dashboard.register');
Route::post('/dashboard/register', [AuthController::class, 'register']);

// Password reset (placeholder to avoid missing route error)
Route::get('/dashboard/password/reset', function () {
    return redirect()->route('dashboard.login')->with('status', 'Password reset is not configured.');
})->name('dashboard.password.request');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard home
    Route::get('/dashboard/home', [AuthController::class, 'home'])->name('dashboard.home');
    Route::get('/dashboard', [AuthController::class, 'home'])->name('dashboard'); // Alternative route
    Route::post('/dashboard/logout', [AuthController::class, 'logout'])->name('dashboard.logout');
    
    // Profile management routes
    Route::get('/profile/settings', [ProfileController::class, 'show'])->name('profile.settings');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/upload-picture', [ProfileController::class, 'uploadPicture'])->name('profile.upload-picture');
    Route::delete('/profile/remove-picture', [ProfileController::class, 'removePicture'])->name('profile.remove-picture');
    Route::patch('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');

    // Admin: Users CRUD
    Route::middleware(['role:admin'])->prefix('dashboard/admin')->as('admin.')->group(function () {
        Route::get('/users', [\App\Http\Controllers\Admin\AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [\App\Http\Controllers\Admin\AdminUserController::class, 'create'])->name('users.create');
        Route::post('/users', [\App\Http\Controllers\Admin\AdminUserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}', [\App\Http\Controllers\Admin\AdminUserController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit', [\App\Http\Controllers\Admin\AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [\App\Http\Controllers\Admin\AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [\App\Http\Controllers\Admin\AdminUserController::class, 'destroy'])->name('users.destroy');
    });
});

// Role-based routes (optional - add these if you want role-based access)

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/users', function () {
        return view('admin.users');
    })->name('admin.users');
    
    Route::get('/admin/settings', function () {
        return view('admin.settings');
    })->name('admin.settings');
});

Route::middleware(['auth', 'role:admin,manager'])->group(function () {
    Route::get('/reports', function () {
        return view('reports.index');
    })->name('reports.index');
});
