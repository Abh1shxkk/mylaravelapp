<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'area_code',
        'sales_man_code',
        'distance_km',
        'status',
        'is_deleted',
        'created_date',
        'modified_date'
    ];

    protected $casts = [
        'distance_km' => 'decimal:2',
        'status' => 'integer',
        'is_deleted' => 'integer',
        'created_date' => 'datetime',
        'modified_date' => 'datetime'
    ];
}
