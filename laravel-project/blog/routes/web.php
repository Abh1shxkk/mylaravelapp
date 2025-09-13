<?php

use App\Http\Controllers\Uploadcontroller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Usercontroller;
use  App\Http\Controllers\Studentscontroller;
use App\Http\Controllers\Httpusercontroller;
use App\Http\Controllers\querybuilder;
use App\Http\Controllers\rq1;
use App\Http\Controllers\Usercontroller1;
use App\Http\Controllers\Usercontroller2;



Route::get('/students',[Studentscontroller::class,'getstudents']);

Route::get('http',[Httpusercontroller::class,'http']);

Route::get('query',[querybuilder::class,'queries']);

Route::view('user',view: 'rq1');

Route::post('rq1',[rq1::class,'rq1']);

Route::view('profile','profile');

Route::view('login',view: 'login');

Route::post('login1',[Usercontroller1::class,'login']);

Route::view('profile1',view: 'profile1');

Route::get('logout',[Usercontroller1::class,'logout']);

Route::view('flashsession',view: 'flashsession');

Route::post('session',[Usercontroller2::class,'flashsession']);

Route::view('upload','upload');

Route::post('uploaddata',[Uploadcontroller::class,'uploadfile']);

Route::view('display','display');

Route:: view('welcome','welcome');

Route::view('about1','about1');

// routes/web.php

Route::get('welcome/{lang}', function ($lang) {
    App::setLocale($lang);


    return view('welcome');

});

Route::get('setlang/{lang}', function ($lang) {
   

Session::put('lang',$lang);
    
return redirect('welcome');

});

Route::middleware('setlang')->group(function(){

    Route::get('welcome/{lang}', function ($lang) {
    App::setLocale($lang);


    return view('welcome');

});

Route::get('setlang/{lang}', function ($lang) {
   

Session::put('lang',$lang);
    
return redirect('welcome');

});

Route:: view('welcome','welcome');

Route::view('about1','about1');


});

Route::view('insertdata','insertdata');


