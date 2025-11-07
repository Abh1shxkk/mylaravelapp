<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SaleTransaction;
use App\Models\SaleTransactionItem;
use App\Models\Customer;
use App\Models\Item;
use App\Models\SalesMan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SaleTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = SaleTransaction::with('customer')
            ->orderBy('sale_date', 'desc')
            ->paginate(20);
        
        return view('admin.sale.transactions.index', compact('transactions'));
    }

    /**
     * Display sale transaction form
     */
    public function transaction()
    {
        $customers = Customer::where('is_deleted', '!=', 1)->get();
        $salesmen = SalesMan::all();
        $items = Item::all();
        $nextInvoiceNo = $this->generateInvoiceNo();
        
        return view('admin.sale.transaction', compact('customers', 'salesmen', 'items', 'nextInvoiceNo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::where('is_deleted', '!=', 1)->get();
        $salesmen = SalesMan::all();
        $items = Item::all();
        $nextInvoiceNo = $this->generateInvoiceNo();
        
        return view('admin.sale.transaction', compact('customers', 'salesmen', 'items', 'nextInvoiceNo'));
    }

    /**
     * Get all items for Choose Items modal
     */
    public function getItems()
    {
        try {
            $items = Item::select('id', 'name', 'bar_code', 'hsn_code', 'packing', 'company_id', 'company_short_name', 's_rate', 'mrp', 'cgst_percent', 'sgst_percent', 'cess_percent', 'unit', 'case_qty', 'box_qty')
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'bar_code' => $item->bar_code,
                        'hsn_code' => $item->hsn_code,
                        'packing' => $item->packing,
                        'company_name' => $item->company_short_name ?? 'N/A',
                        'company' => $item->company_short_name ?? 'N/A',
                        's_rate' => $item->s_rate ?? 0,
                        'mrp' => $item->mrp ?? 0,
                        'cgst_percent' => $item->cgst_percent ?? 0,
                        'sgst_percent' => $item->sgst_percent ?? 0,
                        'cess_percent' => $item->cess_percent ?? 0,
                        'unit' => $item->unit ?? '1',
                        'case_qty' => $item->case_qty ?? 0,
                        'box_qty' => $item->box_qty ?? 0,
                    ];
                });
            
            return response()->json($items);
        } catch (\Exception $e) {
            Log::error('Error fetching items: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching items: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'date' => 'required|date',
            'customer_id' => 'required|exists:customers,id',
            'invoice_no' => 'required|string|max:100',
            'items' => 'required|array|min:1',
            'items.*.item_code' => 'required|string',
            'items.*.qty' => 'required|numeric|min:0',
            'items.*.rate' => 'required|numeric|min:0',
        ]);
        
        DB::beginTransaction();
        
        try {
            $itemsData = $request->input('items');
            
            // Calculate summary amounts from items
            $summaryAmounts = $this->calculateSummaryAmounts($itemsData);
            
            // Create Master Record
            $transaction = SaleTransaction::create([
                'invoice_no' => $request->input('invoice_no'),
                'series' => $request->input('series', 'SB'),
                'sale_date' => $request->input('date'),
                'due_date' => $request->input('due_date'),
                'customer_id' => $request->input('customer_id'),
                'salesman_id' => $request->input('salesman_id'),
                'cash_flag' => $request->input('cash', 'N'),
                'transfer_flag' => $request->input('transfer', 'N'),
                'remarks' => $request->input('remarks'),
                
                // Summary amounts (calculated from items)
                'nt_amount' => $summaryAmounts['nt_amount'],
                'sc_amount' => 0,
                'ft_amount' => $summaryAmounts['ft_amount'],
                'dis_amount' => $summaryAmounts['dis_amount'],
                'scm_amount' => 0,
                'tax_amount' => $summaryAmounts['tax_amount'],
                'net_amount' => $summaryAmounts['net_amount'],
                'scm_percent' => 0,
                'tcs_amount' => 0,
                'excise_amount' => 0,
                
                // Payment info
                'paid_amount' => 0,
                'balance_amount' => $summaryAmounts['net_amount'],
                'payment_status' => 'pending',
                
                'status' => 'completed',
                'created_by' => Auth::id(),
            ]);
            
            // Create Detail Records (Items)
            foreach ($itemsData as $index => $itemData) {
                // Get item by code (bar_code)
                $item = Item::where('bar_code', $itemData['item_code'])
                    ->orWhere('id', $itemData['item_code'])
                    ->first();
                
                if (!$item) {
                    throw new \Exception("Item not found: " . $itemData['item_code']);
                }
                
                // Calculate item amounts
                $qty = floatval($itemData['qty']);
                $rate = floatval($itemData['rate']);
                $discountPercent = floatval($itemData['discount'] ?? 0);
                
                $amount = $qty * $rate; // Line total before discount
                $discountAmount = $amount * ($discountPercent / 100);
                $amountAfterDiscount = $amount - $discountAmount;
                
                // Get GST from item or use 0
                $cgstPercent = floatval($item->cgst_percent ?? 0);
                $sgstPercent = floatval($item->sgst_percent ?? 0);
                $cessPercent = floatval($item->cess_percent ?? 0);
                
                // Calculate GST amounts on discounted amount
                $cgstAmount = $amountAfterDiscount * ($cgstPercent / 100);
                $sgstAmount = $amountAfterDiscount * ($sgstPercent / 100);
                $cessAmount = $amountAfterDiscount * ($cessPercent / 100);
                $taxAmount = $cgstAmount + $sgstAmount + $cessAmount;
                
                $netAmount = $amountAfterDiscount + $taxAmount;
                
                SaleTransactionItem::create([
                    'sale_transaction_id' => $transaction->id,
                    'item_id' => $item->id,
                    'item_code' => $itemData['item_code'],
                    'item_name' => $itemData['item_name'],
                    'batch_no' => $itemData['batch'] ?? null,
                    'expiry_date' => $itemData['expiry'] ?? null,
                    'qty' => $qty,
                    'free_qty' => floatval($itemData['free_qty'] ?? 0),
                    'sale_rate' => $rate,
                    'mrp' => floatval($itemData['mrp'] ?? 0),
                    'discount_percent' => $discountPercent,
                    'discount_amount' => $discountAmount,
                    'amount' => $amount,
                    'net_amount' => $netAmount,
                    
                    // GST data
                    'cgst_percent' => $cgstPercent,
                    'sgst_percent' => $sgstPercent,
                    'cess_percent' => $cessPercent,
                    'cgst_amount' => $cgstAmount,
                    'sgst_amount' => $sgstAmount,
                    'cess_amount' => $cessAmount,
                    'tax_amount' => $taxAmount,
                    
                    // Additional fields
                    'unit' => $item->unit ?? null,
                    'packing' => $item->packing ?? null,
                    'company_name' => $item->company_short_name ?? null,
                    'hsn_code' => $item->hsn_code ?? null,
                    
                    'row_order' => $itemData['row_order'] ?? $index,
                ]);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Sale transaction saved successfully',
                'invoice_no' => $transaction->invoice_no,
                'id' => $transaction->id
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Sale Transaction Save Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $transaction = SaleTransaction::with(['items', 'customer', 'salesman'])->findOrFail($id);
        
        return view('admin.sale.transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $transaction = SaleTransaction::with(['items', 'customer'])->findOrFail($id);
        $customers = Customer::where('is_deleted', '!=', 1)->get();
        $salesmen = SalesMan::all();
        $items = Item::all();
        
        return view('admin.sale.transaction', [
            'transaction' => $transaction,
            'customers' => $customers,
            'salesmen' => $salesmen,
            'items' => $items,
            'nextInvoiceNo' => $transaction->invoice_no
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $transaction = SaleTransaction::findOrFail($id);
        
        // Validate request
        $validated = $request->validate([
            'date' => 'required|date',
            'customer_id' => 'required|exists:customers,id',
            'invoice_no' => 'required|string|max:100',
            'items' => 'required|array|min:1',
            'items.*.item_code' => 'required|string',
            'items.*.qty' => 'required|numeric|min:0',
            'items.*.rate' => 'required|numeric|min:0',
        ]);
        
        DB::beginTransaction();
        
        try {
            $itemsData = $request->input('items');
            
            // Calculate summary amounts from items
            $summaryAmounts = $this->calculateSummaryAmounts($itemsData);
            
            // Update master record
            $transaction->update([
                'sale_date' => $request->input('date'),
                'due_date' => $request->input('due_date'),
                'customer_id' => $request->input('customer_id'),
                'salesman_id' => $request->input('salesman_id'),
                'cash_flag' => $request->input('cash', 'N'),
                'transfer_flag' => $request->input('transfer', 'N'),
                'remarks' => $request->input('remarks'),
                
                // Summary amounts
                'nt_amount' => $summaryAmounts['nt_amount'],
                'ft_amount' => $summaryAmounts['ft_amount'],
                'dis_amount' => $summaryAmounts['dis_amount'],
                'tax_amount' => $summaryAmounts['tax_amount'],
                'net_amount' => $summaryAmounts['net_amount'],
                
                'updated_by' => Auth::id(),
            ]);
            
            // Delete old items
            $transaction->items()->delete();
            
            // Insert new items
            foreach ($itemsData as $index => $itemData) {
                $item = Item::where('bar_code', $itemData['item_code'])
                    ->orWhere('id', $itemData['item_code'])
                    ->first();
                
                if (!$item) {
                    throw new \Exception("Item not found: " . $itemData['item_code']);
                }
                
                // Calculate item amounts
                $qty = floatval($itemData['qty']);
                $rate = floatval($itemData['rate']);
                $discountPercent = floatval($itemData['discount'] ?? 0);
                
                $amount = $qty * $rate;
                $discountAmount = $amount * ($discountPercent / 100);
                $amountAfterDiscount = $amount - $discountAmount;
                
                $cgstPercent = floatval($item->cgst_percent ?? 0);
                $sgstPercent = floatval($item->sgst_percent ?? 0);
                $cessPercent = floatval($item->cess_percent ?? 0);
                
                $cgstAmount = $amountAfterDiscount * ($cgstPercent / 100);
                $sgstAmount = $amountAfterDiscount * ($sgstPercent / 100);
                $cessAmount = $amountAfterDiscount * ($cessPercent / 100);
                $taxAmount = $cgstAmount + $sgstAmount + $cessAmount;
                
                $netAmount = $amountAfterDiscount + $taxAmount;
                
                SaleTransactionItem::create([
                    'sale_transaction_id' => $transaction->id,
                    'item_id' => $item->id,
                    'item_code' => $itemData['item_code'],
                    'item_name' => $itemData['item_name'],
                    'batch_no' => $itemData['batch'] ?? null,
                    'expiry_date' => $itemData['expiry'] ?? null,
                    'qty' => $qty,
                    'free_qty' => floatval($itemData['free_qty'] ?? 0),
                    'sale_rate' => $rate,
                    'mrp' => floatval($itemData['mrp'] ?? 0),
                    'discount_percent' => $discountPercent,
                    'discount_amount' => $discountAmount,
                    'amount' => $amount,
                    'net_amount' => $netAmount,
                    
                    'cgst_percent' => $cgstPercent,
                    'sgst_percent' => $sgstPercent,
                    'cess_percent' => $cessPercent,
                    'cgst_amount' => $cgstAmount,
                    'sgst_amount' => $sgstAmount,
                    'cess_amount' => $cessAmount,
                    'tax_amount' => $taxAmount,
                    
                    'unit' => $item->unit ?? null,
                    'packing' => $item->packing ?? null,
                    'company_name' => $item->company_short_name ?? null,
                    'hsn_code' => $item->hsn_code ?? null,
                    
                    'row_order' => $itemData['row_order'] ?? $index,
                ]);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Sale transaction updated successfully',
                'invoice_no' => $transaction->invoice_no,
                'id' => $transaction->id
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Sale Transaction Update Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $transaction = SaleTransaction::findOrFail($id);
            $transaction->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Sale transaction deleted successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate next invoice number
     */
    private function generateInvoiceNo()
    {
        $lastTransaction = SaleTransaction::orderBy('id', 'desc')->first();
        $nextNumber = $lastTransaction ? (intval(preg_replace('/[^0-9]/', '', $lastTransaction->invoice_no)) + 1) : 1;
        return 'INV-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Calculate summary amounts from items data
     */
    private function calculateSummaryAmounts($itemsData)
    {
        $ntAmount = 0;      // Total before discount
        $disAmount = 0;     // Total discount
        $ftAmount = 0;      // Total after discount (before tax)
        $taxAmount = 0;     // Total tax
        $netAmount = 0;     // Final amount
        
        foreach ($itemsData as $itemData) {
            $qty = floatval($itemData['qty'] ?? 0);
            $rate = floatval($itemData['rate'] ?? 0);
            $discountPercent = floatval($itemData['discount'] ?? 0);
            
            // Get item for GST info
            $item = Item::where('bar_code', $itemData['item_code'])
                ->orWhere('id', $itemData['item_code'])
                ->first();
            
            $amount = $qty * $rate;
            $discountAmt = $amount * ($discountPercent / 100);
            $amountAfterDiscount = $amount - $discountAmt;
            
            if ($item) {
                $cgst = floatval($item->cgst_percent ?? 0);
                $sgst = floatval($item->sgst_percent ?? 0);
                $cess = floatval($item->cess_percent ?? 0);
                
                $tax = $amountAfterDiscount * (($cgst + $sgst + $cess) / 100);
            } else {
                $tax = 0;
            }
            
            $ntAmount += $amount;
            $disAmount += $discountAmt;
            $ftAmount += $amountAfterDiscount;
            $taxAmount += $tax;
        }
        
        $netAmount = $ftAmount + $taxAmount;
        
        return [
            'nt_amount' => round($ntAmount, 2),
            'dis_amount' => round($disAmount, 2),
            'ft_amount' => round($ftAmount, 2),
            'tax_amount' => round($taxAmount, 2),
            'net_amount' => round($netAmount, 2),
        ];
    }
}
