<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Invoice;
use Illuminate\Http\Request;

class SaleReturnController extends Controller
{
    /**
     * Display sale return transaction form
     */
    public function transaction()
    {
        // Get next return number - simple auto-increment based on all invoices
        $lastInvoice = Invoice::orderBy('invoice_id', 'desc')->first();
        
        if ($lastInvoice) {
            $nextNumber = $lastInvoice->invoice_id + 1;
        } else {
            $nextNumber = 1;
        }
        $nextReturnNo = 'SR' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        
        // Get customers and items
        $customers = Customer::where('is_deleted', '!=', 1)->orderBy('name')->get();
        $items = Item::where('is_deleted', '!=', 1)->orderBy('name')->get();
        
        return view('admin.sale-return.transaction', compact('nextReturnNo', 'customers', 'items'));
    }

    /**
     * Display sale return modification form
     */
    public function modification()
    {
        return view('admin.sale-return.modification');
    }
}
