<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CashBankBook;
use Illuminate\Http\Request;

class CashBankBookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = CashBankBook::query();

        // Search functionality
        $search = request('search');
        $searchField = request('search_field', 'all');

        if ($search) {
            if ($searchField === 'all') {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('under', 'like', "%{$search}%")
                    ->orWhere('account_no', 'like', "%{$search}%");
            } else {
                $query->where($searchField, 'like', "%{$search}%");
            }
        }

        $books = $query->orderByDesc('id')->paginate(15);
        
        if (request()->ajax()) {
            return view('admin.cash-bank-books.index', compact('books'));
        }
        
        return view('admin.cash-bank-books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cash-bank-books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Basic Information
            'name' => 'required|string|max:255',
            'alter_code' => 'nullable|string|max:255',
            'under' => 'nullable|string|max:255',
            'opening_balance' => 'nullable|numeric',
            'opening_balance_type' => 'nullable|string|in:D,C',
            'credit_card' => 'nullable|string|in:Y,N,W',
            'bank_charges' => 'nullable|numeric',
            'flag' => 'nullable|string|max:255',
            
            // Contact Information
            'address' => 'nullable|string',
            'address1' => 'nullable|string',
            'telephone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'fax' => 'nullable|string|max:255',
            'birth_day' => 'nullable|date',
            'anniversary_day' => 'nullable|date',
            'contact_person_1' => 'nullable|string|max:255',
            'contact_person_2' => 'nullable|string|max:255',
            'mobile_1' => 'nullable|string|max:255',
            'mobile_2' => 'nullable|string|max:255',
            
            // Account Details
            'account_no' => 'nullable|string|max:255',
            'report_no' => 'nullable|string|max:255',
            
            // GST & Settings
            'input_gst_purchase' => 'nullable|boolean',
            'output_gst_income' => 'nullable|boolean',
            'cheque_clearance_method' => 'nullable|string|in:P,I',
            'receipts' => 'nullable|string|in:S,I',
        ]);

        // Handle boolean fields
        $validated['input_gst_purchase'] = $request->has('input_gst_purchase');
        $validated['output_gst_income'] = $request->has('output_gst_income');

        CashBankBook::create($validated);

        return redirect()->route('admin.cash-bank-books.index')
            ->with('success', 'Cash/Bank Book entry created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(CashBankBook $cashBankBook)
    {
        return view('admin.cash-bank-books.show', compact('cashBankBook'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CashBankBook $cashBankBook)
    {
        return view('admin.cash-bank-books.edit', compact('cashBankBook'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CashBankBook $cashBankBook)
    {
        $validated = $request->validate([
            // Basic Information
            'name' => 'required|string|max:255',
            'alter_code' => 'nullable|string|max:255',
            'under' => 'nullable|string|max:255',
            'opening_balance' => 'nullable|numeric',
            'opening_balance_type' => 'nullable|string|in:D,C',
            'credit_card' => 'nullable|string|in:Y,N,W',
            'bank_charges' => 'nullable|numeric',
            'flag' => 'nullable|string|max:255',
            
            // Contact Information
            'address' => 'nullable|string',
            'address1' => 'nullable|string',
            'telephone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'fax' => 'nullable|string|max:255',
            'birth_day' => 'nullable|date',
            'anniversary_day' => 'nullable|date',
            'contact_person_1' => 'nullable|string|max:255',
            'contact_person_2' => 'nullable|string|max:255',
            'mobile_1' => 'nullable|string|max:255',
            'mobile_2' => 'nullable|string|max:255',
            
            // Account Details
            'account_no' => 'nullable|string|max:255',
            'report_no' => 'nullable|string|max:255',
            
            // GST & Settings
            'input_gst_purchase' => 'nullable|boolean',
            'output_gst_income' => 'nullable|boolean',
            'cheque_clearance_method' => 'nullable|string|in:P,I',
            'receipts' => 'nullable|string|in:S,I',
        ]);

        // Handle boolean fields
        $validated['input_gst_purchase'] = $request->has('input_gst_purchase');
        $validated['output_gst_income'] = $request->has('output_gst_income');

        $cashBankBook->update($validated);

        return redirect()->route('admin.cash-bank-books.index')
            ->with('success', 'Cash/Bank Book entry updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CashBankBook $cashBankBook)
    {
        $cashBankBook->delete();

        return redirect()->route('admin.cash-bank-books.index')
            ->with('success', 'Cash/Bank Book entry deleted successfully');
    }
}
