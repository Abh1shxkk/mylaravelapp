<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesMan extends Model
{
    protected $table = 'sales_men';
    
    protected $fillable = [
        'code',
        'name',
        'email',
        'mobile',
        'address',
        'designation',
        'target_amount',
        'commission_percent',
        'status',
        'is_deleted',
        'created_date',
        'modified_date'
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'commission_percent' => 'decimal:2',
        'status' => 'integer',
        'is_deleted' => 'integer',
        'created_date' => 'datetime',
        'modified_date' => 'datetime'
    ];
}
