<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Usercontroller2 extends Controller
{
    // function nw1(){
    //     return view('newview1');
    // }

    // function nw2(){
    //     return view('about');
 
    // }

     function nw3(){

        $name="abhishek";
        $user=['abhi','name','sss','dhbc'];
        return view('home',['name'=>$name,'users'=>$user]);
 
    }

    function userabout(){
   return view('about');
    }
 
    

}
