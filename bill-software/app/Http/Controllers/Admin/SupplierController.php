<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
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
}