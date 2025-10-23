<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PurchaseLedger;
use Illuminate\Http\Request;

class PurchaseLedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = PurchaseLedger::query();
        
        // Search functionality
        if (request('search')) {
            $search = request('search');
            $searchField = request('search_field', 'all');
            
            if ($searchField === 'all') {
                $query->where(function ($q) use ($search) {
                    $q->where('ledger_name', 'like', "%{$search}%")
                      ->orWhere('alter_code', 'like', "%{$search}%")
                      ->orWhere('contact_1', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('mobile_1', 'like', "%{$search}%");
                });
            } else {
                $query->where($searchField, 'like', "%{$search}%");
            }
        }
        
        $ledgers = $query->orderByDesc('id')->paginate(10);
        
        if (request()->ajax()) {
            return view('admin.purchase-ledger.index', compact('ledgers'));
        }
        
        return view('admin.purchase-ledger.index', compact('ledgers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.purchase-ledger.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Ledger Information
            'ledger_name' => 'nullable|string|max:255',
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
            // Contact Information
            'address' => 'nullable|string',
            'birth_day' => 'nullable|date',
            'anniversary' => 'nullable|date',
            'telephone' => 'nullable|string|max:50',
            'fax' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'contact_1' => 'nullable|string|max:255',
            'mobile_1' => 'nullable|string|max:50',
            'contact_2' => 'nullable|string|max:255',
            'mobile_2' => 'nullable|string|max:50',
        ]);

        PurchaseLedger::create($validated);

        return redirect()->route('admin.purchase-ledger.index')
            ->with('success', 'Purchase Ledger entry created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseLedger $purchaseLedger)
    {
        return view('admin.purchase-ledger.show', compact('purchaseLedger'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseLedger $purchaseLedger)
    {
        return view('admin.purchase-ledger.edit', compact('purchaseLedger'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseLedger $purchaseLedger)
    {
        $validated = $request->validate([
            // Ledger Information
            'ledger_name' => 'nullable|string|max:255',
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
            // Contact Information
            'address' => 'nullable|string',
            'birth_day' => 'nullable|date',
            'anniversary' => 'nullable|date',
            'telephone' => 'nullable|string|max:50',
            'fax' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'contact_1' => 'nullable|string|max:255',
            'mobile_1' => 'nullable|string|max:50',
            'contact_2' => 'nullable|string|max:255',
            'mobile_2' => 'nullable|string|max:50',
        ]);

        $purchaseLedger->update($validated);

        return redirect()->route('admin.purchase-ledger.index')
            ->with('success', 'Purchase Ledger entry updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseLedger $purchaseLedger)
    {
        $purchaseLedger->delete();

        return redirect()->route('admin.purchase-ledger.index')
            ->with('success', 'Purchase Ledger entry deleted successfully');
    }
}
