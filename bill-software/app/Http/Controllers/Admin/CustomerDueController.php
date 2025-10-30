<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerDue;
use Illuminate\Http\Request;

class CustomerDueController extends Controller
{
    /**
     * View customer dues
     */
    public function index(Customer $customer)
    {
        $dues = $customer->dues()
            ->orderBy('due_date', 'asc')
            ->paginate(20)
            ->withQueryString();

        // For now, using dummy totals - will be calculated from database later
        $totalDebit = 91244.00;
        $totalCredit = 0.00;
        $totalDue = 91244.00;
        $totalPaid = 0.00;
        $totalOutstanding = 91244.00;

        return view('admin.customers.dues', compact(
            'customer',
            'dues',
            'totalDebit',
            'totalCredit',
            'totalDue',
            'totalPaid',
            'totalOutstanding'
        ));
    }

    /**
     * Store due entry
     */
    public function store(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'series' => 'nullable|string|max:50',
            'trans_no' => 'required|string|max:100',
            'invoice_date' => 'required|date',
            'trans_amount' => 'required|numeric|min:0',
            'update_ledger' => 'nullable|boolean',
        ]);

        // Build trans_no with series if provided
        $transNo = $validated['trans_no'];
        if (!empty($validated['series'])) {
            $transNo = $validated['series'] . '/' . $validated['trans_no'];
        }

        // Calculate due date (30 days from invoice date by default)
        $invoiceDate = \Carbon\Carbon::parse($validated['invoice_date']);
        $dueDate = $invoiceDate->copy()->addDays(30);

        // Prepare data for storage
        $dueData = [
            'customer_id' => $customer->id,
            'trans_no' => $transNo,
            'invoice_date' => $validated['invoice_date'],
            'due_date' => $dueDate->toDateString(),
            'trans_amount' => $validated['trans_amount'],
            'debit' => $validated['trans_amount'],  // Debit = Trans Amount
            'credit' => 0,  // Credit = 0 by default
            'days_from_invoice' => $invoiceDate->diffInDays(now()),
            'days_from_due' => $dueDate->diffInDays(now()),
            'hold' => false,
        ];

        // Create the due entry
        $due = CustomerDue::create($dueData);

        return redirect()->route('admin.customers.dues', $customer)
            ->with('success', 'Due entry created successfully. Total: ₹' . number_format($validated['trans_amount'], 2));
    }

    /**
     * View expiry due list
     */
    public function expiryList(Customer $customer)
    {
        // For now, using dummy data - will be calculated from database later
        return view('admin.customers.dues-expiry', compact('customer'));
    }

    /**
     * Delete due entry
     */
    public function destroy(Customer $customer, CustomerDue $due)
    {
        $due->delete();

        return redirect()->route('admin.customers.dues', $customer)
            ->with('success', 'Due entry deleted successfully');
    }
}
