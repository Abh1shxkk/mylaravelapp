<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Item;
use App\Models\StockLedger;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BatchController extends Controller
{
    public function index()
    {
        $search = request('search');
        $searchField = request('search_field', 'all');
        $itemId = request('item_id');
        $status = request('status');

        $batches = Batch::query()
            ->with('item')
            ->when($itemId, function ($query) use ($itemId) {
                return $query->where('item_id', $itemId);
            })
            ->when($search && trim($search) !== '', function ($query) use ($search, $searchField) {
                $search = trim($search);
                
                if ($searchField === 'all') {
                    $query->where(function ($q) use ($search) {
                        $q->where('batch_number', 'like', "%{$search}%")
                            ->orWhere('remarks', 'like', "%{$search}%")
                            ->orWhereHas('item', function ($q) use ($search) {
                                $q->where('name', 'like', "%{$search}%");
                            });
                    });
                } else {
                    $validFields = ['batch_number', 'status'];
                    if (in_array($searchField, $validFields)) {
                        $query->where($searchField, 'like', "%{$search}%");
                    }
                }
            })
            ->when($status !== null && $status !== '', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->where('is_deleted', 0)
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        $items = Item::where('is_deleted', 0)->get();

        return view('admin.batches.index', compact('batches', 'items', 'search', 'searchField', 'status', 'itemId'));
    }

    public function create()
    {
        $items = Item::where('is_deleted', 0)->get();
        return view('admin.batches.create', compact('items'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'item_id' => 'required|exists:items,id',
                'batch_number' => 'required|unique:batches,batch_number',
                'manufacturing_date' => 'nullable|date',
                'expiry_date' => 'nullable|date',
                'quantity' => 'required|numeric|min:0',
                'cost_price' => 'required|numeric|min:0',
                'selling_price' => 'required|numeric|min:0',
                'godown' => 'nullable|string|max:100',
            ]);

            $batch = Batch::create($validated);

            // Create stock ledger entry for batch creation
            StockLedger::create([
                'item_id' => $batch->item_id,
                'batch_id' => $batch->id,
                'transaction_type' => 'IN',
                'quantity' => $batch->quantity,
                'opening_qty' => 0,
                'closing_qty' => $batch->quantity,
                'reference_type' => 'BATCH_CREATION',
                'reference_id' => $batch->id,
                'transaction_date' => now()->toDateString(),
                'godown' => $batch->godown,
                'remarks' => 'Batch created',
                'created_by' => auth()->id()
            ]);

            return redirect()->route('admin.batches.index')->with('success', 'Batch created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Batch $batch)
    {
        $batch->load('item', 'stockLedgers');
        return view('admin.batches.show', compact('batch'));
    }

    public function edit(Batch $batch)
    {
        $items = Item::where('is_deleted', 0)->get();
        return view('admin.batches.edit', compact('batch', 'items'));
    }

    public function update(Request $request, Batch $batch)
    {
        try {
            $validated = $request->validate([
                'item_id' => 'required|exists:items,id',
                'batch_number' => 'required|unique:batches,batch_number,' . $batch->id,
                'manufacturing_date' => 'nullable|date',
                'expiry_date' => 'nullable|date',
                'quantity' => 'required|numeric|min:0',
                'cost_price' => 'required|numeric|min:0',
                'selling_price' => 'required|numeric|min:0',
                'godown' => 'nullable|string|max:100',
                'status' => 'required|in:active,expired,discontinued',
            ]);

            $batch->update($validated);

            return redirect()->route('admin.batches.index')->with('success', 'Batch updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Batch $batch)
    {
        $batch->update(['is_deleted' => 1]);
        return back()->with('success', 'Batch deleted successfully!');
    }

    /**
     * Get expiry report
     */
    public function expiryReport()
    {
        $expiredBatches = Batch::expired()->where('is_deleted', 0)->with('item')->get();
        $expiringSoon = Batch::expiringsoon()->where('is_deleted', 0)->with('item')->get();

        return view('admin.batches.expiry-report', compact('expiredBatches', 'expiringSoon'));
    }

    /**
     * Get stock ledger for a batch
     */
    public function stockLedger(Batch $batch)
    {
        $ledger = $batch->stockLedgers()->orderByDesc('transaction_date')->paginate(20);
        return view('admin.batches.stock-ledger', compact('batch', 'ledger'));
    }

    /**
     * Get all batches for an item (AJAX)
     */
    public function getItemBatches($itemId)
    {
        $batches = Batch::where('item_id', $itemId)
            ->where('is_deleted', 0)
            ->where('status', 'active')
            ->orderBy('expiry_date')
            ->get(['id', 'batch_number', 'expiry_date', 'quantity', 'selling_price']);

        return response()->json($batches);
    }

    /**
     * View batches for a specific item (EasySol style)
     */
    public function itemBatches($itemId)
    {
        $item = Item::findOrFail($itemId);
        $batches = $item->batches()->where('is_deleted', 0)->orderBy('expiry_date')->get();

        return view('admin.batches.item-batches', compact('item', 'batches'));
    }

    /**
     * View all batches across all items (EasySol style)
     */
    public function allBatches()
    {
        $search = request('search');
        $status = request('status');

        $batches = Batch::query()
            ->with('item')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('batch_number', 'like', "%{$search}%")
                        ->orWhereHas('item', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($status === 'expired', function ($query) {
                $query->where('expiry_date', '<', now()->toDateString());
            })
            ->when($status === 'expiring_soon', function ($query) {
                $query->where('expiry_date', '<=', now()->addDays(30)->toDateString())
                      ->where('expiry_date', '>', now()->toDateString());
            })
            ->when($status === 'active', function ($query) {
                $query->where('status', 'active')
                      ->where('expiry_date', '>', now()->toDateString());
            })
            ->where('is_deleted', 0)
            ->orderByDesc('expiry_date')
            ->paginate(20)
            ->withQueryString();

        // Statistics
        $totalBatches = Batch::where('is_deleted', 0)->count();
        $activeBatches = Batch::where('is_deleted', 0)
            ->where('status', 'active')
            ->where('expiry_date', '>', now()->toDateString())
            ->count();
        $expiringSoon = Batch::where('is_deleted', 0)
            ->where('expiry_date', '<=', now()->addDays(30)->toDateString())
            ->where('expiry_date', '>', now()->toDateString())
            ->count();
        $expiredBatches = Batch::where('is_deleted', 0)
            ->where('expiry_date', '<', now()->toDateString())
            ->count();

        return view('admin.batches.all-batches', compact(
            'batches', 'search', 'status', 'totalBatches', 
            'activeBatches', 'expiringSoon', 'expiredBatches'
        ));
    }
}
