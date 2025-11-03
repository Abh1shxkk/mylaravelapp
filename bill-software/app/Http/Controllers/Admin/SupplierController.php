<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\PendingOrder;
use App\Models\Item;
use App\Helpers\StateHelper;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    public function index()
    {
        $searchField = request('search_field', 'all');
        $search = request('search');
        $status = request('status');
        $dateFrom = request('date_from');
        $dateTo = request('date_to');

        $suppliers = Supplier::query()
            ->when($search, function ($query) use ($search, $searchField) {
                if ($searchField === 'all') {
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('code', 'like', "%{$search}%")
                            ->orWhere('mobile', 'like', "%{$search}%")
                            ->orWhere('telephone', 'like', "%{$search}%")
                            ->orWhere('address', 'like', "%{$search}%")
                            ->orWhere('dl_no', 'like', "%{$search}%")
                            ->orWhere('gst_no', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
                } else {
                    $query->where($searchField, 'like', "%{$search}%");
                }
            })
            ->when($status !== null && $status !== '', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($dateFrom, function ($query) use ($dateFrom) {
                $query->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query) use ($dateTo) {
                $query->whereDate('created_at', '<=', $dateTo);
            })
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        // Return view for both AJAX and regular requests
        return view('admin.suppliers.index', compact('suppliers', 'searchField', 'search', 'status', 'dateFrom', 'dateTo'));
    }

    public function create()
    {
        $states = StateHelper::getStates();
        return view('admin.suppliers.create', compact('states'));
    }

    public function store(Request $request)
    {
        // Validate required fields
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'email' => 'required|email|max:255|unique:suppliers,email',
            'telephone' => 'required|string|max:255|unique:suppliers,telephone',
            // Optional fields with unique constraint if provided
            'mobile' => 'nullable|string|max:255|unique:suppliers,mobile',
            'mobile_additional' => 'nullable|string|max:255|unique:suppliers,mobile_additional',
            'code' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:5',
        ]);

        // Prepare data for storage
        $data = $this->prepareSupplierData($request);

        Supplier::create($data);

        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier created successfully');
    }

    public function show(Supplier $supplier)
    {
        return view('admin.suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        $states = StateHelper::getStates();
        return view('admin.suppliers.edit', compact('supplier', 'states'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        // Basic validation first (without unique checks)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:255',
            'mobile' => 'nullable|string|max:255',
            'mobile_additional' => 'nullable|string|max:255',
            'code' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:5',
        ]);

        // Manual unique validation excluding current supplier
        // Skip email validation temporarily due to existing duplicates
        // $emailExists = Supplier::where('email', $request->email)
        //     ->where('supplier_id', '!=', $supplier->supplier_id)
        //     ->exists();
            
        // Skip telephone validation temporarily due to existing duplicates
        // $telephoneExists = Supplier::where('telephone', $request->telephone)
        //     ->where('supplier_id', '!=', $supplier->supplier_id)
        //     ->exists();

        // if ($emailExists) {
        //     return back()->withErrors(['email' => 'The email has already been taken.'])->withInput();
        // }

        // if ($telephoneExists) {
        //     return back()->withErrors(['telephone' => 'The telephone has already been taken.'])->withInput();
        // }

        // Temporarily disable all unique validations
        // Check mobile if provided
        // if ($request->mobile) {
        //     $mobileExists = Supplier::where('mobile', $request->mobile)
        //         ->where('supplier_id', '!=', $supplier->supplier_id)
        //         ->exists();
        //     if ($mobileExists) {
        //         return back()->withErrors(['mobile' => 'The mobile has already been taken.'])->withInput();
        //     }
        // }

        // Check mobile_additional if provided
        // if ($request->mobile_additional) {
        //     $mobileAdditionalExists = Supplier::where('mobile_additional', $request->mobile_additional)
        //         ->where('supplier_id', '!=', $supplier->supplier_id)
        //         ->exists();
        //     if ($mobileAdditionalExists) {
        //         return back()->withErrors(['mobile_additional' => 'The mobile additional has already been taken.'])->withInput();
        //     }
        // }

        // Prepare data for update
        try {
            $data = $this->prepareSupplierData($request);
            
            // Debug: Log the data being prepared
            \Log::info('Prepared data for supplier update:', $data);
            
            $supplier->update($data);
            
            return redirect()->route('admin.suppliers.index')->with('success', 'Supplier updated successfully');
            
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Supplier update failed: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Return with error message
            return back()->withErrors(['error' => 'Update failed: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return back()->with('success', 'Supplier deleted successfully');
    }

    /**
     * Prepare supplier data from request
     */
    private function prepareSupplierData(Request $request): array
    {
        $data = [
            // Basic Information
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'address' => $request->input('address'),
            'telephone' => $request->input('telephone'),
            'email' => $request->input('email'),
            'fax' => $request->input('fax'),
            'tax_retail_flag' => $request->input('tax_retail_flag', 'T'),
            'status' => $request->input('status'),

            // Contact Information
            'b_day' => $request->input('b_day'),
            'a_day' => $request->input('a_day'),
            'contact_person_1' => $request->input('contact_person_1'),
            'contact_person_2' => $request->input('contact_person_2'),
            'mobile' => $request->input('mobile'),
            'mobile_additional' => $request->input('mobile_additional'),
            'flag' => $request->input('flag'),
            'visit_days' => $request->input('visit_days'),

            // License & Registration
            'dl_no' => $request->input('dl_no'),
            'dl_no_1' => $request->input('dl_no_1'),
            'food_lic' => $request->input('food_lic'),
            'msme_lic' => $request->input('msme_lic'),
            'cst_no' => $request->input('cst_no'),
            'tin_no' => $request->input('tin_no'),
            'gst_no' => $request->input('gst_no'),
            'pan' => $request->input('pan'),
            'tan_no' => $request->input('tan_no'),
            'state_code' => $request->input('state_code'),
            'local_central_flag' => $request->input('local_central_flag', 'L'),
            'full_name' => $request->input('full_name'),

            // Financial Information
            'opening_balance' => $request->input('opening_balance', 0.00),
            'opening_balance_type' => $request->input('opening_balance_type', 'C'),
            'credit_limit' => $request->input('credit_limit', 0.00),
            'invoice_roff' => $this->convertYNToDecimal($request->input('invoice_roff', 'N')),
            'direct_indirect' => $request->input('direct_indirect', 'T'),

            // Bank Details
            'bank' => $request->input('bank'),
            'branch' => $request->input('branch'),
            'account_no' => $request->input('account_no'),
            'ifsc_code' => $request->input('ifsc_code'),

            // Transaction & Scheme Details
            'discount_on_excise' => $this->convertYNToBoolean($request->input('discount_on_excise', 'N')),
            'discount_after_scheme' => $this->convertYNToBoolean($request->input('discount_after_scheme', 'N')),
            'scheme_type' => $request->input('scheme_type'),
            'invoice_on_trade_rate' => $this->convertYNToBoolean($request->input('invoice_on_trade_rate', 'N')),
            'net_rate_yn' => $request->input('net_rate_yn', 'N'), // Store as string Y/N/M
            'scheme_in_decimal' => $this->convertYNToBoolean($request->input('scheme_in_decimal', 'N')),
            'vat_on_bill_expiry' => $this->convertYNToBoolean($request->input('vat_on_bill_expiry', 'N')),
            'tax_on_fqty' => $this->convertYNToBoolean($request->input('tax_on_fqty', 'N')),
            'sale_purchase_status' => $request->input('sale_purchase_status', 'B'),
            'expiry_on_mrp_sale_rate_purchase_rate' => $request->input('expiry_on_mrp_sale_rate_purchase_rate', 'N'), // Store as string Y/N
            'composite_scheme' => $this->convertYNToBoolean($request->input('composite_scheme', 'N')),
            'stock_transfer' => $this->convertYNToBoolean($request->input('stock_transfer', 'N')),
            'cash_purchase' => $this->convertYNToBoolean($request->input('cash_purchase', 'N')),
            'add_charges_with_gst' => $this->convertYNToBoolean($request->input('add_charges_with_gst', 'N')),
            'purchase_import_box_conversion' => $this->convertYNToBoolean($request->input('purchase_import_box_conversion', 'N')),

            // Registration & Compliance
            'aadhar' => $request->input('aadhar'),
            'registration_date' => $request->input('registration_date'),
            'registered_unregistered_composite' => $request->input('registered_unregistered_composite', 'U'),
            'tcs_applicable' => $request->input('tcs_applicable', 'N'), // Store as string Y/N/#
            'tds_yn' => $this->convertYNToBoolean($request->input('tds_yn', 'N')),
            'tds_on_return' => $this->convertYNToBoolean($request->input('tds_on_return', 'N')),
            'tds_tcs_on_bill_amount' => $request->has('tds_tcs_on_bill_amount') ? true : false,

            // Additional Notes
            'notebook' => $request->input('notebook'),
            'remarks' => $request->input('remarks'),
        ];

        return $data;
    }

    /**
     * Convert Y/N values to decimal for database storage
     */
    private function convertYNToDecimal($value): float
    {
        return $value === 'Y' ? 1.00 : 0.00;
    }

    /**
     * Convert Y/N values to boolean for database storage
     */
    private function convertYNToBoolean($value): bool
    {
        return $value === 'Y';
    }

    /**
     * View Pending Orders for a supplier
     */
    public function pendingOrders(Supplier $supplier)
    {
        $orders = PendingOrder::where('supplier_id', $supplier->supplier_id)
            ->orderBy('order_date', 'desc')
            ->paginate(20);

        // Get all items for dropdown
        $items = Item::where('is_deleted', 0)
            ->select('id', 'bar_code', 'name', 'packing')
            ->orderBy('name')
            ->get();

        return view('admin.suppliers.pending-orders', compact(
            'supplier',
            'orders',
            'items'
        ));
    }

    /**
     * Store a new pending order for supplier
     */
    public function storePendingOrder(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'order_no' => 'required|string|max:50',
            'item_id' => 'required|exists:items,id',
            'order_date' => 'required|date',
            'balance_qty' => 'required|numeric|min:0',
            'order_qty' => 'required|numeric|min:0',
            'free_qty' => 'required|numeric|min:0',
        ]);

        // Check if this supplier already has an order for this item
        $existingOrder = PendingOrder::where('supplier_id', $supplier->supplier_id)
            ->where('item_id', $validated['item_id'])
            ->first();

        if ($existingOrder) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item already added! Please edit the existing order from Item Pending Orders page to update quantity.'
                ], 422);
            }

            return redirect()->route('admin.suppliers.pending-orders', $supplier)
                ->with('error', 'Item already added! Please edit the existing order from Item Pending Orders page to update quantity.');
        }

        // Check if this item already has orders from OTHER suppliers
        $otherOrders = PendingOrder::where('item_id', $validated['item_id'])
            ->where('supplier_id', '!=', $supplier->supplier_id)
            ->with('supplier')
            ->get();
        
        // If other suppliers have ordered this item and user hasn't confirmed, show confirmation
        if ($otherOrders->isNotEmpty() && $request->ajax() && !$request->input('force_create')) {
            $suppliersList = $otherOrders->map(function($order) {
                return [
                    'name' => $order->supplier->name ?? 'Unknown',
                    'order_no' => $order->order_no ?? 'N/A'
                ];
            })->unique('name')->values();
            
            return response()->json([
                'success' => false,
                'requires_confirmation' => true,
                'message' => 'Order Already Given',
                'suppliers' => $suppliersList
            ], 200);
        }
        
        $otherOrderQty = $otherOrders->sum(function($order) {
            return $order->order_qty + $order->free_qty;
        });

        // Set supplier_id and calculated other_order
        $validated['supplier_id'] = $supplier->supplier_id;
        $validated['other_order'] = $otherOrderQty;

        $order = PendingOrder::create($validated);
        $order->load('item');
        
        // Update other_order for all existing orders of this item (including other suppliers)
        $this->updateOtherOrderQuantities($validated['item_id']);

        // Check if AJAX request
        if ($request->ajax() || $request->wantsJson()) {
            $totalOrders = PendingOrder::where('supplier_id', $supplier->supplier_id)->count();
            
            return response()->json([
                'success' => true,
                'message' => 'Order added successfully',
                'order' => [
                    'id' => $order->id,
                    'index' => $totalOrders,
                    'order_no' => $order->order_no,
                    'item_id' => $order->item_id,
                    'company' => $order->item->company_short_name ?? '---',
                    'balance_qty' => $order->balance_qty,
                    'item_code' => $order->item->bar_code ?? '---',
                    'item_name' => $order->item->name ?? '---',
                    'pack' => $order->item->packing ?? '---',
                    'order_qty' => $order->order_qty,
                    'free_qty' => $order->free_qty,
                    'other_order' => $order->other_order,
                    'order_date' => \Carbon\Carbon::parse($order->order_date)->format('d-M-y'),
                    'order_date_raw' => $order->order_date,
                    'item_cost' => $order->item->cost ?? 0,
                ]
            ]);
        }

        return redirect()->route('admin.suppliers.pending-orders', $supplier)
            ->with('success', 'Order added successfully');
    }

    /**
     * Update pending order
     */
    public function updatePendingOrder(Request $request, Supplier $supplier, PendingOrder $pendingOrder)
    {
        $validated = $request->validate([
            'order_no' => 'required|string|max:50',
            'item_id' => 'required|exists:items,id',
            'order_date' => 'required|date',
            'balance_qty' => 'required|numeric|min:0',
            'order_qty' => 'required|numeric|min:0',
            'free_qty' => 'required|numeric|min:0',
        ]);

        // Update the order
        $pendingOrder->update($validated);
        
        // Recalculate other_order for all orders of this item
        $this->updateOtherOrderQuantities($validated['item_id']);
        
        $pendingOrder->load('item');

        // Check if AJAX request
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Order updated successfully',
                'order' => [
                    'id' => $pendingOrder->id,
                    'order_no' => $pendingOrder->order_no,
                    'item_id' => $pendingOrder->item_id,
                    'company' => $pendingOrder->item->company_short_name ?? '---',
                    'balance_qty' => $pendingOrder->balance_qty,
                    'item_code' => $pendingOrder->item->bar_code ?? '---',
                    'item_name' => $pendingOrder->item->name ?? '---',
                    'pack' => $pendingOrder->item->packing ?? '---',
                    'order_qty' => $pendingOrder->order_qty,
                    'free_qty' => $pendingOrder->free_qty,
                    'other_order' => $pendingOrder->other_order,
                    'order_date' => \Carbon\Carbon::parse($pendingOrder->order_date)->format('d-M-y'),
                    'order_date_raw' => $pendingOrder->order_date,
                    'item_cost' => $pendingOrder->item->cost ?? 0,
                ]
            ]);
        }

        return redirect()->route('admin.suppliers.pending-orders', $supplier)
            ->with('success', 'Order updated successfully');
    }
    
    /**
     * Delete pending order
     */
    public function deletePendingOrder(Request $request, Supplier $supplier, PendingOrder $pendingOrder)
    {
        $itemId = $pendingOrder->item_id;
        $pendingOrder->delete();
        
        // Update other_order for remaining orders of this item
        $this->updateOtherOrderQuantities($itemId);

        // Check if AJAX request
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Order deleted successfully'
            ]);
        }

        return redirect()->route('admin.suppliers.pending-orders', $supplier)
            ->with('success', 'Order deleted successfully');
    }
    
    /**
     * Print pending order by order number
     */
    public function printPendingOrder(Request $request, Supplier $supplier, $orderNo)
    {
        $orders = PendingOrder::where('supplier_id', $supplier->supplier_id)
            ->where('order_no', $orderNo)
            ->with('item')
            ->get();
        
        if ($orders->isEmpty()) {
            return redirect()->route('admin.suppliers.pending-orders', $supplier)
                ->with('error', 'No orders found for this order number.');
        }
        
        $withTotal = $request->query('with_total', '1') === '1';
        
        return view('admin.suppliers.print-pending-order', compact('supplier', 'orders', 'orderNo', 'withTotal'));
    }
    
    /**
     * Update other_order quantities for all orders of a specific item
     * This recalculates the "other suppliers order quantity + free quantity" for each supplier
     */
    private function updateOtherOrderQuantities($itemId)
    {
        // Get all orders for this item grouped by supplier
        $orders = PendingOrder::where('item_id', $itemId)->get();
        
        foreach ($orders as $order) {
            // Calculate total (order_qty + free_qty) from OTHER suppliers for this item
            $otherOrders = PendingOrder::where('item_id', $itemId)
                ->where('supplier_id', '!=', $order->supplier_id)
                ->get();
            
            $otherOrderQty = $otherOrders->sum(function($otherOrder) {
                return $otherOrder->order_qty + $otherOrder->free_qty;
            });
            
            // Update the other_order field
            $order->update(['other_order' => $otherOrderQty]);
        }
    }
    
    /**
     * Get pending orders data for supplier (for purchase transaction)
     */
    public function getPendingOrdersData(Supplier $supplier)
    {
        $orders = PendingOrder::where('supplier_id', $supplier->supplier_id)
            ->with('item')
            ->orderBy('order_date', 'desc')
            ->get();
        
        $ordersData = $orders->map(function($order) {
            $item = null;
            
            // Try to get item by relationship
            if ($order->item) {
                $item = $order->item;
            } 
            // If relationship fails, try direct query
            else if ($order->item_id) {
                $item = Item::find($order->item_id);
            }
            
            return [
                'order_no' => $order->order_no,
                'item_id' => $order->item_id, // Debug
                'item_code' => $item ? $item->item_code : '---',
                'item_name' => $item ? $item->name : '---', // Changed from item_name to name
                'order_qty' => $order->order_qty ?? 0,
                'free_qty' => $order->free_qty ?? 0,
                'order_date' => $order->order_date ? $order->order_date->format('Y-m-d') : '---',
            ];
        });
        
        return response()->json([
            'success' => true,
            'orders' => $ordersData
        ]);
    }
    
    /**
     * Get items for specific order number
     */
    public function getOrderItems(Supplier $supplier, $orderNo)
    {
        $orders = PendingOrder::where('supplier_id', $supplier->supplier_id)
            ->where('order_no', $orderNo)
            ->with('item')
            ->get();
        
        $items = $orders->map(function($order) {
            $item = null;
            
            // Try to get item by relationship
            if ($order->item) {
                $item = $order->item;
            } 
            // If relationship fails, try direct query
            else if ($order->item_id) {
                $item = Item::find($order->item_id);
            }
            
            return [
                'item_code' => $item ? $item->id : '', // Use item ID as code
                'item_name' => $item ? $item->name : '',
                'order_qty' => $order->order_qty ?? 0,
                'free_qty' => $order->free_qty ?? 0,
                'balance_qty' => $order->balance_qty ?? 0,
                'pur_rate' => $item ? $item->pur_rate : 0, // Purchase rate from item
                'mrp' => $item ? $item->mrp : 0, // MRP from item
            ];
        });
        
        return response()->json([
            'success' => true,
            'items' => $items
        ]);
    }
}