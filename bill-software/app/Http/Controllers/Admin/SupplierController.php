<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(){ $search = request('search'); $status = request('status'); $dateFrom = request('date_from'); $dateTo = request('date_to'); $suppliers = Supplier::query()->when($search, function($query) use ($search){ $query->where(function($q) use ($search){ $q->where('name','like',"%{$search}%")->orWhere('code','like',"%{$search}%")->orWhere('mobile','like',"%{$search}%")->orWhere('email','like',"%{$search}%"); }); })->when($status!==null && $status!=='', function($query) use ($status){ $query->where('status', $status==='active'?1:0); })->when($dateFrom, function($query) use ($dateFrom){ $query->whereDate('created_at','>=',$dateFrom); })->when($dateTo, function($query) use ($dateTo){ $query->whereDate('created_at','<=',$dateTo); })->orderByDesc('created_at')->paginate(10)->withQueryString(); return view('admin.suppliers.index', compact('suppliers','search','status','dateFrom','dateTo')); }
    public function create(){ return view('admin.suppliers.create'); }
    public function store(Request $request)
    {
        // Validate required fields
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'email' => 'required|email|max:255|unique:suppliers,email',
            'telephone' => 'required|string|max:255|unique:suppliers,telephone',
            // Optional mobiles unique if provided
            'mobile' => 'nullable|string|max:255|unique:suppliers,mobile',
            'mobile_additional' => 'nullable|string|max:255|unique:suppliers,mobile_additional',
        ]);

        // Get all data and merge validated fields
        $data = array_merge($request->all(), $validated);
        $data = $this->bools($request, $data);
        Supplier::create($data);
        return redirect()->route('admin.suppliers.index')->with('success','Supplier created');
    }
    public function show(Supplier $supplier){ return view('admin.suppliers.show', compact('supplier')); }
    public function edit(Supplier $supplier){ return view('admin.suppliers.edit', compact('supplier')); }
    public function update(Request $request, Supplier $supplier){ $data = $request->all(); $data = $this->bools($request,$data); $supplier->update($data); return redirect()->route('admin.suppliers.index')->with('success','Supplier updated'); }
    public function destroy(Supplier $supplier){ $supplier->delete(); return back()->with('success','Supplier deleted'); }

    private function bools(Request $r, array $data): array
    {
        foreach(['status','discount_on_excise','discount_after_scheme','invoice_on_trade_rate','net_rate_yn','scheme_in_decimal','vat_on_bill_expiry','tax_on_fqty','expiry_on_mrp_sale_rate_purchase_rate','composite_scheme','stock_transfer','cash_purchase','add_charges_with_gst','purchase_import_box_conversion','tcs_applicable','tds_yn','tds_on_return','tds_tcs_on_bill_amount'] as $b){
            $data[$b] = $r->boolean($b);
        }
        return $data;
    }

    private function rules(): array
    {
        return [
            'name'=>'required|string|max:255', 'code'=>'nullable|string|max:255', 'address'=>'nullable|string', 'telephone'=>'nullable|string|max:255', 'email'=>'nullable|email', 'tax_retail_flag'=>'nullable|string', 'tan_no'=>'nullable|string', 'msme_lic'=>'nullable|string', 'opening_balance'=>'nullable|numeric', 'credit_limit'=>'nullable|numeric', 'b_day'=>'nullable|date', 'a_day'=>'nullable|date', 'contact_person_1'=>'nullable|string', 'contact_person_2'=>'nullable|string', 'mobile'=>'nullable|string', 'mobile_additional'=>'nullable|string', 'fax'=>'nullable|string', 'status'=>'nullable|boolean', 'flag'=>'nullable|string', 'dl_no'=>'nullable|string', 'dl_no_1'=>'nullable|string', 'food_lic'=>'nullable|string', 'cst_no'=>'nullable|string', 'tin_no'=>'nullable|string', 'pan'=>'nullable|string', 'gst_no'=>'nullable|string', 'state_code'=>'nullable|string', 'local_central_flag'=>'nullable|string', 'discount_on_excise'=>'nullable|boolean', 'scheme_type'=>'nullable|string', 'discount_after_scheme'=>'nullable|boolean', 'direct_indirect'=>'nullable|string', 'invoice_on_trade_rate'=>'nullable|boolean', 'net_rate_yn'=>'nullable|boolean', 'visit_days'=>'nullable|string', 'invoice_roff'=>'nullable|numeric', 'scheme_in_decimal'=>'nullable|boolean', 'vat_on_bill_expiry'=>'nullable|boolean', 'tax_on_fqty'=>'nullable|boolean', 'expiry_on_mrp_sale_rate_purchase_rate'=>'nullable|boolean', 'sale_purchase_status'=>'nullable|string', 'composite_scheme'=>'nullable|boolean', 'stock_transfer'=>'nullable|boolean', 'cash_purchase'=>'nullable|boolean', 'add_charges_with_gst'=>'nullable|boolean', 'purchase_import_box_conversion'=>'nullable|boolean', 'full_name'=>'nullable|string', 'aadhar'=>'nullable|string', 'registered_unregistered_composite'=>'nullable|string', 'registration_date'=>'nullable|date', 'tcs_applicable'=>'nullable|boolean', 'tds_yn'=>'nullable|boolean', 'tds_on_return'=>'nullable|boolean', 'tds_tcs_on_bill_amount'=>'nullable|boolean', 'bank'=>'nullable|string', 'branch'=>'nullable|string', 'account_no'=>'nullable|string', 'ifsc_code'=>'nullable|string'
        ];
    }
}


