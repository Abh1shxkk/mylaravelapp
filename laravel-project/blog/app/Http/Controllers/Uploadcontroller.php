<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Uploadcontroller
{
    function uploadfile(Request $request)
    {
        // File ko public storage me save karo
        $path = $request->file('file')->store('public');

        // Sirf filename nikalo
        $filename = basename($path);

        // Display view me bhej do
        return view('display', ['path' => $filename]);
    }
}
