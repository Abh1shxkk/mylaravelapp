<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DivisionalManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DivisionalManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DivisionalManager::query();

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
                      ->orWhere('c_mgr', 'like', "%{$search}%");
                });
            } else {
                $query->where($searchField, 'like', "%{$search}%");
            }
        }

        // Status filter
        if ($request->filled('status_filter')) {
            $query->where('status', $request->get('status_filter'));
        }

        $divisionalManagers = $query->orderBy('name')->paginate(10);

        // For AJAX requests, return JSON data for modal
        if ($request->ajax()) {
            // If it's a modal request, return JSON data
            if ($request->get('modal') === 'true') {
                return response()->json($divisionalManagers->items());
            }
            // Otherwise return rendered HTML for search
            return view('admin.divisional-managers.index', compact('divisionalManagers'))->render();
        }

        return view('admin.divisional-managers.index', compact('divisionalManagers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.divisional-managers.create');
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
            'c_mgr' => 'nullable|string|max:255',
        ]);

        try {
            DivisionalManager::create([
                'name' => $request->name,
                'code' => $request->code,
                'address' => $request->address,
                'telephone' => $request->telephone,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'status' => $request->status,
                'c_mgr' => $request->c_mgr,
            ]);

            return redirect()->route('admin.divisional-managers.index')
                           ->with('success', 'Divisional Manager created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error creating divisional manager: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DivisionalManager $divisionalManager)
    {
        if (request()->ajax()) {
            return response()->json([
                'id' => $divisionalManager->id,
                'name' => $divisionalManager->name,
                'code' => $divisionalManager->code,
                'address' => $divisionalManager->address,
                'telephone' => $divisionalManager->telephone,
                'mobile' => $divisionalManager->mobile,
                'email' => $divisionalManager->email,
                'status' => $divisionalManager->status,
                'c_mgr' => $divisionalManager->c_mgr,
                'created_at' => $divisionalManager->created_at ? $divisionalManager->created_at->format('M d, Y h:i A') : null,
                'updated_at' => $divisionalManager->updated_at ? $divisionalManager->updated_at->format('M d, Y h:i A') : null,
            ]);
        }

        return redirect()->route('admin.divisional-managers.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DivisionalManager $divisionalManager)
    {
        return view('admin.divisional-managers.edit', compact('divisionalManager'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DivisionalManager $divisionalManager)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'telephone' => 'nullable|string|max:50',
            'mobile' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'status' => 'nullable|string|max:100',
            'c_mgr' => 'nullable|string|max:255',
        ]);

        try {
            $divisionalManager->update([
                'name' => $request->name,
                'code' => $request->code,
                'address' => $request->address,
                'telephone' => $request->telephone,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'status' => $request->status,
                'c_mgr' => $request->c_mgr,
            ]);

            return redirect()->route('admin.divisional-managers.index')
                           ->with('success', 'Divisional Manager updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error updating divisional manager: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DivisionalManager $divisionalManager)
    {
        try {
            // Log the delete attempt
            Log::info('Attempting to permanently delete divisional manager: ' . $divisionalManager->id . ' - ' . $divisionalManager->name);
            
            // Store name before deletion for log
            $divisionalManagerName = $divisionalManager->name;
            
            // Permanently delete from database
            $divisionalManager->delete();
            
            // Log successful deletion
            Log::info('Divisional Manager permanently deleted: ' . $divisionalManager->id . ' - ' . $divisionalManagerName);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Divisional Manager deleted successfully!'
                ]);
            }

            return redirect()->route('admin.divisional-managers.index')
                           ->with('success', 'Divisional Manager deleted successfully!');
                           
        } catch (\Exception $e) {
            Log::error('Error deleting divisional manager: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting divisional manager: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                           ->with('error', 'Error deleting divisional manager: ' . $e->getMessage());
        }
    }
}
