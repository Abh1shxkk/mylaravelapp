<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BreakageExpiryController extends Controller
{
    /**
     * Display breakage/expiry transaction form
     */
    public function transaction()
    {
        return view('admin.breakage-expiry.transaction');
    }

    /**
     * Display breakage/expiry modification form
     */
    public function modification()
    {
        return view('admin.breakage-expiry.modification');
    }

    /**
     * Display expiry date modification form
     */
    public function expiryDate()
    {
        return view('admin.breakage-expiry.expiry-date');
    }
}
