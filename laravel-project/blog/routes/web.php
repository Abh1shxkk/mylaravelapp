

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Usercontroller2;

// Route::get('/', function () {
//     return view('home'); // home.blade.php ko load karega
// });

// Route::get('/about', function () {
//     return view('about'); // about.blade.php banao
// });

// Route::get('/contact', function () {
//     return view('contact'); // contact.blade.php banao
// });

Route::get('userr',[Usercontroller2::class,'userabout']);