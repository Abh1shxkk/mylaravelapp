<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Card;

class Apicontroller extends Controller
{
    function api1()
    {
        return Card::all();   // fetch all data from `cards`
    }

    function api2(Request $request)
    {

        $students = new Card();
        $students->name = $request->name;
        $students->email = $request->email;
        $students->phone = $request->phone;
        if (
            $students->save()
        ) {

            return ["result" => "success"];
        } else {
            return ["result" => "failed"];
        }
    }

    function update(Request $request)
    {

        $students = Card::find($request->id);
        $students->name = $request->name;
        $students->email = $request->email;
        $students->phone = $request->phone;
        if($students->save()){

            return ["result"=>"success"];
        }else{
            return ["result"=>"failed"];
        }
    }

      function delete($id)
    {

       
        $students= Card::destroy($id);
        if($students){

            return ["result"=>"success"];
        }else{
            return ["result"=>"failed"];
        }
    }
}
