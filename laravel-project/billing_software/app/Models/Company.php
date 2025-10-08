<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'email',
        'contact_person_1',
        'contact_person_2',
        'website',
        'mobile_1',
        'mobile_2',
        'telephone',
        'alter_code',
        'short_name',
        'location',
        'pur_sc',
        'sale_sc',
        'pur_tax',
        'sale_tax',
        'dis_on_sale_percent',
        'min_gp',
        'vat_percent',
        'fixed_maximum',
        'discount',
        'invoice_print_order',
        'disallow_expiry_after_months',
        'flag',
        'expiry',
        'generic',
        'direct_indirect',
        'surcharge_after_dis_yn',
        'add_surcharge_yn',
        'inclusive_yn',
        'status',
        'is_deleted'
    ];

    protected $casts = [
        'expiry' => 'date',
        'pur_sc' => 'decimal:2',
        'sale_sc' => 'decimal:2',
        'pur_tax' => 'decimal:2',
        'sale_tax' => 'decimal:2',
        'dis_on_sale_percent' => 'decimal:2',
        'min_gp' => 'decimal:2',
        'vat_percent' => 'decimal:2',
        'fixed_maximum' => 'decimal:2',
        'discount' => 'decimal:2',
        'deleted_at' => 'datetime',
    ];
}