<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GeneralManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = GeneralManager::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $searchField = $request->get('search_field', 'all');
            
            if ($searchField === 'all') {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('code', 'like', "%{$search}%")
                      ->orWhere('address', 'like', "%{$search}%")
                      ->orWhere('telephone', 'like', "%{$search}%")
                      ->orWhere('mobile', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('status', 'like', "%{$search}%")
                      ->orWhere('dc_mgr', 'like', "%{$search}%");
                });
            } else {
                $query->where($searchField, 'like', "%{$search}%");
            }
        }

        // Status filter
        if ($request->filled('status_filter')) {
            $query->where('status', $request->get('status_filter'));
        }

        $generalManagers = $query->orderBy('name')->paginate(10);

        // For AJAX requests, return JSON data for modal
        if ($request->ajax()) {
            // If it's a modal request, return JSON data
            if ($request->get('modal') === 'true') {
                return response()->json($generalManagers->items());
            }
            // Otherwise return rendered HTML for search
            return view('admin.general-managers.index', compact('generalManagers'))->render();
        }

        return view('admin.general-managers.index', compact('generalManagers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.general-managers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'telephone' => 'nullable|string|max:50',
            'mobile' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'status' => 'nullable|string|max:100',
            'dc_mgr' => 'nullable|string|max:255',
        ]);

        try {
            GeneralManager::create([
                'name' => $request->name,
                'code' => $request->code,
                'address' => $request->address,
                'telephone' => $request->telephone,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'status' => $request->status,
                'dc_mgr' => $request->dc_mgr,
            ]);

            return redirect()->route('admin.general-managers.index')
                           ->with('success', 'General Manager created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error creating general manager: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(GeneralManager $generalManager)
    {
        if (request()->ajax()) {
            return response()->json([
                'id' => $generalManager->id,
                'name' => $generalManager->name,
                'code' => $generalManager->code,
                'address' => $generalManager->address,
                'telephone' => $generalManager->telephone,
                'mobile' => $generalManager->mobile,
                'email' => $generalManager->email,
                'status' => $generalManager->status,
                'dc_mgr' => $generalManager->dc_mgr,
                'created_at' => $generalManager->created_at ? $generalManager->created_at->format('M d, Y h:i A') : null,
                'updated_at' => $generalManager->updated_at ? $generalManager->updated_at->format('M d, Y h:i A') : null,
            ]);
        }

        return redirect()->route('admin.general-managers.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GeneralManager $generalManager)
    {
        return view('admin.general-managers.edit', compact('generalManager'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GeneralManager $generalManager)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'telephone' => 'nullable|string|max:50',
            'mobile' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'status' => 'nullable|string|max:100',
            'dc_mgr' => 'nullable|string|max:255',
        ]);

        try {
            $generalManager->update([
                'name' => $request->name,
                'code' => $request->code,
                'address' => $request->address,
                'telephone' => $request->telephone,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'status' => $request->status,
                'dc_mgr' => $request->dc_mgr,
            ]);

            return redirect()->route('admin.general-managers.index')
                           ->with('success', 'General Manager updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error updating general manager: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GeneralManager $generalManager)
    {
        try {
            // Log the delete attempt
            Log::info('Attempting to permanently delete general manager: ' . $generalManager->id . ' - ' . $generalManager->name);
            
            // Store name before deletion for log
            $generalManagerName = $generalManager->name;
            
            // Permanently delete from database
            $generalManager->delete();
            
            // Log successful deletion
            Log::info('General Manager permanently deleted: ' . $generalManager->id . ' - ' . $generalManagerName);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'General Manager deleted successfully!'
                ]);
            }

            return redirect()->route('admin.general-managers.index')
                           ->with('success', 'General Manager deleted successfully!');
                           
        } catch (\Exception $e) {
            Log::error('Error deleting general manager: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting general manager: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                           ->with('error', 'Error deleting general manager: ' . $e->getMessage());
        }
    }
}
