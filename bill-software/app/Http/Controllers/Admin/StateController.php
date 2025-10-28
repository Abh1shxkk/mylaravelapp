<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = State::query();

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

        $states = $query->orderBy('name')->paginate(10);

        // For AJAX requests, return rendered HTML
        if ($request->ajax()) {
            return view('admin.states.index', compact('states'))->render();
        }

        return view('admin.states.index', compact('states'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.states.create');
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
            State::create([
                'name' => $request->name,
                'alter_code' => $request->alter_code,
                'status' => $request->status,
            ]);

            return redirect()->route('admin.states.index')
                           ->with('success', 'State created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error creating state: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(State $state)
    {
        return view('admin.states.edit', compact('state'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, State $state)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'alter_code' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:100',
        ]);

        try {
            $state->update([
                'name' => $request->name,
                'alter_code' => $request->alter_code,
                'status' => $request->status,
            ]);

            return redirect()->route('admin.states.index')
                           ->with('success', 'State updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error updating state: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(State $state)
    {
        try {
            // Log the delete attempt
            Log::info('Attempting to permanently delete state: ' . $state->id . ' - ' . $state->name);
            
            // Store name before deletion for log
            $stateName = $state->name;
            
            // Permanently delete from database
            $state->delete();
            
            // Log successful deletion
            Log::info('State permanently deleted: ' . $state->id . ' - ' . $stateName);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'State deleted successfully!'
                ]);
            }

            return redirect()->route('admin.states.index')
                           ->with('success', 'State deleted successfully!');
                           
        } catch (\Exception $e) {
            Log::error('Error deleting state: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting state: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                           ->with('error', 'Error deleting state: ' . $e->getMessage());
        }
    }
}
