<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController1 
{
    public function login(Request $request)
    {
        // Store session
        $request->session()->put('user', $request->input('user'));

        // Redirect to profile1 route
      

        // echo session('user');

        $request->session()->put('allData', $request->input());

  return redirect('profile1');

    }


    function logout(){
         session()->pull('user');
         return redirect('profile1');
    }
}
