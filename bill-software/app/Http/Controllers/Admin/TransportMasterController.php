<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransportMaster;
use Illuminate\Http\Request;

class TransportMasterController extends Controller
{
    public function index(Request $request)
    {
        $transports = TransportMaster::orderBy('id', 'desc')->paginate(10);
        
        // Handle AJAX requests for infinite scroll
        if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return view('admin.transport-master.index', compact('transports'))->render();
        }
        
        return view('admin.transport-master.index', compact('transports'));
    }

    public function create()
    {
        return view('admin.transport-master.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'alter_code' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'mobile' => 'nullable|string|max:255',
            'gst_no' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'vehicle_no' => 'nullable|string|max:255',
            'trans_mode' => 'nullable|string|max:255',
        ]);

        TransportMaster::create($validated);

        return redirect()->route('admin.transport-master.index')
            ->with('success', 'Transport created successfully.');
    }

    public function show(TransportMaster $transportMaster)
    {
        if (request()->wantsJson() || request()->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json($transportMaster);
        }
        return view('admin.transport-master.show', compact('transportMaster'));
    }

    public function edit(TransportMaster $transportMaster)
    {
        return view('admin.transport-master.edit', compact('transportMaster'));
    }

    public function update(Request $request, TransportMaster $transportMaster)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'alter_code' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'mobile' => 'nullable|string|max:255',
            'gst_no' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'vehicle_no' => 'nullable|string|max:255',
            'trans_mode' => 'nullable|string|max:255',
        ]);

        $transportMaster->update($validated);

        return redirect()->route('admin.transport-master.index')
            ->with('success', 'Transport updated successfully.');
    }

    public function destroy(TransportMaster $transportMaster)
    {
        $transportMaster->delete();

        return redirect()->route('admin.transport-master.index')
            ->with('success', 'Transport deleted successfully.');
    }
}
