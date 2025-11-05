<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Company;
use App\Models\StockLedger;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\PendingOrder;
use App\Models\GodownExpiry;
use App\Models\ExpiryLedger;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $search = request('search');
        $searchField = request('search_field', 'all');
        $status = request('status');
        $dateFrom = request('date_from');
        $dateTo = request('date_to');

        $items = Item::query()
            ->with('company') // Eager load company relationship
            ->when($search && trim($search) !== '', function ($query) use ($search, $searchField) {
                $search = trim($search);
                
                if ($searchField === 'all') {
                    // Search across all fields
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('code', 'like', "%{$search}%")
                            ->orWhere('bar_code', 'like', "%{$search}%")
                            ->orWhere('location', 'like', "%{$search}%")
                            ->orWhere('packing', 'like', "%{$search}%")
                            ->orWhere('mrp', 'like', "%{$search}%")
                            ->orWhere('hsn_code', 'like', "%{$search}%")
                            ->orWhere('mfg_by', 'like', "%{$search}%");
                    });
                } else {
                    // Search in specific field - ensure field name is valid
                    $validFields = ['name', 'bar_code', 'location', 'packing', 'mrp', 'code', 'hsn_code'];
                    if (in_array($searchField, $validFields)) {
                        $query->where($searchField, 'like', "%{$search}%");
                    }
                }
            })
            ->when($status !== null && $status !== '', function ($query) use ($status) {
                $query->where('status', $status === 'active' ? 1 : 0);
            })
            ->when($dateFrom, function ($query) use ($dateFrom) {
                $query->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query) use ($dateTo) {
                $query->whereDate('created_at', '<=', $dateTo);
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        // AJAX request - return same view
        if (request()->ajax()) {
            return view('admin.items.index', compact('items', 'search', 'searchField', 'status', 'dateFrom', 'dateTo'));
        }

        return view('admin.items.index', compact('items', 'search', 'searchField', 'status', 'dateFrom', 'dateTo'));
    }
    public function create()
    {
        $companies = Company::where('is_deleted', '!=', 1)->get();
        return view('admin.items.create', compact('companies'));
    }

    public function store(Request $request)
    {
        try {
            // Validate required fields
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'company_id' => 'required|exists:companies,id',
            ]);

            // Get all data and merge validated fields
            $data = array_merge($request->all(), $validated);
            $data = $this->bools($request, $data);
            
            // Ensure required fields with defaults are set
            $data['is_deleted'] = 0;
            $data['unit'] = $data['unit'] ?? 1;
            $data['locks_flag'] = $data['locks_flag'] ?? 'N';
            
            // Set default values for char fields that might be empty
            $data['narcotic_flag'] = $data['narcotic_flag'] ?? 'N';
            $data['ws_net_toggle'] = $data['ws_net_toggle'] ?? 'Y';
            $data['spl_net_toggle'] = $data['spl_net_toggle'] ?? 'Y';
            $data['expiry_flag'] = $data['expiry_flag'] ?? 'N';
            $data['inclusive_flag'] = $data['inclusive_flag'] ?? 'N';
            $data['generic_flag'] = $data['generic_flag'] ?? 'N';
            $data['h_scm_flag'] = $data['h_scm_flag'] ?? 'N';
            $data['q_scm_flag'] = $data['q_scm_flag'] ?? 'N';
            $data['bar_code_flag'] = $data['bar_code_flag'] ?? 'N';
            $data['def_qty_flag'] = $data['def_qty_flag'] ?? 'N';
            $data['dpc_item_flag'] = $data['dpc_item_flag'] ?? 'N';
            $data['lock_sale_flag'] = $data['lock_sale_flag'] ?? 'N';
            $data['current_scheme_flag'] = $data['current_scheme_flag'] ?? 'N';
            $data['max_min_flag'] = $data['max_min_flag'] ?? '1';
            
            Item::create($data);
            return redirect()->route('admin.items.index')->with('success','Item created successfully!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating item: ' . $e->getMessage())->withInput();
        }
    }
    public function show(Item $item){ return view('admin.items.show', compact('item')); }
    
    public function edit(Item $item)
    {
        $companies = Company::where('is_deleted', '!=', 1)->get();
        return view('admin.items.edit', compact('item', 'companies'));
    }
    public function update(Request $request, Item $item)
    {
        try {
            // Validate required fields
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'company_id' => 'required|exists:companies,id',
            ]);

            // Get all data and merge validated fields
            $data = array_merge($request->all(), $validated);
            $data = $this->bools($request, $data);
            
            // Ensure required fields with defaults are set
            $data['is_deleted'] = 0;
            $data['unit'] = $data['unit'] ?? 1;
            $data['locks_flag'] = $data['locks_flag'] ?? 'N';
            
            // Set default values for char fields that might be empty
            $data['narcotic_flag'] = $data['narcotic_flag'] ?? 'N';
            $data['ws_net_toggle'] = $data['ws_net_toggle'] ?? 'Y';
            $data['spl_net_toggle'] = $data['spl_net_toggle'] ?? 'Y';
            $data['expiry_flag'] = $data['expiry_flag'] ?? 'N';
            $data['inclusive_flag'] = $data['inclusive_flag'] ?? 'N';
            $data['generic_flag'] = $data['generic_flag'] ?? 'N';
            $data['h_scm_flag'] = $data['h_scm_flag'] ?? 'N';
            $data['q_scm_flag'] = $data['q_scm_flag'] ?? 'N';
            $data['bar_code_flag'] = $data['bar_code_flag'] ?? 'N';
            $data['def_qty_flag'] = $data['def_qty_flag'] ?? 'N';
            $data['dpc_item_flag'] = $data['dpc_item_flag'] ?? 'N';
            $data['lock_sale_flag'] = $data['lock_sale_flag'] ?? 'N';
            $data['current_scheme_flag'] = $data['current_scheme_flag'] ?? 'N';
            $data['max_min_flag'] = $data['max_min_flag'] ?? '1';
            
            $item->update($data);
            return redirect()->route('admin.items.index')->with('success','Item updated successfully!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating item: ' . $e->getMessage())->withInput();
        }
    }
    public function destroy(Item $item){ $item->delete(); return back()->with('success','Item deleted'); }

    private function bools(Request $r, array $data): array
    {
        foreach(['CommonItem','PresReq','Inclusive','TaxonMrp','VATonSrate','Exon','DisContinue','LockScm','RateLock','LockBilling','SameBatchCost'] as $b){ $data[$b] = $r->boolean($b); }
        return $data;
    }

    /**
     * View stock ledger for an item (F10) - Basic Version
     */
    public function stockLedger(Item $item)
    {
        $fromDate = request('from_date');
        $toDate = request('to_date');
        $transactionType = request('transaction_type');
        $referenceType = request('reference_type');

        $ledgers = StockLedger::query()
            ->where('item_id', $item->id)
            ->when($fromDate, function ($query) use ($fromDate) {
                return $query->whereDate('transaction_date', '>=', $fromDate);
            })
            ->when($toDate, function ($query) use ($toDate) {
                return $query->whereDate('transaction_date', '<=', $toDate);
            })
            ->when($transactionType, function ($query) use ($transactionType) {
                return $query->where('transaction_type', $transactionType);
            })
            ->when($referenceType, function ($query) use ($referenceType) {
                return $query->where('reference_type', $referenceType);
            })
            ->with('batch', 'createdBy')
            ->orderByDesc('transaction_date')
            ->paginate(25)
            ->withQueryString();

        // Calculate totals
        $totalInMovements = StockLedger::where('item_id', $item->id)
            ->whereIn('transaction_type', ['IN', 'RETURN'])
            ->sum('quantity');

        $totalOutMovements = StockLedger::where('item_id', $item->id)
            ->whereIn('transaction_type', ['OUT', 'ADJUSTMENT'])
            ->sum('quantity');

        return view('admin.items.stock-ledger', compact(
            'item', 'ledgers', 'fromDate', 'toDate', 
            'transactionType', 'referenceType',
            'totalInMovements', 'totalOutMovements'
        ));
    }

    /**
     * Get party details via AJAX
     */
    public function getPartyDetails($type, $id)
    {
        if ($type === 'customer') {
            $party = Customer::find($id);
        } else {
            $party = Supplier::find($id);
        }

        if (!$party) {
            return response()->json(['error' => 'Party not found'], 404);
        }

        return response()->json([
            'name' => $party->name ?? '',
            'address' => $party->address ?? '',
            'city' => $party->city ?? '',
            'phone' => $party->phone ?? '',
        ]);
    }
    
    /**
     * Get item by code for purchase transaction
     */
    public function getByCode($code)
    {
        // Try to find by ID (exact match only)
        $item = Item::where('id', $code)->first();
        
        // If not found by ID, try bar_code
        if (!$item) {
            $item = Item::where('bar_code', $code)->first();
        }
        
        if ($item) {
            return response()->json([
                'success' => true,
                'item' => [
                    'id' => $item->id,
                    'name' => $item->name,
                    'packing' => $item->packing,
                    'case_qty' => $item->case_qty ?? 0,
                    'box_qty' => $item->box_qty ?? 0,
                    'mrp' => $item->mrp ?? 0,
                    'pur_rate' => $item->pur_rate ?? 0,
                    's_rate' => $item->s_rate ?? 0,
                    'ws_rate' => $item->ws_rate ?? 0,
                    'spl_rate' => $item->spl_rate ?? 0,
                    'hsn_code' => $item->hsn_code ?? '',
                    'cgst_percent' => $item->cgst_percent ?? 0,
                    'sgst_percent' => $item->sgst_percent ?? 0,
                    'cess_percent' => $item->cess_percent ?? 0,
                    'fixed_dis_percent' => $item->fixed_dis_percent ?? 0,
                ]
            ]);
        }
        
        return response()->json(['success' => false]);
    }

    /**
     * Get all items for insert modal in purchase transaction
     */
    public function getAllItems()
    {
        try {
            $items = Item::select('id as code', 'name', 'mrp', 's_rate')
                ->where('is_deleted', '!=', 1)
                ->orderBy('name', 'asc')
                ->get();
            
            return response()->json([
                'success' => true,
                'items' => $items
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * View stock ledger for an item (F10) - Complete EasySol Style
     */
    public function stockLedgerComplete(Item $item)
    {
        $fromDate = request('from_date', now()->startOfMonth()->toDateString());
        $toDate = request('to_date', now()->toDateString());
        $partyId = request('party_id');
        $selectedPartyId = $partyId;
        $partyName = '';
        $partyCode = '';

        // Parse party ID (C for customer, S for supplier)
        $customerId = null;
        $supplierId = null;

        if ($partyId) {
            if (str_starts_with($partyId, 'C')) {
                $customerId = substr($partyId, 1);
                $customer = Customer::find($customerId);
                $partyName = $customer->name ?? '';
                $partyCode = $customer->code ?? '';
            } elseif (str_starts_with($partyId, 'S')) {
                $supplierId = substr($partyId, 1);
                $supplier = Supplier::find($supplierId);
                $partyName = $supplier->name ?? '';
                $partyCode = $supplier->code ?? '';
            }
        }

        // Get ledger entries
        $ledgers = StockLedger::query()
            ->where('item_id', $item->id)
            ->whereDate('transaction_date', '>=', $fromDate)
            ->whereDate('transaction_date', '<=', $toDate)
            ->when($customerId, function ($query) use ($customerId) {
                return $query->where('customer_id', $customerId);
            })
            ->when($supplierId, function ($query) use ($supplierId) {
                return $query->where('supplier_id', $supplierId);
            })
            ->with('batch', 'customer', 'supplier', 'salesman')
            ->orderBy('transaction_date')
            ->paginate(20)
            ->withQueryString();

        // Calculate opening and closing balances
        $openingBalance = StockLedger::where('item_id', $item->id)
            ->whereDate('transaction_date', '<', $fromDate)
            ->when($customerId, function ($query) use ($customerId) {
                return $query->where('customer_id', $customerId);
            })
            ->when($supplierId, function ($query) use ($supplierId) {
                return $query->where('supplier_id', $supplierId);
            })
            ->sum('running_balance');

        $closingBalance = $item->getTotalQuantity();

        // Get all customers and suppliers with only needed columns
        $customers = Customer::where('is_deleted', 0)
            ->select('id', 'name', 'code')
            ->orderBy('name')
            ->get();
        $suppliers = Supplier::where('is_deleted', 0)
            ->select('supplier_id', 'name', 'code')
            ->orderBy('name')
            ->get();

        return view('admin.items.stock-ledger-complete', compact(
            'item', 'ledgers', 'fromDate', 'toDate',
            'partyName', 'partyCode', 'selectedPartyId',
            'openingBalance', 'closingBalance',
            'customers', 'suppliers'
        ));
    }

    private function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100',
            'Barcode' => 'nullable|string|max:100',
            'Compcode' => 'nullable|string|max:100',
            'Compname' => 'nullable|string|max:255',
            'Pack' => 'nullable|string|max:50',
            'Unit' => 'nullable|string|in:Kg.,L.,Gm.,Ml.,Doz.,Mtr.',
            'status' => 'nullable|string|max:5',
            'Location' => 'nullable|string|max:100',
            // Add validation rules for all new fields
            'MfgBy' => 'nullable|string|max:255',
            'Division' => 'nullable|string|max:50',
            'BoxQty' => 'nullable|integer',
            'CaseQty' => 'nullable|integer',
            'Schedule' => 'nullable|string|max:50',
            'MinLevel' => 'nullable|integer',
            'MaxLevel' => 'nullable|integer',
            'Flag' => 'nullable|string|max:100',
            'Srate' => 'nullable|numeric',
            'Mrp' => 'nullable|numeric',
            'Net' => 'nullable|numeric',
            'Wsrate' => 'nullable|numeric',
            'SplRate' => 'nullable|numeric',
            'MinGP' => 'nullable|numeric',
            'Commodity' => 'nullable|string|max:255',
            'Scheme' => 'nullable|integer',
            'Prate' => 'nullable|numeric',
            'Cost' => 'nullable|numeric',
            'PurScheme' => 'nullable|integer',
            'NR' => 'nullable|numeric',
            'HSNCode' => 'nullable|string|max:100',
            'CGST' => 'nullable|numeric',
            'SGST' => 'nullable|numeric',
            'IGST' => 'nullable|numeric',
            'Cess' => 'nullable|numeric',
            'VAT' => 'nullable|numeric',
            'Expiry' => 'nullable|date',
            'Generic' => 'nullable|string|max:50',
            'Stax' => 'nullable|numeric',
            'FixedDis' => 'nullable|numeric',
            'Category' => 'nullable|string|max:50',
            'MaxInvQty' => 'nullable|integer',
            'Weight' => 'nullable|numeric',
            'Volume' => 'nullable|numeric',
            'Lock' => 'nullable|string|max:50',
            'BarCodeFlag' => 'nullable|string|max:10',
            'DetQty' => 'nullable|string|max:10',
            'CompNameBC' => 'nullable|string|max:10',
            'DPCItem' => 'nullable|string|max:10',
            'LockSale' => 'nullable|string|max:10',
            'CommodityClass' => 'nullable|string|max:255',
            'CurrentScheme' => 'nullable|string|max:255',
            'CategoryClass' => 'nullable|string|max:50',
            
            // New restructured fields validation
            'unit_1' => 'nullable|string|max:50',
            'unit_2' => 'nullable|string|max:50',
            'min_level' => 'nullable|numeric',
            'max_level' => 'nullable|numeric',
            'narcotic_flag' => 'nullable|string|in:Y,N',
            's_rate' => 'nullable|numeric',
            'net_toggle' => 'nullable|numeric',
            'ws_rate' => 'nullable|numeric',
            'ws_net_toggle' => 'nullable|string|in:Y,N',
            'spl_rate' => 'nullable|numeric',
            'spl_net_toggle' => 'nullable|string|in:Y,N',
            'sale_scheme' => 'nullable|numeric',
            'min_gp' => 'nullable|numeric',
            'pur_rate' => 'nullable|numeric',
            'cost' => 'nullable|numeric',
            'pur_scheme' => 'nullable|numeric',
            'nr' => 'nullable|numeric',
            'hsn_code' => 'nullable|string|max:100',
            'cgst_percent' => 'nullable|numeric',
            'sgst_percent' => 'nullable|numeric',
            'igst_percent' => 'nullable|numeric',
            'cess_percent' => 'nullable|numeric',
            'vat_percent' => 'nullable|numeric',
            'fixed_dis' => 'nullable|string|in:Y,N,M',
            'fixed_dis_percent' => 'nullable|numeric',
            'fixed_dis_type' => 'nullable|string|in:W,R,I',
            'expiry_flag' => 'nullable|string|in:Y,N',
            'inclusive_flag' => 'nullable|string|in:Y,N',
            'generic_flag' => 'nullable|string|in:Y,N',
            'h_scm_flag' => 'nullable|string|in:Y,N',
            'q_scm_flag' => 'nullable|string|in:Y,N',
            'locks_flag' => 'nullable|string|in:Y,N,S',
            'max_inv_qty_value' => 'nullable|numeric',
            'max_inv_qty_new' => 'nullable|string|in:W,R,I',
            'weight_new' => 'nullable|numeric',
            'bar_code_flag' => 'nullable|string|in:Y,N',
            'def_qty_flag' => 'nullable|string|in:Y,N',
            'volume_new' => 'nullable|numeric',
            'comp_name_bc_new' => 'nullable|string|in:Y,N',
            'dpc_item_flag' => 'nullable|string|in:Y,N',
            'lock_sale_flag' => 'nullable|string|in:Y,N',
            'max_min_flag' => 'nullable|string|in:1,2',
            'mrp_for_sale_new' => 'nullable|numeric',
            'commodity' => 'nullable|string|max:255',
            'current_scheme_flag' => 'nullable|string|in:Y,N',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date',
            'scheme_plus_value' => 'nullable|numeric',
            'scheme_minus_value' => 'nullable|numeric',
            'category' => 'nullable|string|max:100',
            'category_2' => 'nullable|string|max:100',
            'upc' => 'nullable|string|max:100',
        ];
    }

    /**
     * View Pending Orders for an item (F7)
     */
    public function pendingOrders(Item $item)
    {
        $pendingOrders = PendingOrder::where('item_id', $item->id)
            ->with('supplier')
            ->orderBy('order_date', 'desc')
            ->paginate(20);

        $suppliers = Supplier::where('is_deleted', 0)
            ->select('supplier_id', 'name', 'code')
            ->orderBy('name')
            ->get();

        return view('admin.items.pending-orders', compact(
            'item',
            'pendingOrders',
            'suppliers'
        ));
    }

    /**
     * Store a new pending order
     */
    public function storePendingOrder(Request $request, Item $item)
    {
        $validated = $request->validate([
            'supplier_id' => 'nullable|exists:suppliers,supplier_id',
            'order_date' => 'nullable|date',
            'rate' => 'nullable|numeric|min:0',
            'tax_percent' => 'nullable|numeric|min:0|max:100',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'cost' => 'nullable|numeric|min:0',
            'scm_percent' => 'nullable|numeric|min:0|max:100',
            'quantity' => 'nullable|numeric|min:0',
        ]);

        // Set defaults for null values
        $validated['supplier_id'] = $validated['supplier_id'] ?? null;
        $validated['order_date'] = $validated['order_date'] ?? now()->toDateString();
        $validated['quantity'] = $validated['quantity'] ?? 0;
        $validated['rate'] = $validated['rate'] ?? 0;
        $validated['cost'] = $validated['cost'] ?? 0;
        $validated['tax_percent'] = $validated['tax_percent'] ?? 0;
        $validated['discount_percent'] = $validated['discount_percent'] ?? 0;
        $validated['scm_percent'] = $validated['scm_percent'] ?? 0;

        // Get supplier details
        $supplier = null;
        if ($validated['supplier_id']) {
            $supplier = Supplier::where('supplier_id', $validated['supplier_id'])->first();
        }

        // Prepare data
        $data = array_merge($validated, [
            'item_id' => $item->id,
            'supplier_name' => $supplier->name ?? '',
            'supplier_code' => $supplier->code ?? '',
        ]);

        PendingOrder::create($data);

        return redirect()->route('admin.items.pending-orders', $item)
            ->with('success', 'Pending Order created successfully');
    }


    /**
     * Update pending order quantity
     */
    public function updatePendingOrderQty(Request $request, PendingOrder $pendingOrder)
    {
        $validated = $request->validate([
            'order_qty' => 'required|numeric|min:0',
            'free_qty' => 'required|numeric|min:0',
        ]);

        $pendingOrder->update([
            'order_qty' => $validated['order_qty'],
            'free_qty' => $validated['free_qty'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Quantity updated successfully',
            'order' => [
                'id' => $pendingOrder->id,
                'order_qty' => $pendingOrder->order_qty,
                'free_qty' => $pendingOrder->free_qty,
            ]
        ]);
    }

    /**
     * Delete pending order
     */
    public function deletePendingOrder(Item $item, PendingOrder $pendingOrder)
    {
        $pendingOrder->delete();

        return redirect()->route('admin.items.pending-orders', $item)
            ->with('success', 'Pending Order deleted successfully');
    }

    /**
     * View Godown Expiry for an item
     */
    public function godownExpiry(Item $item)
    {
        $expiryRecords = GodownExpiry::where('item_id', $item->id)
            ->with('batch')
            ->orderBy('expiry_date', 'asc')
            ->paginate(20);

        return view('admin.items.godown-expiry', compact(
            'item',
            'expiryRecords'
        ));
    }

    /**
     * Store godown expiry record
     */
    public function storeGodownExpiry(Request $request, Item $item)
    {
        $validated = $request->validate([
            'batch_id' => 'required|exists:batches,id',
            'expiry_date' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'godown_location' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        $validated['item_id'] = $item->id;
        $validated['status'] = 'active';

        GodownExpiry::create($validated);

        return redirect()->route('admin.items.godown-expiry', $item)
            ->with('success', 'Expiry record created successfully');
    }

    /**
     * Mark godown expiry as expired
     */
    public function markExpired(Item $item, GodownExpiry $godownExpiry)
    {
        $godownExpiry->update(['status' => 'expired']);

        return redirect()->route('admin.items.godown-expiry', $item)
            ->with('success', 'Record marked as expired');
    }

    /**
     * Delete godown expiry record
     */
    public function deleteGodownExpiry(Item $item, GodownExpiry $godownExpiry)
    {
        $godownExpiry->delete();

        return redirect()->route('admin.items.godown-expiry', $item)
            ->with('success', 'Expiry record deleted successfully');
    }

    /**
     * View Expiry Ledger for an item
     */
    public function expiryLedger(Item $item)
    {
        $fromDate = request('from_date', now()->startOfMonth()->toDateString());
        $toDate = request('to_date', now()->toDateString());

        $ledgers = ExpiryLedger::where('item_id', $item->id)
            ->whereDate('transaction_date', '>=', $fromDate)
            ->whereDate('transaction_date', '<=', $toDate)
            ->with('batch', 'customer', 'supplier')
            ->orderBy('transaction_date', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('admin.items.expiry-ledger', compact(
            'item',
            'ledgers',
            'fromDate',
            'toDate'
        ));
    }

    /**
     * Store expiry ledger entry
     */
    public function storeExpiryLedger(Request $request, Item $item)
    {
        $validated = $request->validate([
            'batch_id' => 'required|exists:batches,id',
            'transaction_date' => 'required|date',
            'trans_no' => 'nullable|string|max:100',
            'transaction_type' => 'required|in:IN,OUT,RETURN,ADJUSTMENT',
            'party_name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'free_quantity' => 'nullable|integer|min:0',
            'running_balance' => 'required|numeric',
            'expiry_date' => 'required|date',
            'remarks' => 'nullable|string',
        ]);

        $validated['item_id'] = $item->id;

        ExpiryLedger::create($validated);

        return redirect()->route('admin.items.expiry-ledger', $item)
            ->with('success', 'Expiry ledger entry created successfully');
    }

    /**
     * Delete expiry ledger entry
     */
    public function deleteExpiryLedger(Item $item, ExpiryLedger $expiryLedger)
    {
        $expiryLedger->delete();

        return redirect()->route('admin.items.expiry-ledger', $item)
            ->with('success', 'Expiry ledger entry deleted successfully');
    }
}


