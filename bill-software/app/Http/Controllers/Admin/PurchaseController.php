<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\SalesMan;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
     * Store a new purchase transaction
     */
    public function store(Request $request)
    {
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
                        'item_id' => null, // Can be linked later if needed
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
}
