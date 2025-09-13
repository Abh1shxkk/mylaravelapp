<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Usercontroller2
{
    function flashsession(Request $request){


$request->session()->flash('message', 'user added');

$request->session()->flash('name', $request->input('username'));


        return redirect ('flashsession');
    }
}
