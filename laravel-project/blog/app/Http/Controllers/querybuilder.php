<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\table;

class querybuilder
{
    function queries()
    {

        // $results = DB::table(table: 'users')->get();
        // return view('queries', ['query' => $results]);

        // $results = DB::table(table: 'users')->insert(['name'=>'abhishek',
        // 'email'=>'abhi@testt.com',
        // 'phone'=>'985642018']);


         $results = DB::table(table: 'users')->where('id',4)->update(['phone'=>'99']);
                //  $results = DB::table(table: 'users')->where('name','abhishek')->delete();

        // 'email'=>'abhi@testt.com',
        // 'phone'=>'985642018']);

        if($results){
            echo "results updated";
        }
        else{
            echo "not"
;        }

    }
}
