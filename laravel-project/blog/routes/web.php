<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
// use App\Http\Controllers\Newcontroller;

/*
|--------------------------------------------------------------------------
// | Example 1: Simple Routes
// |--------------------------------------------------------------------------
// */

// // Direct static views (no controller needed)
// Route::view('/home', 'home');     // URL => /home → resources/views/home.blade.php
// Route::view('/about', 'about');   // URL => /about → resources/views/about.blade.php

// // Controller routes
// Route::get('/student-show', [UserController::class, 'show']); // URL => /student-show
// Route::get('/student-row', [UserController::class, 'row']);   // URL => /student-row


// /*
// |--------------------------------------------------------------------------
// | Example 2: Route Group with Prefix
// |--------------------------------------------------------------------------
// */
// Route::prefix('students')->group(function () {
//     Route::view('/home', 'home');     // URL => /students/home
//     Route::view('/about', 'about');   // URL => /students/about

//     Route::get('/show', [UserController::class, 'show']); // URL => /students/show
//     Route::get('/row', [UserController::class, 'row']);   // URL => /students/row
// });


// /*
// |--------------------------------------------------------------------------
// | Example 3: Route Group with Controller
// |--------------------------------------------------------------------------
// */
// Route::controller(Newcontroller::class)->group(function () {
//     Route::get('/show', 'show'); // URL => /show → Newcontroller@show
//     Route::get('/row', 'row');   // URL => /row → Newcontroller@row
// });


// /*
// |--------------------------------------------------------------------------
// | Example 4: Prefix + Controller (Best Practice)
// |--------------------------------------------------------------------------
// */
// Route::prefix('admin')->controller(Newcontroller::class)->group(function () {
//     Route::get('/dashboard', 'dashboard'); // URL => /admin/dashboard
//     Route::get('/users', 'users');         // URL => /admin/users
// });

Route::view('home','home')->middleware('check1');