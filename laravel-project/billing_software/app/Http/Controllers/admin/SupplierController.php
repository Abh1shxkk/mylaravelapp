<?php

namespace App\Http\Controllers;

use App\Models\SupplierMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = SupplierMaster::notDeleted()
            ->orderBy('name')
            ->paginate(20);

        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        $states = [
            '09-Uttar Pradesh',
            '27-Uttarakhand', 
            '07-Delhi',
            '10-Bihar',
            '21-Maharashtra',
            // Add more states as needed
        ];

        return view('suppliers.create', compact('states'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:supplier_master,code',
            'email' => 'nullable|email|max:255',
            'mobile' => 'nullable|string|max:20',
            'gst_no' => 'nullable|string|max:20',
            'pan' => 'nullable|string|max:20',
            'opening_balance' => 'nullable|numeric',
            'credit_limit' => 'nullable|numeric',
        ]);

        // Generate code if not provided
        if (empty($validated['code'])) {
            $validated['code'] = SupplierMaster::generateCode();
        }

        $validated['created_by'] = auth()->user()->name ?? 'system';

        SupplierMaster::create($validated);

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier created successfully.');
    }

    public function show(SupplierMaster $supplier)
    {
        return view('suppliers.show', compact('supplier'));
    }

    public function edit(SupplierMaster $supplier)
    {
        $states = [
            '09-Uttar Pradesh',
            '27-Uttarakhand',
            '07-Delhi',
            // Add more states
        ];

        return view('suppliers.edit', compact('supplier', 'states'));
    }

    public function update(Request $request, SupplierMaster $supplier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:supplier_master,code,' . $supplier->supplier_id . ',supplier_id',
            'email' => 'nullable|email|max:255',
            'mobile' => 'nullable|string|max:20',
            'gst_no' => 'nullable|string|max:20',
            'pan' => 'nullable|string|max:20',
            'opening_balance' => 'nullable|numeric',
            'credit_limit' => 'nullable|numeric',
        ]);

        $validated['updated_by'] = auth()->user()->name ?? 'system';

        $supplier->update($validated);

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier updated successfully.');
    }

    public function destroy(SupplierMaster $supplier)
    {
        $supplier->update([
            'is_deleted' => true,
            'deleted_at' => now(),
            'updated_by' => auth()->user()->name ?? 'system'
        ]);

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier deleted successfully.');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');

        $suppliers = SupplierMaster::notDeleted()
            ->where(function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%")
                    ->orWhere('gst_no', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(20);

        return view('suppliers.index', compact('suppliers'));
    }
}