<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Item;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::latest()->paginate(20);
        return view('admin.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $companies = Company::orderBy('name')->get();
        $customers = Customer::orderBy('name')->get();
        $items = Item::orderBy('name')->get();
        
        return view('admin.invoices.create', compact('companies', 'customers', 'items'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Invoice::create($data);
        return redirect()->route('admin.invoices.index')->with('success', 'Invoice created');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('items');
        return view('admin.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $companies = Company::orderBy('name')->get();
        $customers = Customer::orderBy('name')->get();
        $items = Item::orderBy('name')->get();
        $invoice->load('items');
        return view('admin.invoices.edit', compact('invoice', 'companies', 'customers', 'items'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $data = $request->all();
        $invoice->update($data);
        return redirect()->route('admin.invoices.index')->with('success', 'Invoice updated');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return back()->with('success', 'Invoice deleted');
    }
}


