<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Httpusercontroller
{
    function http(){
$response=Http::get('https://jsonplaceholder.typicode.com/posts/1');
        // return $response->headers();
        return view('httpuser',['httpuser'=>json_decode($response)]);
    }
}
