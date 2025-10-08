<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'customer_master';

    // Use custom timestamp columns defined in migration
    public const CREATED_AT = 'created_date';
    public const UPDATED_AT = 'modified_date';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'code',
        'tax_registration',
        'pin_code',
        'address',
        'city',
        'telephone_office',
        'telephone_residence',
        'mobile',
        'email',
        'contact_person1',
        'mobile_contact1',
        'contact_person2',
        'mobile_contact2',
        'fax_number',
        'opening_balance',
        'balance_type',
        'local_central',
        'credit_days',
        'birth_day',
        'status',
        'flag',
        'invoice_export',
        'due_list_sequence',
        'tan_number',
        'msme_license',
        'dl_number',
        'dl_expiry',
        'dl_number1',
        'food_license',
        'cst_number',
        'tin_number',
        'pan_number',
        'sales_man_code',
        'area_code',
        'route_code',
        'state_code',
        'business_type',
        'description',
        'order_required',
        'aadhar_number',
        'registration_date',
        'end_date',
        'day_value',
        'cst_registration',
        'gst_name',
        'state_code_gst',
        'registration_status',
    ];

    protected $casts = [
        'opening_balance' => 'decimal:2',
        'birth_day' => 'date',
        'dl_expiry' => 'date',
        'registration_date' => 'date',
        'end_date' => 'date',
        'created_date' => 'datetime',
        'modified_date' => 'datetime',
    ];
}