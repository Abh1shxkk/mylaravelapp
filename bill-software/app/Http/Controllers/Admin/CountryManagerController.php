<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CountryManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CountryManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CountryManager::query();

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

        $countryManagers = $query->orderBy('name')->paginate(10);

        // For AJAX requests, return JSON data for modal
        if ($request->ajax()) {
            // If it's a modal request, return JSON data
            if ($request->get('modal') === 'true') {
                return response()->json($countryManagers->items());
            }
            // Otherwise return rendered HTML for search
            return view('admin.country-managers.index', compact('countryManagers'))->render();
        }

        return view('admin.country-managers.index', compact('countryManagers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.country-managers.create');
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
        ]);

        try {
            CountryManager::create([
                'name' => $request->name,
                'code' => $request->code,
                'address' => $request->address,
                'telephone' => $request->telephone,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'status' => $request->status,
            ]);

            return redirect()->route('admin.country-managers.index')
                           ->with('success', 'Country Manager created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error creating country manager: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CountryManager $countryManager)
    {
        if (request()->ajax()) {
            return response()->json([
                'id' => $countryManager->id,
                'name' => $countryManager->name,
                'code' => $countryManager->code,
                'address' => $countryManager->address,
                'telephone' => $countryManager->telephone,
                'mobile' => $countryManager->mobile,
                'email' => $countryManager->email,
                'status' => $countryManager->status,
                'created_at' => $countryManager->created_at ? $countryManager->created_at->format('M d, Y h:i A') : null,
                'updated_at' => $countryManager->updated_at ? $countryManager->updated_at->format('M d, Y h:i A') : null,
            ]);
        }

        return redirect()->route('admin.country-managers.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CountryManager $countryManager)
    {
        return view('admin.country-managers.edit', compact('countryManager'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CountryManager $countryManager)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'telephone' => 'nullable|string|max:50',
            'mobile' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'status' => 'nullable|string|max:100',
        ]);

        try {
            $countryManager->update([
                'name' => $request->name,
                'code' => $request->code,
                'address' => $request->address,
                'telephone' => $request->telephone,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'status' => $request->status,
            ]);

            return redirect()->route('admin.country-managers.index')
                           ->with('success', 'Country Manager updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error updating country manager: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CountryManager $countryManager)
    {
        try {
            // Log the delete attempt
            Log::info('Attempting to permanently delete country manager: ' . $countryManager->id . ' - ' . $countryManager->name);
            
            // Store name before deletion for log
            $countryManagerName = $countryManager->name;
            
            // Permanently delete from database
            $countryManager->delete();
            
            // Log successful deletion
            Log::info('Country Manager permanently deleted: ' . $countryManager->id . ' - ' . $countryManagerName);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Country Manager deleted successfully!'
                ]);
            }

            return redirect()->route('admin.country-managers.index')
                           ->with('success', 'Country Manager deleted successfully!');
                           
        } catch (\Exception $e) {
            Log::error('Error deleting country manager: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting country manager: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                           ->with('error', 'Error deleting country manager: ' . $e->getMessage());
        }
    }
}
