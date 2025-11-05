<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\PurchaseTransaction;
use App\Models\PurchaseTransactionItem;
use App\Models\Supplier;
use App\Models\SalesMan;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{
    /**
     * Display purchase transaction form
     */
    public function transaction()
    {
        $suppliers = Supplier::all();
        $salesmen = SalesMan::all();
        $items = Item::all();
        
        // Get next transaction number
        $lastPurchase = Purchase::orderBy('id', 'desc')->first();
        $nextTrnNo = $lastPurchase ? (intval($lastPurchase->trn_no) + 1) : 1;
        
        return view('admin.purchase.transaction', compact('suppliers', 'salesmen', 'items', 'nextTrnNo'));
    }

    /**
     * Store a new purchase transaction (NEW: Using purchase_transactions table)
     */
    public function store(Request $request)
    {
        // Check if request is JSON (from new savePurchase function)
        if ($request->isJson()) {
            return $this->storeNewFormat($request);
        }
        
        // Old format support (backward compatibility)
        $request->validate([
            'bill_date' => 'required|date',
            'bill_no' => 'nullable|string',
            'supplier_id' => 'nullable|exists:suppliers,supplier_id',
        ]);

        DB::beginTransaction();
        try {
            // Get next transaction number
            $lastPurchase = Purchase::orderBy('id', 'desc')->first();
            $trnNo = $lastPurchase ? (intval($lastPurchase->trn_no) + 1) : 1;
            
            // Get day name
            $dayName = date('l', strtotime($request->bill_date));
            
            // Parse items from JSON
            $items = json_decode($request->items_json, true) ?? [];
            
            // Calculate totals
            $totalAmount = 0;
            $totalDiscount = 0;
            
            foreach ($items as $item) {
                $amount = floatval($item['amount'] ?? 0);
                $totalAmount += $amount;
            }
            
            // Create purchase
            $purchase = Purchase::create([
                'bill_date' => $request->bill_date,
                'day_name' => $dayName,
                'supplier' => $request->supplier_id,
                'bill_no' => $request->bill_no,
                'trn_no' => $trnNo,
                'receive_date' => $request->receive_date,
                'cash' => $request->cash ?? 'N',
                'transfer' => $request->transfer ?? 'N',
                'remarks' => $request->remarks,
                'due_date' => $request->due_date,
                'items' => json_encode($items),
                'total_amount' => $totalAmount,
                'net_amount' => $totalAmount,
                'tax_amount' => 0,
                'discount_amount' => $totalDiscount,
            ]);
            
            // Save items to purchase_items table
            foreach ($items as $item) {
                if (!empty($item['code']) || !empty($item['name'])) {
                    PurchaseItem::create([
                        'purchase_id' => $purchase->id,
                        'item_id' => null,
                        'code' => $item['code'] ?? '',
                        'item_name' => $item['name'] ?? '',
                        'batch' => $item['batch'] ?? '',
                        'exp' => $item['exp'] ?? '',
                        'qty' => $item['qty'] ?? 0,
                        'f_qty' => $item['free_qty'] ?? 0,
                        'purchase_rate' => $item['pur_rate'] ?? 0,
                        'dis_percent' => $item['dis_percent'] ?? 0,
                        'mrp' => $item['mrp'] ?? 0,
                        'amount' => $item['amount'] ?? 0,
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'success' => true, 
                'message' => 'Purchase saved successfully!',
                'trn_no' => $trnNo
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    /**
     * Store purchase transaction in NEW format (purchase_transactions table)
     */
    private function storeNewFormat(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'header.bill_date' => 'required|date',
            'header.supplier_id' => 'required|exists:suppliers,supplier_id',
            'header.bill_no' => 'required|string|max:100',
            'items' => 'nullable|array',
            'items.*.item_code' => 'nullable|string',
            'items.*.item_name' => 'nullable|string',
            'items.*.qty' => 'nullable|numeric|min:0',
            'items.*.pur_rate' => 'nullable|numeric|min:0',
        ]);
        
        // Check if Bill No. already exists
        $headerData = $request->input('header');
        $existingTransaction = PurchaseTransaction::where('bill_no', $headerData['bill_no'])
            ->where('supplier_id', $headerData['supplier_id'])
            ->first();
        
        if ($existingTransaction) {
            return response()->json([
                'success' => false,
                'message' => 'Bill No. already exists!',
                'error' => 'DUPLICATE_BILL_NO',
                'existing_transaction' => [
                    'id' => $existingTransaction->id,
                    'trn_no' => $existingTransaction->trn_no,
                    'bill_no' => $existingTransaction->bill_no,
                    'bill_date' => $existingTransaction->bill_date,
                    'supplier_id' => $existingTransaction->supplier_id,
                ],
                'suggestion' => 'This Bill No. is already saved. Do you want to modify the existing transaction?'
            ], 422);
        }
        
        DB::beginTransaction();
        
        try {
            $headerData = $request->input('header');
            $itemsData = $request->input('items');
            
            // Always auto-generate Transaction Number (ignore user input)
            $lastTransaction = PurchaseTransaction::orderBy('id', 'desc')->first();
            $nextNumber = $lastTransaction ? (intval($lastTransaction->trn_no) + 1) : 1;
            $headerData['trn_no'] = str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
            
            // Create Master Record
            $transaction = PurchaseTransaction::create([
                'trn_no' => $headerData['trn_no'],
                'bill_date' => $headerData['bill_date'],
                'bill_no' => $headerData['bill_no'] ?? null,
                'supplier_id' => $headerData['supplier_id'],
                'receive_date' => $headerData['receive_date'] ?? null,
                'due_date' => $headerData['due_date'] ?? null,
                'cash_flag' => $headerData['cash_flag'] ?? 'N',
                'transfer_flag' => $headerData['transfer_flag'] ?? 'N',
                'remarks' => $headerData['remarks'] ?? null,
                
                // Summary amounts
                'nt_amount' => $headerData['nt_amount'] ?? 0,
                'sc_amount' => $headerData['sc_amount'] ?? 0,
                'scm_amount' => $headerData['scm_amount'] ?? 0,
                'dis_amount' => $headerData['dis_amount'] ?? 0,
                'less_amount' => $headerData['less_amount'] ?? 0,
                'tax_amount' => $headerData['tax_amount'] ?? 0,
                'net_amount' => $headerData['net_amount'] ?? 0,
                'scm_percent' => $headerData['scm_percent'] ?? 0,
                'tcs_amount' => $headerData['tcs_amount'] ?? 0,
                'dis1_amount' => $headerData['dis1_amount'] ?? 0,
                'tof_amount' => $headerData['tof_amt'] ?? 0,
                'inv_amount' => $headerData['inv_amount'] ?? 0,
                
                'status' => 'completed',
                'created_by' => Auth::id(),
            ]);
            
            // Create Detail Records (Items)
            foreach ($itemsData as $index => $itemData) {
                // Skip empty rows - must have item info AND (qty or rate)
                $hasItemInfo = !empty($itemData['item_code']) || !empty($itemData['item_name']);
                $hasQuantityOrRate = (isset($itemData['qty']) && $itemData['qty'] > 0) || 
                                    (isset($itemData['pur_rate']) && $itemData['pur_rate'] > 0);
                
                if (!$hasItemInfo || !$hasQuantityOrRate) {
                    Log::info("Skipping empty row at index {$index}");
                    continue;
                }
                
                // Get item_id from item_code (bar_code field in items table)
                $item = null;
                
                // Try to find by bar_code (item code) first
                if (!empty($itemData['item_code'])) {
                    $item = Item::where('bar_code', $itemData['item_code'])->first();
                }
                
                // If not found by code, try by exact name
                if (!$item && !empty($itemData['item_name'])) {
                    $item = Item::where('name', $itemData['item_name'])->first();
                    
                    // If not found, try partial match
                    if (!$item) {
                        $item = Item::where('name', 'LIKE', '%' . $itemData['item_name'] . '%')->first();
                    }
                }
                
                if (!$item) {
                    Log::warning("Item not found - Code: " . $itemData['item_code'] . ", Name: " . $itemData['item_name']);
                    // Will save with null item_id (code and name saved for reference)
                }
                
                PurchaseTransactionItem::create([
                    'purchase_transaction_id' => $transaction->id,
                    'item_id' => $item ? $item->id : null,
                    'item_code' => $itemData['item_code'],
                    'item_name' => $itemData['item_name'],
                    'batch_no' => $itemData['batch_no'] ?? null,
                    'expiry_date' => $itemData['expiry_date'] ?? null,
                    'qty' => $itemData['qty'],
                    'free_qty' => $itemData['free_qty'] ?? 0,
                    'pur_rate' => $itemData['pur_rate'],
                    'mrp' => $itemData['mrp'] ?? 0,
                    's_rate' => $itemData['s_rate'] ?? 0,
                    'dis_percent' => $itemData['dis_percent'] ?? 0,
                    'amount' => $itemData['amount'],
                    
                    // GST data
                    'cgst_percent' => $itemData['cgst_percent'] ?? 0,
                    'sgst_percent' => $itemData['sgst_percent'] ?? 0,
                    'cess_percent' => $itemData['cess_percent'] ?? 0,
                    'cgst_amount' => $itemData['cgst_amount'] ?? 0,
                    'sgst_amount' => $itemData['sgst_amount'] ?? 0,
                    'cess_amount' => $itemData['cess_amount'] ?? 0,
                    'tax_amount' => $itemData['tax_amount'] ?? 0,
                    'net_amount' => $itemData['net_amount'] ?? 0,
                    'cost' => $itemData['cost'] ?? 0,
                    'cost_gst' => $itemData['cost_gst'] ?? 0,
                    
                    // Additional fields
                    'unit' => $item ? ($item->unit ?? null) : null,
                    'packing' => $item ? ($item->packing ?? null) : null,
                    'company_name' => $item ? ($item->company->name ?? null) : null,
                    
                    'row_order' => $itemData['row_order'] ?? 0,
                ]);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Purchase transaction saved successfully in NEW format!',
                'trn_no' => $transaction->trn_no,
                'bill_no' => $transaction->bill_no,
                'id' => $transaction->id
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Purchase Transaction Save Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            Log::error('Request data: ' . json_encode($request->all()));
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => basename($e->getFile()),
                'trace' => explode("\n", $e->getTraceAsString())[0] ?? ''
            ], 500);
        }
    }

    /**
     * Display purchase modification form
     */
    public function modification()
    {
        $suppliers = Supplier::all();
        $salesmen = SalesMan::all();
        $items = Item::all();
        
        return view('admin.purchase.modification', compact('suppliers', 'salesmen', 'items'));
    }

    /**
     * Get purchase details for modification
     */
    public function show($id)
    {
        $purchase = Purchase::with('items')->findOrFail($id);
        return response()->json(['success' => true, 'data' => $purchase]);
    }

    /**
     * Update purchase
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'invoice_no' => 'required|unique:purchases,invoice_no,' . $id,
        ]);

        DB::beginTransaction();
        try {
            $purchase = Purchase::findOrFail($id);
            $purchase->update($request->all());

            // Delete old items and create new ones
            $purchase->items()->delete();
            
            if ($request->has('items')) {
                foreach ($request->items as $item) {
                    PurchaseItem::create([
                        'purchase_id' => $purchase->id,
                        'item_id' => $item['item_id'] ?? null,
                        'code' => $item['code'] ?? null,
                        'item_name' => $item['item_name'],
                        'batch' => $item['batch'] ?? null,
                        'exp' => $item['exp'] ?? null,
                        'qty' => $item['qty'] ?? 0,
                        'f_qty' => $item['f_qty'] ?? 0,
                        'purchase_rate' => $item['purchase_rate'] ?? 0,
                        'dis_percent' => $item['dis_percent'] ?? 0,
                        'mrp' => $item['mrp'] ?? 0,
                        'amount' => $item['amount'] ?? 0,
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Purchase updated successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Delete purchase
     */
    public function destroy($id)
    {
        try {
            $purchase = Purchase::findOrFail($id);
            $purchase->delete();
            
            return response()->json(['success' => true, 'message' => 'Purchase deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    /**
     * Get invoice list for modification
     */
    public function getInvoiceList()
    {
        try {
            $invoices = PurchaseTransaction::with('supplier')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function($transaction) {
                    return [
                        'trn_no' => $transaction->trn_no,
                        'bill_no' => $transaction->bill_no,
                        'bill_date' => $transaction->bill_date,
                        'receive_date' => $transaction->receive_date,
                        'supplier_name' => $transaction->supplier->name ?? 'N/A',
                        'net_amount' => $transaction->net_amount,
                        'created_by' => 'MASTER',
                        'modified_by' => 'MASTER',
                    ];
                });
            
            return response()->json([
                'success' => true,
                'invoices' => $invoices
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching invoice list: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching invoice list'
            ], 500);
        }
    }
    
    /**
     * Fetch bill by transaction number for modification
     */
    public function fetchBill($trnNo)
    {
        try {
            $transaction = PurchaseTransaction::with(['supplier', 'items'])
                ->where('trn_no', $trnNo)
                ->first();
            
            if (!$transaction) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bill not found with Transaction No: ' . $trnNo
                ]);
            }
            
            // Format bill data
            $billData = [
                'transaction_id' => $transaction->id, // Add transaction ID for update
                'trn_no' => $transaction->trn_no,
                'bill_no' => $transaction->bill_no,
                'bill_date' => $transaction->bill_date ? $transaction->bill_date->format('Y-m-d') : null,
                'receive_date' => $transaction->receive_date ? $transaction->receive_date->format('Y-m-d') : null,
                'due_date' => $transaction->due_date ? $transaction->due_date->format('Y-m-d') : null,
                'supplier_id' => (string)($transaction->supplier_id ?? ''),
                'supplier_name' => $transaction->supplier->name ?? '',
                'cash' => strtoupper($transaction->cash_flag ?? 'N'),
                'transfer' => strtoupper($transaction->transfer_flag ?? 'N'),
                'remarks' => $transaction->remarks ?? '',
                
                // Summary amounts
                'nt_amt' => $transaction->nt_amount,
                'sc_amt' => $transaction->sc_amount,
                'scm_amt' => $transaction->scm_amount,
                'dis_amt' => $transaction->dis_amount,
                'less_amt' => $transaction->less_amount,
                'tax_amt' => $transaction->tax_amount,
                'net_amt' => $transaction->net_amount,
                'scm_percent' => $transaction->scm_percent,
                'tcs_amt' => $transaction->tcs_amount,
                'dis1_amt' => $transaction->dis1_amount,
                'tof_amt' => $transaction->tof_amount,
                'inv_amt' => $transaction->inv_amount,
                
                // Detailed info
                'unit' => '1',
                'location' => '',
                'cost' => 0,
                'cost_gst' => 0,
                'cl_qty' => '',
                'company' => '',
                'volume' => 0,
                'packing' => '',
                'hs_amt' => 0,
                'gross_amt' => $transaction->nt_amount,
                'dis1_percent' => 0,
                
                // Items
                'items' => $transaction->items->map(function($item) {
                    return [
                        'item_code' => $item->item_code,
                        'item_name' => $item->item_name,
                        'batch_number' => $item->batch_no,
                        'expiry_date' => $item->expiry_date,
                        'quantity' => $item->qty,
                        'free_quantity' => $item->free_qty,
                        'p_rate' => $item->pur_rate,
                        'discount_percent' => $item->dis_percent,
                        'mrp' => $item->mrp,
                        'amount' => $item->amount,
                    ];
                })->toArray()
            ];
            
            return response()->json([
                'success' => true,
                'bill' => $billData
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error fetching bill: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching bill: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get supplier name by supplier_id (for AJAX requests)
     */
    public function getSupplierName($supplierId)
    {
        try {
            $supplier = Supplier::where('supplier_id', $supplierId)->first();
            
            if ($supplier) {
                return response()->json([
                    'success' => true,
                    'name' => $supplier->name,
                    'supplier_id' => $supplier->supplier_id
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Supplier not found'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error fetching supplier name: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching supplier name'
            ], 500);
        }
    }
}
