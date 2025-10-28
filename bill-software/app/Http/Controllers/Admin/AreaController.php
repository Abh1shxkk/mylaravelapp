<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Area::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $searchField = $request->get('search_field', 'all');
            
            if ($searchField === 'all') {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('alter_code', 'like', "%{$search}%")
                      ->orWhere('status', 'like', "%{$search}%");
                });
            } else {
                $query->where($searchField, 'like', "%{$search}%");
            }
        }

        // Status filter
        if ($request->filled('status_filter')) {
            $query->where('status', $request->get('status_filter'));
        }

        $areas = $query->orderBy('name')->paginate(10);

        // For AJAX requests, return rendered HTML
        if ($request->ajax()) {
            return view('admin.areas.index', compact('areas'))->render();
        }

        return view('admin.areas.index', compact('areas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.areas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'alter_code' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:100',
        ]);

        try {
            Area::create([
                'name' => $request->name,
                'alter_code' => $request->alter_code,
                'status' => $request->status,
            ]);

            return redirect()->route('admin.areas.index')
                           ->with('success', 'Area created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error creating area: ' . $e->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Area $area)
    {
        return view('admin.areas.edit', compact('area'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Area $area)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'alter_code' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:100',
        ]);

        try {
            $area->update([
                'name' => $request->name,
                'alter_code' => $request->alter_code,
                'status' => $request->status,
            ]);

            return redirect()->route('admin.areas.index')
                           ->with('success', 'Area updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error updating area: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Area $area)
    {
        try {
            // Log the delete attempt
            Log::info('Attempting to permanently delete area: ' . $area->id . ' - ' . $area->name);
            
            // Store name before deletion for log
            $areaName = $area->name;
            
            // Permanently delete from database
            $area->delete();
            
            // Log successful deletion
            Log::info('Area permanently deleted: ' . $area->id . ' - ' . $areaName);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Area deleted successfully!'
                ]);
            }

            return redirect()->route('admin.areas.index')
                           ->with('success', 'Area deleted successfully!');
                           
        } catch (\Exception $e) {
            Log::error('Error deleting area: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting area: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                           ->with('error', 'Error deleting area: ' . $e->getMessage());
        }
    }
}