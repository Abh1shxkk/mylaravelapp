<?php

use App\Http\Controllers\Uploadcontroller;

use App\Http\Controllers\Usercontroller4;
use App\Http\Controllers\Usercontroller10;
use App\Http\Controllers\Mailcontroller;


Route::view('insert','crudinsert');
Route::post('insert',[Usercontroller4::class,'add']);
Route::get('crudgetdata',[Usercontroller4::class,'getdata']);
Route::get('delete/{id}',[Usercontroller4::class,'delete']);
Route::get('edit/{id}',[Usercontroller4::class,'edit']);
Route::put('edituser/{id}',[Usercontroller4::class,'update']);
Route::get('crudgetdata', action: [Usercontroller4::class, 'getdata']);
Route::delete('delete-multiple', [Usercontroller4::class, 'deleteMultiple']);
Route::view('about1','about1');
Route::view('home1','home1');
Route::view('login1','login1');
Route::get('access',[Usercontroller10::class,'list']);
Route::get('mutat',[Usercontroller10::class,'get']);
Route::post('mail1',[Mailcontroller::class,'mail']);
Route::view('mail1','send-email');