<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryManager extends Model
{
    protected $fillable = [
        'code',
        'name',
        'email',
        'mobile',
        'address',
        'designation',
        'reporting_to',
        'target_amount',
        'status',
        'is_deleted',
        'created_date',
        'modified_date'
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'status' => 'integer',
        'is_deleted' => 'integer',
        'created_date' => 'datetime',
        'modified_date' => 'datetime'
    ];
}
