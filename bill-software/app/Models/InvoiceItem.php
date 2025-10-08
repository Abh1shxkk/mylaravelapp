<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $primaryKey = 'item_id';

    protected $fillable = [
        'invoice_id','product_id','product_name','product_description','hsn_code','quantity','unit','unit_price','discount_percent','discount_amount','line_total','tax_rate','tax_amount','cgst_rate','sgst_rate','igst_rate','cess_rate'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'invoice_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'product_id');
    }
}
