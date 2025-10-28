<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalesMan;
use Illuminate\Http\Request;

class SalesManController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SalesMan::where('is_deleted', '!=', 1);

        // Handle search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $searchField = $request->get('search_field', 'all');

            if ($searchField === 'all') {
                $query->where(function($q) use ($searchTerm) {
                    $q->where('name', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('code', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('mobile', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('telephone', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('city', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('area_mgr_name', 'LIKE', "%{$searchTerm}%");
                });
            } else {
                $query->where($searchField, 'LIKE', "%{$searchTerm}%");
            }
        }

        $salesMen = $query->orderBy('created_at', 'desc')->paginate(10);

        // Handle AJAX requests
        if ($request->ajax()) {
            return view('admin.sales-men.index', compact('salesMen'))->render();
        }
            
        return view('admin.sales-men.index', compact('salesMen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sales-men.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:sales_men,code',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'mobile' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'pin' => 'nullable|string|max:10',
            'sales_type' => 'nullable|in:S,C,B',
            'delivery_type' => 'nullable|in:S,D,B',
            'area_mgr_code' => 'nullable|string|max:255',
            'area_mgr_name' => 'nullable|string|max:255',
            'monthly_target' => 'nullable|numeric|min:0',
            'status' => 'nullable|string|max:255',
        ]);

        $validated['created_date'] = now();
        $validated['modified_date'] = now();

        SalesMan::create($validated);

        return redirect()->route('admin.sales-men.index')
            ->with('success', 'Sales Man created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SalesMan $salesMan, Request $request)
    {
        // Handle AJAX requests for modal
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $salesMan->id,
                    'code' => $salesMan->code,
                    'name' => $salesMan->name,
                    'email' => $salesMan->email,
                    'mobile' => $salesMan->mobile,
                    'telephone' => $salesMan->telephone,
                    'address' => $salesMan->address,
                    'city' => $salesMan->city,
                    'pin' => $salesMan->pin,
                    'sales_type' => $salesMan->sales_type,
                    'delivery_type' => $salesMan->delivery_type,
                    'area_mgr_code' => $salesMan->area_mgr_code,
                    'area_mgr_name' => $salesMan->area_mgr_name,
                    'monthly_target' => $salesMan->monthly_target,
                    'status' => $salesMan->status,
                    'created_at' => $salesMan->created_at ? $salesMan->created_at->format('d M Y, h:i A') : null,
                    'updated_at' => $salesMan->updated_at ? $salesMan->updated_at->format('d M Y, h:i A') : null,
                ]
            ]);
        }

        // For non-AJAX requests, redirect to index (since we removed the show blade)
        return redirect()->route('admin.sales-men.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesMan $salesMan)
    {
        return view('admin.sales-men.edit', compact('salesMan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesMan $salesMan)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:sales_men,code,' . $salesMan->id,
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'mobile' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'pin' => 'nullable|string|max:10',
            'sales_type' => 'nullable|in:S,C,B',
            'delivery_type' => 'nullable|in:S,D,B',
            'area_mgr_code' => 'nullable|string|max:255',
            'area_mgr_name' => 'nullable|string|max:255',
            'monthly_target' => 'nullable|numeric|min:0',
            'status' => 'nullable|string|max:255',
        ]);

        $validated['modified_date'] = now();

        $salesMan->update($validated);

        return redirect()->route('admin.sales-men.index')
            ->with('success', 'Sales Man updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesMan $salesMan)
    {
        // Soft delete by setting is_deleted = 1
        $salesMan->update([
            'is_deleted' => 1,
            'modified_date' => now()
        ]);

        return redirect()->route('admin.sales-men.index')
            ->with('success', 'Sales Man deleted successfully.');
    }
}
