<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function Laravel\Prompts\password;

class rq1   
{
 function rq1(Request $REQUEST){

    $REQUEST->session()->put('user',$REQUEST->input('user') );
// return $REQUEST->session('user');

echo session('user');
// return redirect('profile');
}
}