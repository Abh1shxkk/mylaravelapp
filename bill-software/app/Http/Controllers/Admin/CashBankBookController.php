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
            'transaction_date' => 'required|date',
            'transaction_type' => 'required|string|in:Cash,Bank',
            'particulars' => 'required|string|max:255',
            'voucher_no' => 'nullable|string|max:50',
            'debit' => 'nullable|numeric',
            'credit' => 'nullable|numeric',
            'balance' => 'nullable|numeric',
            'description' => 'nullable|string',
        ]);

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
            'transaction_date' => 'required|date',
            'transaction_type' => 'required|string|in:Cash,Bank',
            'particulars' => 'required|string|max:255',
            'voucher_no' => 'nullable|string|max:50',
            'debit' => 'nullable|numeric',
            'credit' => 'nullable|numeric',
            'balance' => 'nullable|numeric',
            'description' => 'nullable|string',
        ]);

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
