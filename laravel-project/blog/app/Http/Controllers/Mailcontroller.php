<?php

namespace App\Http\Controllers;

use App\Mail\Welcomeemail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
class Mailcontroller
{
  function mail(Request $request){

    $to=$request->to;
    $msg=$request->subject;
    $subject=$request->message;

    Mail::to($to)->send(new Welcomeemail($msg,$subject));
return "email sent";
  }
}
