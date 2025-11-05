<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PurchaseTransactionItem;
use App\Models\Item;
use App\Models\PurchaseTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BatchController extends Controller
{
    /**
     * Display a listing of batches grouped by item
     */
    public function index(Request $request)
    {
        $itemId = $request->get('item_id');
        
        // Get batches from purchase_transaction_items grouped by item, batch_no, and expiry_date
        $query = PurchaseTransactionItem::select(
            'item_id',
            'item_code',
            'item_name',
            'batch_no',
            'expiry_date',
            DB::raw('SUM(qty) as total_qty'),
            DB::raw('AVG(pur_rate) as avg_pur_rate'),
            DB::raw('AVG(mrp) as avg_mrp'),
            DB::raw('MAX(pur_rate) as max_rate'),
            DB::raw('MIN(pur_rate) as min_rate')
        )
        ->whereNotNull('batch_no')
        ->where('batch_no', '!=', '')
        ->groupBy('item_id', 'item_code', 'item_name', 'batch_no', 'expiry_date')
        ->orderBy('item_name')
        ->orderBy('batch_no');
        
        // Filter by item if provided
        if ($itemId) {
            $query->where('item_id', $itemId);
        }
        
        $batches = $query->get();
        
        // Group batches by item
        $groupedBatches = $batches->groupBy('item_id');
        
        // Get all items for dropdown (only items that have batches)
        $itemsWithBatches = Item::whereIn('id', $batches->pluck('item_id')->unique())
            ->where('is_deleted', '!=', 1)
            ->orderBy('name')
            ->get();
        
        // Get all items for dropdown
        $items = Item::where('is_deleted', '!=', 1)
            ->orderBy('name')
            ->get();
        
        return view('admin.batches.index', compact('groupedBatches', 'items', 'itemId'));
    }
    
    /**
     * Get batches for a specific item (AJAX)
     */
    public function getItemBatches($itemId)
    {
        try {
            $batches = PurchaseTransactionItem::select(
                'id',
                'item_id',
                'item_code',
                'item_name',
                'batch_no',
                'expiry_date',
                'qty',
                'pur_rate',
                'mrp',
                'purchase_transaction_id',
                'packing',
                'unit'
            )
            ->where('item_id', $itemId)
            ->whereNotNull('batch_no')
            ->where('batch_no', '!=', '')
            ->with(['transaction', 'item'])
            ->orderBy('batch_no')
            ->orderBy('expiry_date')
            ->get();
            
            // Group by batch_no and calculate totals
            $grouped = [];
            foreach ($batches as $batch) {
                $key = $batch->batch_no . '_' . ($batch->expiry_date ? $batch->expiry_date->format('Y-m') : '');
                
                if (!isset($grouped[$key])) {
                    $grouped[$key] = [
                        'batch_no' => $batch->batch_no,
                        'expiry_date' => $batch->expiry_date,
                        'expiry_display' => $batch->expiry_date ? $batch->expiry_date->format('m/Y') : '---',
                        'total_qty' => 0,
                        'avg_pur_rate' => 0,
                        'avg_mrp' => 0,
                        'max_rate' => 0,
                        'items' => [],
                        'item_name' => $batch->item_name,
                        'item_code' => $batch->item_code,
                        'packing' => $batch->packing ?? '1*10',
                        'unit' => $batch->unit ?? '1'
                    ];
                }
                
                $grouped[$key]['total_qty'] += $batch->qty;
                $grouped[$key]['items'][] = $batch;
                
                // Calculate averages
                $rates = array_column($grouped[$key]['items'], 'pur_rate');
                $mrps = array_column($grouped[$key]['items'], 'mrp');
                $grouped[$key]['avg_pur_rate'] = count($rates) > 0 ? array_sum($rates) / count($rates) : 0;
                $grouped[$key]['avg_mrp'] = count($mrps) > 0 ? array_sum($mrps) / count($mrps) : 0;
                $grouped[$key]['max_rate'] = max($rates);
            }
            
            return response()->json([
                'success' => true,
                'batches' => array_values($grouped)
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error fetching item batches: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching batches'
            ], 500);
        }
    }
    
    /**
     * Show the form for editing a specific batch
     */
    public function edit($id)
    {
        // Get the purchase transaction item
        $purchaseItem = PurchaseTransactionItem::with(['transaction', 'item', 'transaction.supplier'])
            ->findOrFail($id);
        
        // Get all batches with same batch_no and item_id for quantity calculation
        $allBatchItems = PurchaseTransactionItem::where('item_id', $purchaseItem->item_id)
            ->where('batch_no', $purchaseItem->batch_no)
            ->where('expiry_date', $purchaseItem->expiry_date)
            ->get();
        
        // Calculate totals
        $totalQty = $allBatchItems->sum('qty');
        $fifoQty = $totalQty;
        $mstQty = $totalQty;
        $actualQty = $totalQty;
        
        return view('admin.batches.edit', compact('purchaseItem', 'allBatchItems', 'totalQty', 'fifoQty', 'mstQty', 'actualQty'));
    }
    
    /**
     * Update the specified batch
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'batch_no' => 'required|string|max:100',
            'expiry_date' => 'nullable|date',
            'qty' => 'required|numeric|min:0',
            'pur_rate' => 'required|numeric|min:0',
            'mrp' => 'nullable|numeric|min:0',
            's_rate' => 'nullable|numeric|min:0',
            'dis_percent' => 'nullable|numeric|min:0|max:100',
        ]);
        
        DB::beginTransaction();
        
        try {
            $purchaseItem = PurchaseTransactionItem::findOrFail($id);
            
            // Parse expiry_date if provided (might be in YYYY-MM-01 format from MM/YYYY)
            $expiryDate = null;
            if ($request->expiry_date) {
                try {
                    $expiryDate = \Carbon\Carbon::parse($request->expiry_date);
                } catch (\Exception $e) {
                    // If parsing fails, try to parse as MM/YYYY
                    Log::warning('Error parsing expiry_date: ' . $e->getMessage());
                }
            }
            
            // Update the purchase transaction item
            $purchaseItem->update([
                'batch_no' => $request->batch_no,
                'expiry_date' => $expiryDate,
                'qty' => $request->qty,
                'pur_rate' => $request->pur_rate,
                'mrp' => $request->mrp ?? $purchaseItem->mrp,
                's_rate' => $request->s_rate ?? $purchaseItem->s_rate ?? 0,
                'dis_percent' => $request->dis_percent ?? $purchaseItem->dis_percent,
            ]);
            
            // Recalculate amount
            $baseAmount = $request->qty * $request->pur_rate;
            $discountAmount = $baseAmount * (($request->dis_percent ?? 0) / 100);
            $amount = $baseAmount - $discountAmount;
            $purchaseItem->amount = $amount;
            $purchaseItem->save();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Batch updated successfully!'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating batch: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error updating batch: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get batch details for a specific batch (by batch_no and item_id)
     */
    public function getBatchDetails($itemId, $batchNo)
    {
        try {
            $batches = PurchaseTransactionItem::where('item_id', $itemId)
                ->where('batch_no', $batchNo)
                ->with(['transaction', 'transaction.supplier', 'item'])
                ->orderBy('expiry_date')
                ->get();
            
            if ($batches->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Batch not found'
                ], 404);
            }
            
            // Calculate totals
            $totalQty = $batches->sum('qty');
            $firstBatch = $batches->first();
            
            return response()->json([
                'success' => true,
                'batch' => [
                    'batch_no' => $batchNo,
                    'expiry_date' => $firstBatch->expiry_date,
                    'total_qty' => $totalQty,
                    'avg_pur_rate' => $batches->avg('pur_rate'),
                    'avg_mrp' => $batches->avg('mrp'),
                    'item_name' => $firstBatch->item_name,
                    'item_code' => $firstBatch->item_code,
                    'packing' => $firstBatch->packing ?? '1*10',
                    'items' => $batches->map(function($item) {
                        return [
                            'id' => $item->id,
                            'qty' => $item->qty,
                            'pur_rate' => $item->pur_rate,
                            'mrp' => $item->mrp,
                            'expiry_date' => $item->expiry_date,
                            'invoice_no' => $item->transaction->bill_no ?? '',
                            'invoice_date' => $item->transaction->bill_date ?? '',
                            'supplier_name' => $item->transaction->supplier->name ?? '',
                        ];
                    })
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error fetching batch details: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching batch details'
            ], 500);
        }
    }
    
    /**
     * Display batches for a specific item (view page)
     */
    public function itemBatches($itemId)
    {
        try {
            $item = Item::findOrFail($itemId);
            
            // Get batches for this item
            $batches = PurchaseTransactionItem::select(
                'item_id',
                'item_code',
                'item_name',
                'batch_no',
                'expiry_date',
                DB::raw('SUM(qty) as total_qty'),
                DB::raw('AVG(pur_rate) as avg_pur_rate'),
                DB::raw('AVG(mrp) as avg_mrp'),
                DB::raw('MAX(pur_rate) as max_rate'),
                DB::raw('MIN(pur_rate) as min_rate')
            )
            ->where('item_id', $itemId)
            ->whereNotNull('batch_no')
            ->where('batch_no', '!=', '')
            ->groupBy('item_id', 'item_code', 'item_name', 'batch_no', 'expiry_date')
            ->orderBy('batch_no')
            ->orderBy('expiry_date')
            ->get();
            
            // Note: If batches is empty, view will show "No batches found" message
            
            // Get all items for dropdown
            $items = Item::where('is_deleted', '!=', 1)
                ->orderBy('name')
                ->get();
            
            return view('admin.batches.index', [
                'groupedBatches' => collect([$itemId => $batches]),
                'items' => $items,
                'itemId' => $itemId,
                'selectedItem' => $item
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error fetching item batches: ' . $e->getMessage());
            return redirect()->route('admin.batches.index')
                ->with('error', 'Item not found or error loading batches.');
        }
    }
    
    /**
     * Display all batches (view page)
     */
    public function allBatches()
    {
        return $this->index(new Request());
    }
    
    /**
     * Display stock ledger for a specific batch
     */
    public function stockLedger($batchId)
    {
        try {
            // Get batch from purchase_transaction_items
            $batchItem = PurchaseTransactionItem::with(['transaction', 'item'])
                ->findOrFail($batchId);
            
            // Get all items with same batch_no and item_id
            $batchItems = PurchaseTransactionItem::where('item_id', $batchItem->item_id)
                ->where('batch_no', $batchItem->batch_no)
                ->with(['transaction', 'transaction.supplier'])
                ->orderBy('created_at')
                ->get();
            
            return view('admin.batches.stock-ledger', [
                'batchItem' => $batchItem,
                'batchItems' => $batchItems
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error fetching batch stock ledger: ' . $e->getMessage());
            return redirect()->route('admin.batches.index')
                ->with('error', 'Batch not found or error loading stock ledger.');
        }
    }
    
    /**
     * Display expiry report
     */
    public function expiryReport(Request $request)
    {
        try {
            $days = $request->get('days', 30); // Default 30 days
            
            // Get batches expiring within specified days
            $batches = PurchaseTransactionItem::select(
                'item_id',
                'item_code',
                'item_name',
                'batch_no',
                'expiry_date',
                DB::raw('SUM(qty) as total_qty'),
                DB::raw('AVG(pur_rate) as avg_pur_rate'),
                DB::raw('AVG(mrp) as avg_mrp')
            )
            ->whereNotNull('batch_no')
            ->where('batch_no', '!=', '')
            ->whereNotNull('expiry_date')
            ->whereBetween('expiry_date', [
                now()->toDateString(),
                now()->addDays($days)->toDateString()
            ])
            ->groupBy('item_id', 'item_code', 'item_name', 'batch_no', 'expiry_date')
            ->orderBy('expiry_date')
            ->orderBy('item_name')
            ->get();
            
            return view('admin.batches.expiry-report', [
                'batches' => $batches,
                'days' => $days
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error fetching expiry report: ' . $e->getMessage());
            return redirect()->route('admin.batches.index')
                ->with('error', 'Error loading expiry report.');
        }
    }
}

