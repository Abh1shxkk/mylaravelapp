<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Route::query();

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

        $routes = $query->orderBy('name')->paginate(10);

        // For AJAX requests, return rendered HTML
        if ($request->ajax()) {
            return view('admin.routes.index', compact('routes'))->render();
        }

        return view('admin.routes.index', compact('routes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.routes.create');
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
            Route::create([
                'name' => $request->name,
                'alter_code' => $request->alter_code,
                'status' => $request->status,
            ]);

            return redirect()->route('admin.routes.index')
                           ->with('success', 'Route created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error creating route: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Route $route)
    {
        return view('admin.routes.edit', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Route $route)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'alter_code' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:100',
        ]);

        try {
            $route->update([
                'name' => $request->name,
                'alter_code' => $request->alter_code,
                'status' => $request->status,
            ]);

            return redirect()->route('admin.routes.index')
                           ->with('success', 'Route updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error updating route: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Route $route)
    {
        try {
            // Log the delete attempt
            Log::info('Attempting to permanently delete route: ' . $route->id . ' - ' . $route->name);
            
            // Store name before deletion for log
            $routeName = $route->name;
            
            // Permanently delete from database
            $route->delete();
            
            // Log successful deletion
            Log::info('Route permanently deleted: ' . $route->id . ' - ' . $routeName);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Route deleted successfully!'
                ]);
            }

            return redirect()->route('admin.routes.index')
                           ->with('success', 'Route deleted successfully!');
                           
        } catch (\Exception $e) {
            Log::error('Error deleting route: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting route: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                           ->with('error', 'Error deleting route: ' . $e->getMessage());
        }
    }
}
