<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarketingManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MarketingManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = MarketingManager::query();

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
                      ->orWhere('gen_mgr', 'like', "%{$search}%");
                });
            } else {
                $query->where($searchField, 'like', "%{$search}%");
            }
        }

        // Status filter
        if ($request->filled('status_filter')) {
            $query->where('status', $request->get('status_filter'));
        }

        $marketingManagers = $query->orderBy('name')->paginate(10);

        // For AJAX requests, return JSON data for modal
        if ($request->ajax()) {
            // If it's a modal request, return JSON data
            if ($request->get('modal') === 'true') {
                return response()->json($marketingManagers->items());
            }
            // Otherwise return rendered HTML for search
            return view('admin.marketing-managers.index', compact('marketingManagers'))->render();
        }

        return view('admin.marketing-managers.index', compact('marketingManagers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.marketing-managers.create');
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
            'gen_mgr' => 'nullable|string|max:255',
        ]);

        try {
            MarketingManager::create([
                'name' => $request->name,
                'code' => $request->code,
                'address' => $request->address,
                'telephone' => $request->telephone,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'status' => $request->status,
                'gen_mgr' => $request->gen_mgr,
            ]);

            return redirect()->route('admin.marketing-managers.index')
                           ->with('success', 'Marketing Manager created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error creating marketing manager: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MarketingManager $marketingManager)
    {
        if (request()->ajax()) {
            return response()->json([
                'id' => $marketingManager->id,
                'name' => $marketingManager->name,
                'code' => $marketingManager->code,
                'address' => $marketingManager->address,
                'telephone' => $marketingManager->telephone,
                'mobile' => $marketingManager->mobile,
                'email' => $marketingManager->email,
                'status' => $marketingManager->status,
                'gen_mgr' => $marketingManager->gen_mgr,
                'created_at' => $marketingManager->created_at ? $marketingManager->created_at->format('M d, Y h:i A') : null,
                'updated_at' => $marketingManager->updated_at ? $marketingManager->updated_at->format('M d, Y h:i A') : null,
            ]);
        }

        return redirect()->route('admin.marketing-managers.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MarketingManager $marketingManager)
    {
        return view('admin.marketing-managers.edit', compact('marketingManager'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MarketingManager $marketingManager)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'telephone' => 'nullable|string|max:50',
            'mobile' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'status' => 'nullable|string|max:100',
            'gen_mgr' => 'nullable|string|max:255',
        ]);

        try {
            $marketingManager->update([
                'name' => $request->name,
                'code' => $request->code,
                'address' => $request->address,
                'telephone' => $request->telephone,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'status' => $request->status,
                'gen_mgr' => $request->gen_mgr,
            ]);

            return redirect()->route('admin.marketing-managers.index')
                           ->with('success', 'Marketing Manager updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error updating marketing manager: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MarketingManager $marketingManager)
    {
        try {
            // Log the delete attempt
            Log::info('Attempting to permanently delete marketing manager: ' . $marketingManager->id . ' - ' . $marketingManager->name);
            
            // Store name before deletion for log
            $marketingManagerName = $marketingManager->name;
            
            // Permanently delete from database
            $marketingManager->delete();
            
            // Log successful deletion
            Log::info('Marketing Manager permanently deleted: ' . $marketingManager->id . ' - ' . $marketingManagerName);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Marketing Manager deleted successfully!'
                ]);
            }

            return redirect()->route('admin.marketing-managers.index')
                           ->with('success', 'Marketing Manager deleted successfully!');
                           
        } catch (\Exception $e) {
            Log::error('Error deleting marketing manager: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting marketing manager: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                           ->with('error', 'Error deleting marketing manager: ' . $e->getMessage());
        }
    }
}
