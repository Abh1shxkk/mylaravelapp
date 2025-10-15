<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HsnCode;
use Illuminate\Http\Request;

class HsnCodeController extends Controller
{
    /**
     * Display a listing of HSN codes
     */
    public function index()
    {
        $search = request('search');
        $status = request('status');
        $all = request('all'); // For AJAX requests to get all records

        $query = HsnCode::query()
            ->when($search, function($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('hsn_code', 'like', "%{$search}%");
                });
            })
            ->when($status !== null && $status !== '', function($query) use ($status) {
                $query->where('is_inactive', $status === 'inactive' ? 1 : 0);
            })
            ->orderByDesc('created_at');

        // If AJAX request with 'all=1', return all active HSN codes as JSON
        if (request()->ajax() && $all == '1') {
            $hsnCodes = $query->where('is_inactive', 0)->get();
            return response()->json($hsnCodes);
        }

        $hsnCodes = $query->paginate(15)->withQueryString();

        return view('admin.hsn-codes.index', compact('hsnCodes', 'search', 'status'));
    }

    /**
     * Show the form for creating a new HSN code
     */
    public function create()
    {
        return view('admin.hsn-codes.create');
    }

    /**
     * Store a newly created HSN code
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'hsn_code' => 'nullable|string|max:255',
            'cgst_percent' => 'nullable|numeric|min:0|max:100',
            'sgst_percent' => 'nullable|numeric|min:0|max:100',
            'igst_percent' => 'nullable|numeric|min:0|max:100',
            'total_gst_percent' => 'nullable|numeric|min:0|max:100',
            'is_inactive' => 'nullable|boolean',
            'is_service' => 'nullable|boolean',
        ]);

        // Convert checkbox values
        $validated['is_inactive'] = $request->has('is_inactive') ? true : false;
        $validated['is_service'] = $request->has('is_service') ? true : false;

        HsnCode::create($validated);

        return redirect()->route('admin.hsn-codes.index')
            ->with('success', 'HSN Code created successfully');
    }

    /**
     * Show the form for editing the specified HSN code
     */
    public function edit(HsnCode $hsnCode)
    {
        return view('admin.hsn-codes.edit', compact('hsnCode'));
    }

    /**
     * Update the specified HSN code
     */
    public function update(Request $request, HsnCode $hsnCode)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'hsn_code' => 'nullable|string|max:255',
            'cgst_percent' => 'nullable|numeric|min:0|max:100',
            'sgst_percent' => 'nullable|numeric|min:0|max:100',
            'igst_percent' => 'nullable|numeric|min:0|max:100',
            'total_gst_percent' => 'nullable|numeric|min:0|max:100',
            'is_inactive' => 'nullable|boolean',
            'is_service' => 'nullable|boolean',
        ]);

        // Convert checkbox values
        $validated['is_inactive'] = $request->has('is_inactive') ? true : false;
        $validated['is_service'] = $request->has('is_service') ? true : false;

        $hsnCode->update($validated);

        return redirect()->route('admin.hsn-codes.index')
            ->with('success', 'HSN Code updated successfully');
    }

    /**
     * Remove the specified HSN code
     */
    public function destroy(HsnCode $hsnCode)
    {
        $hsnCode->delete();
        
        return back()->with('success', 'HSN Code deleted successfully');
    }
}
