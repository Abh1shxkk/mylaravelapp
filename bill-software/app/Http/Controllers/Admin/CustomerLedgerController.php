<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerLedger;
use Illuminate\Http\Request;

class CustomerLedgerController extends Controller
{
    /**
     * View customer ledger
     */
    public function index(Customer $customer)
    {
        $fromDate = request('from_date', now()->startOfMonth()->toDateString());
        $toDate = request('to_date', now()->toDateString());

        $ledgers = $customer->ledgers()
            ->dateRange($fromDate, $toDate)
            ->orderBy('transaction_date', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('admin.customers.ledger', compact(
            'customer',
            'ledgers',
            'fromDate',
            'toDate'
        ));
    }

    /**
     * Store ledger entry
     */
    public function store(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'transaction_date' => 'required|date',
            'trans_no' => 'nullable|string|max:100',
            'transaction_type' => 'required|in:Sale,Return,Payment,Adjustment',
            'amount' => 'required|numeric|min:0',
            'remarks' => 'nullable|string',
        ]);

        $validated['customer_id'] = $customer->id;

        // Calculate running balance
        $lastLedger = $customer->ledgers()->latest('transaction_date')->first();
        $lastBalance = $lastLedger ? $lastLedger->running_balance : $customer->opening_balance ?? 0;

        if ($validated['transaction_type'] === 'Sale') {
            $validated['running_balance'] = $lastBalance + $validated['amount'];
        } elseif ($validated['transaction_type'] === 'Return') {
            $validated['running_balance'] = $lastBalance - $validated['amount'];
        } elseif ($validated['transaction_type'] === 'Payment') {
            $validated['running_balance'] = $lastBalance - $validated['amount'];
        } else {
            $validated['running_balance'] = $lastBalance + $validated['amount'];
        }

        CustomerLedger::create($validated);

        return redirect()->route('admin.customers.ledger', $customer)
            ->with('success', 'Ledger entry created successfully');
    }

    /**
     * Delete ledger entry
     */
    public function destroy(Customer $customer, CustomerLedger $ledger)
    {
        $ledger->delete();

        return redirect()->route('admin.customers.ledger', $customer)
            ->with('success', 'Ledger entry deleted successfully');
    }

    /**
     * View expiry ledger
     */
    public function expiryLedger(Customer $customer)
    {
        $ledgers = $customer->ledgers()
            ->orderBy('transaction_date', 'desc')
            ->paginate(20);

        return view('admin.customers.expiry-ledger', compact(
            'customer',
            'ledgers'
        ));
    }

    /**
     * Store expiry ledger entry
     */
    public function storeExpiryLedger(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'transaction_date' => 'required|date',
            'trans_no' => 'nullable|string|max:100',
            'transaction_type' => 'required|in:Sale,Return,Payment,Adjustment',
            'amount' => 'required|numeric|min:0',
            'remarks' => 'nullable|string',
        ]);

        $validated['customer_id'] = $customer->id;

        CustomerLedger::create($validated);

        return redirect()->route('admin.customers.expiry-ledger', $customer)
            ->with('success', 'Expiry ledger entry created successfully');
    }

    /**
     * Delete expiry ledger entry
     */
    public function destroyExpiryLedger(Customer $customer, CustomerLedger $ledger)
    {
        $ledger->delete();

        return redirect()->route('admin.customers.expiry-ledger', $customer)
            ->with('success', 'Expiry ledger entry deleted successfully');
    }
}
