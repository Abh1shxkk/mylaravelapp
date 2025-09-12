<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class Usercontroller
{
    function users(){

       $users=  DB::select('select * from users');
       return view('users',['users'=>$users]);
    }
}
