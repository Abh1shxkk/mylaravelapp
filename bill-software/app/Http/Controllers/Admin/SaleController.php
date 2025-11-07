<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Customer;
use App\Models\SalesMan;
use App\Models\Item;
use Illuminate\Support\Facades\Log;

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
                'invoice_no' => 'required|string',
                'series' => 'nullable|string',
                'items' => 'required|array|min:1',
                'items.*.item_name' => 'required|string',
                'items.*.qty' => 'required|numeric|min:0',
                'items.*.rate' => 'required|numeric|min:0',
            ]);

            // Use invoice_no from request if provided, otherwise generate
            $invoiceNo = $request->invoice_no ?? $this->generateInvoiceNumber();
            
            // Calculate total from items
            $total = 0;
            if ($request->has('items')) {
                foreach ($request->items as $item) {
                    $total += floatval($item['amount'] ?? 0);
                }
            }
            
            // Create Sale
            $sale = Sale::create([
                'series' => $request->series ?? 'SB',
                'date' => $request->date,
                'invoice_no' => $invoiceNo,
                'due_date' => $request->due_date,
                'customer_id' => $request->customer_id,
                'salesman_id' => $request->salesman_id,
                'cash_type' => $request->cash_type ?? 'N',
                'total' => $total,
                'status' => 'pending',
            ]);

            // Create Sale Items
            if ($request->has('items')) {
                foreach ($request->items as $item) {
                    if (!empty($item['item_name'])) {
                        SaleItem::create([
                            'sale_id' => $sale->id,
                            'code' => $item['item_code'] ?? $item['code'] ?? null,
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
            Log::error('Sale Store Error: ' . $e->getMessage());
            Log::error('Stack Trace: ' . $e->getTraceAsString());
            
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
        $items = Item::select('items.id', 'items.name', 'items.bar_code', 'items.s_rate', 'items.mrp', 'items.packing', 
                             'items.hsn_code', 'items.cgst_percent', 'items.sgst_percent', 'items.cess_percent',
                             'items.case_qty', 'items.box_qty', 'items.unit', 'items.company_id', 'items.company_short_name',
                             'companies.name as company_name')
                     ->leftJoin('companies', 'items.company_id', '=', 'companies.id')
                     ->where('items.is_deleted', '!=', 1)
                     ->orderBy('items.name')
                     ->get();
        
        // Add company_name or company_short_name to each item
        $items->transform(function ($item) {
            $item->company = $item->company_name ?? $item->company_short_name ?? 'N/A';
            return $item;
        });
        
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
