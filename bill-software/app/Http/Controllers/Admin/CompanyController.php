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
        $status = request('status');
        $dateFrom = request('date_from');
        $dateTo = request('date_to');

        $companies = Company::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('mobile_1', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%");
                });
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
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // AJAX request ke liye sirf table return karo
        if (request()->ajax()) {
            return view('admin.companies.index', compact('companies', 'search', 'status', 'dateFrom', 'dateTo'));
        }

        return view('admin.companies.index', compact('companies', 'search', 'status', 'dateFrom', 'dateTo'));
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
            'gst_number' => 'required|string|max:15|unique:companies,gst_number',
            'telephone' => 'nullable|string|max:255|unique:companies,telephone',
            'mobile_1' => 'nullable|string|max:255|unique:companies,mobile_1',
            'mobile_2' => 'nullable|string|max:255|unique:companies,mobile_2',
        ]);

        // Get all data and merge validated fields
        $data = array_merge($request->all(), $validated);
        $data['status'] = (bool) ($request->boolean('status'));
        $data['surcharge_after_dis_yn'] = $request->boolean('surcharge_after_dis_yn');
        $data['add_surcharge_yn'] = $request->boolean('add_surcharge_yn');
        $data['inclusive_yn'] = $request->boolean('inclusive_yn');
        $data['fixed_maximum'] = $request->boolean('fixed_maximum');
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
        $data = $request->all();
        $data['status'] = (bool) ($request->boolean('status'));
        $data['surcharge_after_dis_yn'] = $request->boolean('surcharge_after_dis_yn');
        $data['add_surcharge_yn'] = $request->boolean('add_surcharge_yn');
        $data['inclusive_yn'] = $request->boolean('inclusive_yn');
        $data['fixed_maximum'] = $request->boolean('fixed_maximum');
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
            'gst_number' => 'required|string|max:15',
            'generic' => 'nullable|string|max:255',
            'invoice_print_order' => 'nullable|string|max:255',
            'direct_indirect' => 'nullable|string|max:255',
            'surcharge_after_dis_yn' => 'nullable|boolean',
            'add_surcharge_yn' => 'nullable|boolean',
            'vat_percent' => 'nullable|numeric',
            'inclusive_yn' => 'nullable|boolean',
            'disallow_expiry_after_months' => 'nullable|integer',
            'fixed_maximum' => 'nullable|boolean',
            'discount' => 'nullable|numeric',
            'flag' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
            'country_code' => 'nullable|string|max:10',
            'country_name' => 'nullable|string|max:100',
            'state_code' => 'nullable|string|max:10',
            'state_name' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:255',
        ];
    }
}


