<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Customer;
use App\Models\SalesMan;
use App\Models\Item;

class SaleController extends Controller
{
    /**
     * Show Sale Transaction page
     */
    public function transaction()
    {
        $customers = Customer::orderBy('name')->get();
        $salesmen = SalesMan::orderBy('name')->get();
        $nextInvoiceNo = $this->generateInvoiceNumber();
        
        return view('admin.sale.transaction', compact('customers', 'salesmen', 'nextInvoiceNo'));
    }

    /**
     * Store Sale Transaction
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'customer_id' => 'required|exists:customers,id',
                'date' => 'required|date',
                'due_date' => 'nullable|date',
                'salesman_id' => 'nullable|exists:sales_men,id',
            ]);

            // Generate invoice number
            $invoiceNo = $this->generateInvoiceNumber();
            
            // Create Sale
            $sale = Sale::create([
                'series' => $request->series ?? 'SZ',
                'date' => $request->date,
                'invoice_no' => $invoiceNo,
                'due_date' => $request->due_date,
                'customer_id' => $request->customer_id,
                'salesman_id' => $request->salesman_id,
                'cash_type' => $request->cash_type ?? 'N',
                'total' => $request->total ?? 0,
                'status' => 'pending',
            ]);

            // Create Sale Items
            if ($request->has('items')) {
                foreach ($request->items as $item) {
                    if (!empty($item['item_name'])) {
                        SaleItem::create([
                            'sale_id' => $sale->id,
                            'code' => $item['code'] ?? null,
                            'item_name' => $item['item_name'],
                            'batch' => $item['batch'] ?? null,
                            'expiry' => $item['expiry'] ?? null,
                            'qty' => $item['qty'] ?? 0,
                            'free_qty' => $item['free_qty'] ?? 0,
                            'rate' => $item['rate'] ?? 0,
                            'discount' => $item['discount'] ?? 0,
                            'mrp' => $item['mrp'] ?? 0,
                            'amount' => $item['amount'] ?? 0,
                        ]);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Sale transaction saved successfully!',
                'sale_id' => $sale->id,
                'invoice_no' => $invoiceNo
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Items for dropdown (AJAX)
     */
    public function getItems()
    {
        $items = Item::select('id', 'name', 'bar_code', 's_rate', 'mrp', 'packing', 
                             'hsn_code', 'cgst_percent', 'sgst_percent', 'cess_percent',
                             'case_qty', 'box_qty')
                     ->orderBy('name')
                     ->get();
        
        return response()->json($items);
    }

    /**
     * Show Sale Modification page
     */
    public function modification()
    {
        $sales = Sale::with('customer', 'salesman')->latest()->take(10)->get();
        return view('admin.sale.modification', compact('sales'));
    }

    /**
     * Generate Invoice Number
     */
    private function generateInvoiceNumber()
    {
        $lastSale = Sale::latest('id')->first();
        $number = $lastSale ? intval($lastSale->invoice_no) + 1 : 1;
        return (string) $number;
    }
}
