<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PurchaseReturnController extends Controller
{
    /**
     * Display purchase return transaction form
     */
    public function transaction()
    {
        return view('admin.purchase-return.transaction');
    }

    /**
     * Display purchase return modification form
     */
    public function modification()
    {
        return view('admin.purchase-return.modification');
    }
}
