<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SaleLedger;
use Illuminate\Http\Request;

class SaleLedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');
        $searchField = request('search_field', 'all');
        
        $ledgers = SaleLedger::query()
            ->when($search && trim($search) !== '', function ($query) use ($search, $searchField) {
                $search = trim($search);
                
                if ($searchField === 'all') {
                    // Search across all fields
                    $query->where(function ($q) use ($search) {
                        $q->where('ledger_name', 'like', "%{$search}%")
                            ->orWhere('alter_code', 'like', "%{$search}%")
                            ->orWhere('type', 'like', "%{$search}%")
                            ->orWhere('status', 'like', "%{$search}%")
                            ->orWhere('under', 'like', "%{$search}%")
                            ->orWhere('contact_1', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('telephone', 'like', "%{$search}%");
                    });
                } else {
                    // Search in specific field
                    $validFields = ['ledger_name', 'alter_code', 'type', 'status', 'under', 'contact_1', 'email', 'telephone'];
                    if (in_array($searchField, $validFields)) {
                        $query->where($searchField, 'like', "%{$search}%");
                    }
                }
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();
        
        if (request()->ajax()) {
            return view('admin.sale-ledger.index', compact('ledgers', 'search', 'searchField'));
        }
        
        return view('admin.sale-ledger.index', compact('ledgers', 'search', 'searchField'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sale-ledger.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ledger_name' => 'required|string|max:255',
            'form_type' => 'nullable|string|max:50',
            'sale_tax' => 'nullable|numeric',
            'desc' => 'nullable|string',
            'type' => 'nullable|in:L,C',
            'status' => 'nullable|string|max:50',
            'alter_code' => 'nullable|string|max:50',
            'opening_balance' => 'nullable|numeric',
            'form_required' => 'nullable|in:Y,N',
            'charges' => 'nullable|numeric',
            'under' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'birth_day' => 'nullable|date',
            'anniversary' => 'nullable|date',
            'telephone' => 'nullable|string|max:50',
            'fax' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'contact_1' => 'nullable|string|max:255',
            'mobile_1' => 'nullable|string|max:20',
            'contact_2' => 'nullable|string|max:255',
            'mobile_2' => 'nullable|string|max:20',
        ]);

        SaleLedger::create($validated);

        return redirect()->route('admin.sale-ledger.index')
            ->with('success', 'Sale Ledger entry created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(SaleLedger $saleLedger)
    {
        return view('admin.sale-ledger.show', compact('saleLedger'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SaleLedger $saleLedger)
    {
        return view('admin.sale-ledger.edit', compact('saleLedger'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SaleLedger $saleLedger)
    {
        $validated = $request->validate([
            'ledger_name' => 'required|string|max:255',
            'form_type' => 'nullable|string|max:50',
            'sale_tax' => 'nullable|numeric',
            'desc' => 'nullable|string',
            'type' => 'nullable|in:L,C',
            'status' => 'nullable|string|max:50',
            'alter_code' => 'nullable|string|max:50',
            'opening_balance' => 'nullable|numeric',
            'form_required' => 'nullable|in:Y,N',
            'charges' => 'nullable|numeric',
            'under' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'birth_day' => 'nullable|date',
            'anniversary' => 'nullable|date',
            'telephone' => 'nullable|string|max:50',
            'fax' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'contact_1' => 'nullable|string|max:255',
            'mobile_1' => 'nullable|string|max:20',
            'contact_2' => 'nullable|string|max:255',
            'mobile_2' => 'nullable|string|max:20',
        ]);

        $saleLedger->update($validated);

        return redirect()->route('admin.sale-ledger.index')
            ->with('success', 'Sale Ledger entry updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SaleLedger $saleLedger)
    {
        $saleLedger->delete();

        return redirect()->route('admin.sale-ledger.index')
            ->with('success', 'Sale Ledger entry deleted successfully');
    }
}
