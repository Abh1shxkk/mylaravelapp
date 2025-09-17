<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'userdata';
    protected $fillable = ['name', 'email', 'phone', 'image'];
}
