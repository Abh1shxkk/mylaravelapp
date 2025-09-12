<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Usercontroller;
use  App\Http\Controllers\Studentscontroller;
use App\Http\Controllers\Httpusercontroller;
use App\Http\Controllers\querybuilder;
use App\Http\Controllers\rq1;


Route::get('/students',[Studentscontroller::class,'getstudents']);

Route::get('http',[Httpusercontroller::class,'http']);

Route::get('query',[querybuilder::class,'queries']);

Route::view('user',view: 'rq1');

Route::post('rq1',[rq1::class,'rq1']);

Route::view('profile','profile');