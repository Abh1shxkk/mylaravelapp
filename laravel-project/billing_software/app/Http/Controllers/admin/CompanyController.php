<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::where('is_deleted', false)->latest()->get();
        return view('admin.companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'email' => 'nullable|email',
            'contact_person_1' => 'nullable|string|max:255',
            'contact_person_2' => 'nullable|string|max:255',
            'website' => 'nullable|url',
            'mobile_1' => 'nullable|string|max:20',
            'mobile_2' => 'nullable|string|max:20',
            'telephone' => 'nullable|string|max:20',
            'alter_code' => 'nullable|string|max:255',
            'short_name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'pur_sc' => 'nullable|numeric',
            'sale_sc' => 'nullable|numeric',
            'pur_tax' => 'nullable|numeric',
            'sale_tax' => 'nullable|numeric',
            'dis_on_sale_percent' => 'nullable|numeric',
            'min_gp' => 'nullable|numeric',
            'vat_percent' => 'nullable|numeric',
            'fixed_maximum' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'invoice_print_order' => 'nullable|integer',
            'disallow_expiry_after_months' => 'nullable|integer',
            'flag' => 'nullable|integer',
            // New fields added from form
            'expiry' => 'nullable|date',
            'generic' => 'nullable|string|in:Y,N',
            'direct_indirect' => 'nullable|string|in:D,I',
            'surcharge_after_dis_yn' => 'nullable|string|in:Y,N',
            'add_surcharge_yn' => 'nullable|string|in:Y,N',
            'inclusive_yn' => 'nullable|string|in:Y,N',
            'status' => 'nullable|string|in:Active,Inactive',
        ]);

        try {
            Company::create($request->all());
            
            return redirect()->route('admin.companies.index')
                ->with('success', 'Company created successfully.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating company: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return view('admin.companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        return view('admin.companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'email' => 'nullable|email',
            'contact_person_1' => 'nullable|string|max:255',
            'contact_person_2' => 'nullable|string|max:255',
            'website' => 'nullable|url',
            'mobile_1' => 'nullable|string|max:20',
            'mobile_2' => 'nullable|string|max:20',
            'telephone' => 'nullable|string|max:20',
            'alter_code' => 'nullable|string|max:255',
            'short_name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'pur_sc' => 'nullable|numeric',
            'sale_sc' => 'nullable|numeric',
            'pur_tax' => 'nullable|numeric',
            'sale_tax' => 'nullable|numeric',
            'dis_on_sale_percent' => 'nullable|numeric',
            'min_gp' => 'nullable|numeric',
            'vat_percent' => 'nullable|numeric',
            'fixed_maximum' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'invoice_print_order' => 'nullable|integer',
            'disallow_expiry_after_months' => 'nullable|integer',
            'flag' => 'nullable|integer',
            // New fields added from form
            'expiry' => 'nullable|date',
            'generic' => 'nullable|string|in:Y,N',
            'direct_indirect' => 'nullable|string|in:D,I',
            'surcharge_after_dis_yn' => 'nullable|string|in:Y,N',
            'add_surcharge_yn' => 'nullable|string|in:Y,N',
            'inclusive_yn' => 'nullable|string|in:Y,N',
            'status' => 'nullable|string|in:Active,Inactive',
        ]);

        try {
            $company->update($request->all());
            
            return redirect()->route('admin.companies.index')
                ->with('success', 'Company updated successfully.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating company: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        try {
            $company->update(['is_deleted' => true, 'deleted_at' => now()]);
            
            return redirect()->route('admin.companies.index')
                ->with('success', 'Company deleted successfully.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting company: ' . $e->getMessage());
        }
    }
}