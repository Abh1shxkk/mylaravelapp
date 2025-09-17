<?php

use App\Http\Controllers\Userauthcontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Apicontroller;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('api',function(){

    return ['name'=>'abhishek chauhan','email'=>'email@test.com'];
});

// Route::get('students',action: [Apicontroller::class,'api1']);
// Route::post('students1',[Apicontroller::class,'api2']);
Route::put('update',[Apicontroller::class,'update']);
Route::delete('update1/{id}',[Apicontroller::class,'delete']);

Route::post('signup4',[Userauthcontroller::class,'signup']);
Route::post('login4',[Userauthcontroller::class,'login']);



