<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Studentscontroller
{
    function getstudents(){
            $students=\App\Models\student::all();
        return view('students',['students'=>$students]);
    }
}
