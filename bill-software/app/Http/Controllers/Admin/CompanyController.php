<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $search = request('search');
        $searchField = request('search_field', 'all');
        $status = request('status');
        $dateFrom = request('date_from');
        $dateTo = request('date_to');

        // Debug logging
        \Log::info('Company search', [
            'search' => $search,
            'search_field' => $searchField
        ]);

        $companies = Company::query()
            ->when($search && trim($search) !== '', function ($query) use ($search, $searchField) {
                $search = trim($search);
                
                if ($searchField === 'all') {
                    // Search across all fields
                    $query->where(function ($q) use ($search) {
                        $q->where('alter_code', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('mobile_1', 'like', "%{$search}%")
                            ->orWhere('mobile_2', 'like', "%{$search}%")
                            ->orWhere('contact_person_1', 'like', "%{$search}%")
                            ->orWhere('contact_person_2', 'like', "%{$search}%")
                            ->orWhere('telephone', 'like', "%{$search}%")
                            ->orWhere('address', 'like', "%{$search}%");
                    });
                } elseif ($searchField === 'mobile') {
                    // Search in both mobile fields
                    $query->where(function ($q) use ($search) {
                        $q->where('mobile_1', 'like', "%{$search}%")
                            ->orWhere('mobile_2', 'like', "%{$search}%");
                    });
                } else {
                    // Search in specific field - ensure field name is valid
                    $validFields = ['alter_code', 'name', 'telephone', 'address'];
                    if (in_array($searchField, $validFields)) {
                        $query->where($searchField, 'like', "%{$search}%");
                    }
                }
            })
            ->when($status !== null && $status !== '', function ($query) use ($status) {
                $query->whereRaw('LOWER(status) = ?', [strtolower($status)]);
            })
            ->when($dateFrom, function ($query) use ($dateFrom) {
                $query->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query) use ($dateTo) {
                $query->whereDate('created_at', '<=', $dateTo);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // AJAX request ke liye sirf table return karo
        if (request()->ajax()) {
            return view('admin.companies.index', compact('companies', 'search', 'searchField', 'status', 'dateFrom', 'dateTo'));
        }

        return view('admin.companies.index', compact('companies', 'search', 'searchField', 'status', 'dateFrom', 'dateTo'));
    }

    public function create()
    {
        return view('admin.companies.create');
    }

    public function store(Request $request)
    {
        // Validate required fields
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:companies,email',
            'address' => 'required|string',
            // gst_number removed
            'telephone' => 'nullable|string|max:255|unique:companies,telephone',
            'mobile_1' => 'nullable|string|max:255|unique:companies,mobile_1',
            'mobile_2' => 'nullable|string|max:255|unique:companies,mobile_2',
            'generic' => 'nullable|in:y,n,Y,N',
            'expiry' => 'nullable|in:y,n,Y,N',
            'lock_aiocd' => 'nullable|in:y,n,Y,N',
            'notes' => 'nullable|string',
            'lock_ims' => 'nullable|in:y,n,Y,N',
            'surcharge_after_dis_yn' => 'nullable|in:y,n,Y,N',
            'add_surcharge_yn' => 'nullable|in:y,n,Y,N',
            'inclusive_yn' => 'nullable|in:y,n,Y,N',
            'direct_indirect' => 'nullable|in:d,i,D,I',
            'fixed_maximum' => 'nullable|in:f,m,F,M',
            'status' => 'nullable|string|max:5',
        ]);

        // Get all data and merge validated fields
        $data = array_merge($request->all(), $validated);
        // status becomes string (max 5)
        $data['status'] = $request->input('status');
        // Map Y/N inputs to booleans for boolean columns
        $data['surcharge_after_dis_yn'] = strtolower($request->input('surcharge_after_dis_yn', 'n')) === 'y';
        $data['add_surcharge_yn'] = strtolower($request->input('add_surcharge_yn', 'n')) === 'y';
        $data['inclusive_yn'] = strtolower($request->input('inclusive_yn', 'n')) === 'y';
        // fixed_maximum becomes char f/m
        $data['fixed_maximum'] = strtolower($request->input('fixed_maximum', 'f'));
        
        // Convert y/n fields to lowercase
        $data['generic'] = strtolower($request->input('generic', 'n'));
        $data['expiry'] = strtolower($request->input('expiry', 'n'));
        $data['lock_aiocd'] = strtolower($request->input('lock_aiocd', 'n'));
        $data['lock_ims'] = strtolower($request->input('lock_ims', 'n'));
        $data['direct_indirect'] = strtolower($request->input('direct_indirect', 'd'));
        // Lock discount to 0
        $data['discount'] = 0;
        
        Company::create($data);
        return redirect()->route('admin.companies.index')->with('success', 'Company created');
    }

    public function show(Company $company)
    {
        if (request()->ajax()) {
            return response()->json($company);
        }
        return view('admin.companies.show', compact('company'));
    }

    public function edit(Company $company)
    {
        return view('admin.companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        // Validate y/n fields
        $validated = $request->validate([
            'generic' => 'nullable|in:y,n,Y,N',
            'expiry' => 'nullable|in:y,n,Y,N',
            'lock_aiocd' => 'nullable|in:y,n,Y,N',
            'lock_ims' => 'nullable|in:y,n,Y,N',
            'surcharge_after_dis_yn' => 'nullable|in:y,n,Y,N',
            'add_surcharge_yn' => 'nullable|in:y,n,Y,N',
            'inclusive_yn' => 'nullable|in:y,n,Y,N',
            'notes' => 'nullable|string',
            'direct_indirect' => 'nullable|in:d,i,D,I',
            'fixed_maximum' => 'nullable|in:f,m,F,M',
            'status' => 'nullable|string|max:5',
        ]);
        
        $data = $request->all();
        // status becomes string (max 5)
        $data['status'] = $request->input('status');
        // Map Y/N inputs to booleans for boolean columns
        $data['surcharge_after_dis_yn'] = strtolower($request->input('surcharge_after_dis_yn', 'n')) === 'y';
        $data['add_surcharge_yn'] = strtolower($request->input('add_surcharge_yn', 'n')) === 'y';
        $data['inclusive_yn'] = strtolower($request->input('inclusive_yn', 'n')) === 'y';
        // fixed_maximum becomes char f/m
        $data['fixed_maximum'] = strtolower($request->input('fixed_maximum', 'f'));
        
        // Convert y/n fields to lowercase
        $data['generic'] = strtolower($request->input('generic', 'n'));
        $data['expiry'] = strtolower($request->input('expiry', 'n'));
        $data['lock_aiocd'] = strtolower($request->input('lock_aiocd', 'n'));
        $data['lock_ims'] = strtolower($request->input('lock_ims', 'n'));
        $data['direct_indirect'] = strtolower($request->input('direct_indirect', 'd'));
        // Lock discount to 0
        $data['discount'] = 0;
        
        $company->update($data);
        return redirect()->route('admin.companies.index')->with('success', 'Company updated');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return back()->with('success', 'Company deleted');
    }

    // Local validation rules helper
    private function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'email' => 'nullable|email',
            'contact_person_1' => 'nullable|string|max:255',
            'contact_person_2' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'alter_code' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'telephone' => 'nullable|string|max:255',
            'short_name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'mobile_1' => 'nullable|string|max:255',
            'mobile_2' => 'nullable|string|max:255',
            'pur_sc' => 'nullable|string|max:255',
            'sale_sc' => 'nullable|string|max:255',
            'expiry' => 'nullable|string|max:255',
            'dis_on_sale_percent' => 'nullable|numeric',
            'min_gp' => 'nullable|numeric',
            'pur_tax' => 'nullable|numeric',
            'sale_tax' => 'nullable|numeric',
            // gst_number removed
            'generic' => 'nullable|string|max:255',
            'invoice_print_order' => 'nullable|string|max:255',
            'direct_indirect' => 'nullable|in:d,i,D,I',
            'surcharge_after_dis_yn' => 'nullable|in:y,n,Y,N',
            'add_surcharge_yn' => 'nullable|in:y,n,Y,N',
            'vat_percent' => 'nullable|numeric',
            'inclusive_yn' => 'nullable|in:y,n,Y,N',
            'disallow_expiry_after_months' => 'nullable|integer',
            'fixed_maximum' => 'nullable|in:f,m,F,M',
            'discount' => 'nullable|numeric',
            'flag' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:5',
            'country_code' => 'nullable|string|max:10',
            'country_name' => 'nullable|string|max:100',
            'state_code' => 'nullable|string|max:10',
            'state_name' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:255',
        ];
    }
}


