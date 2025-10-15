<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'state_code',
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
