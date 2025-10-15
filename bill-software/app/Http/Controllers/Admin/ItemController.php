<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Company;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(){ $search = request('search'); $status = request('status'); $dateFrom = request('date_from'); $dateTo = request('date_to'); $items = Item::query()->when($search, function($query) use ($search){ $query->where(function($q) use ($search){ $q->where('name','like',"%{$search}%")->orWhere('code','like',"%{$search}%")->orWhere('Barcode','like',"%{$search}%"); }); })->when($status!==null && $status!=='', function($query) use ($status){ $query->where('status', $status==='active'?1:0); })->when($dateFrom, function($query) use ($dateFrom){ $query->whereDate('created_at','>=',$dateFrom); })->when($dateTo, function($query) use ($dateTo){ $query->whereDate('created_at','<=',$dateTo); })->orderByDesc('id')->paginate(10)->withQueryString(); return view('admin.items.index', compact('items','search','status','dateFrom','dateTo')); }
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
}


