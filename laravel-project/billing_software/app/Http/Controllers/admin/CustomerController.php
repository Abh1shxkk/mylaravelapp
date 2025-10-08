<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::where('is_deleted', false)->latest()->get();
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.customers.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate fields from the form (including additional identifiers and controls)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'tax_registration' => 'nullable|string|max:20',
            'pin_code' => 'nullable|string|max:10',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'telephone_office' => 'nullable|string|max:20',
            'telephone_residence' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'contact_person1' => 'nullable|string|max:255',
            'mobile_contact1' => 'nullable|string|max:20',
            'contact_person2' => 'nullable|string|max:255',
            'mobile_contact2' => 'nullable|string|max:20',
            'fax_number' => 'nullable|string|max:20',
            'opening_balance' => 'nullable|numeric',
            'balance_type' => 'nullable|string|in:D,C',
            'local_central' => 'nullable|string|in:L,C',
            'credit_days' => 'nullable|integer',
            'birth_day' => 'nullable|date',
            'status' => 'nullable|string|max:50',
            'dl_expiry' => 'nullable|date',
            'dl_number1' => 'nullable|string|max:50',
            'food_license' => 'nullable|string|max:100',
            'cst_number' => 'nullable|string|max:50',
            'tin_number' => 'nullable|string|max:50',
            'pan_number' => 'nullable|string|max:20',
            'sales_man_code' => 'nullable|string|max:10',
            'area_code' => 'nullable|string|max:10',
            'route_code' => 'nullable|string|max:10',
            'state_code' => 'nullable|string|max:10',
            'business_type' => 'nullable|string|in:W,R,I,D,O',
            'description' => 'nullable|string',
            'order_required' => 'nullable|string|in:Y,N',
            // additional fields to mirror store()
            'flag' => 'nullable|string|max:50',
            'invoice_export' => 'nullable|string|in:Y,N',
            'due_list_sequence' => 'nullable|integer',
            'tan_number' => 'nullable|string|max:50',
            'msme_license' => 'nullable|string|max:100',
            'dl_number' => 'nullable|string|max:50',
            'aadhar_number' => 'nullable|string|max:20',
            'registration_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'day_value' => 'nullable|integer',
            'cst_registration' => 'nullable|string|max:20',
            'gst_name' => 'nullable|string|max:255',
            'state_code_gst' => 'nullable|string|max:5',
            'registration_status' => 'nullable|string|in:Registered,Unregistered,Composite',
        ]);

        try {
            // Persist only the fields from the form
            Customer::create($validated);
            
            return redirect()->route('admin.customers.index')
                ->with('success', 'Customer created successfully.');
                
        } catch (\Exception $e) {
            Log::error('Error creating customer', ['message' => $e->getMessage(), 'data' => $request->all()]);
            
            return redirect()->back()
                ->with('error', 'Error creating customer: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('admin.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'tax_registration' => 'nullable|string|max:20',
            'pin_code' => 'nullable|string|max:10',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'telephone_office' => 'nullable|string|max:20',
            'telephone_residence' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'contact_person1' => 'nullable|string|max:255',
            'mobile_contact1' => 'nullable|string|max:20',
            'contact_person2' => 'nullable|string|max:255',
            'mobile_contact2' => 'nullable|string|max:20',
            'fax_number' => 'nullable|string|max:20',
            'opening_balance' => 'nullable|numeric',
            'balance_type' => 'nullable|string|in:D,C',
            'local_central' => 'nullable|string|in:L,C',
            'credit_days' => 'nullable|integer',
            'birth_day' => 'nullable|date',
            'status' => 'nullable|string|max:50',
            'dl_expiry' => 'nullable|date',
            'dl_number1' => 'nullable|string|max:50',
            'food_license' => 'nullable|string|max:100',
            'cst_number' => 'nullable|string|max:50',
            'tin_number' => 'nullable|string|max:50',
            'pan_number' => 'nullable|string|max:20',
            'sales_man_code' => 'nullable|string|max:10',
            'registration_status' => 'nullable|string|in:Registered,Unregistered,Composite',
        ]);

        try {
            $customer->update($validated);
            
            return redirect()->route('admin.customers.index')
                ->with('success', 'Customer updated successfully.');
                
        } catch (\Exception $e) {
            Log::error('Error updating customer', ['message' => $e->getMessage(), 'data' => $request->all(), 'id' => $customer->id]);
            
            return redirect()->back()
                ->with('error', 'Error updating customer: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        try {
            $customer->update(['is_deleted' => true, 'deleted_at' => now()]);
            
            return redirect()->route('admin.customers.index')
                ->with('success', 'Customer deleted successfully.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting customer: ' . $e->getMessage());
        }
    }
}