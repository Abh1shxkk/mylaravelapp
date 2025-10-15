<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = [
        'code',
        'name',
        'country_code',
        'gst_state_code',
        'region',
        'status',
        'is_deleted',
        'created_date',
        'modified_date'
    ];

    protected $casts = [
        'status' => 'integer',
        'is_deleted' => 'integer',
        'created_date' => 'datetime',
        'modified_date' => 'datetime'
    ];
}
