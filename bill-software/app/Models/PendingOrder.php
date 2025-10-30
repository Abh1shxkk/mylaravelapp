<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingOrder extends Model
{
    protected $fillable = [
        'item_id',
        'supplier_id',
        'order_date',
        'rate',
        'tax_percent',
        'discount_percent',
        'cost',
        'scm_percent',
        'quantity',
        'free_quantity',
        'urgent_flag',
        'scheme_plus',
        'scheme_minus',
        'days_pending',
        'status',
        'remarks',
    ];

    protected $casts = [
        'order_date' => 'date',
        'rate' => 'decimal:2',
        'tax_percent' => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'cost' => 'decimal:2',
        'scm_percent' => 'decimal:2',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_id');
    }
}
