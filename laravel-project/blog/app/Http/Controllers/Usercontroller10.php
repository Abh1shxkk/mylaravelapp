<?php

namespace App\Http\Controllers;
use App\Models\computer;

use Illuminate\Http\Request;

class Usercontroller10
{
      function list(){

        return computer::all();
    }

    function get(){

        $students= new computer();
        $students->name="adi";
                $students->phone="954631449165";

                        $students->email="jhsbbdgszuyxg@gmail.com";
                        if($students->save()){
                            return "user added";
                        }

    }
}
