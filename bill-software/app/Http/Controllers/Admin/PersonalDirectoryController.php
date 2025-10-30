<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PersonalDirectory;
use Illuminate\Http\Request;

class PersonalDirectoryController extends Controller
{
    public function index(Request $request)
    {
        $entries = PersonalDirectory::orderBy('id', 'desc')->paginate(10);
        
        // Handle AJAX requests for infinite scroll
        if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return view('admin.personal-directory.index', compact('entries'))->render();
        }
        
        return view('admin.personal-directory.index', compact('entries'));
    }

    public function create()
    {
        return view('admin.personal-directory.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'alt_code' => 'nullable|string|max:255',
            'address_office' => 'nullable|string',
            'address_residence' => 'nullable|string',
            'tel_office' => 'nullable|string|max:255',
            'tel_residence' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:255',
            'fax' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'status' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'birthday' => 'nullable|date',
            'anniversary' => 'nullable|date',
            'spouse' => 'nullable|string|max:255',
            'spouse_dob' => 'nullable|date',
            'child_1' => 'nullable|string|max:255',
            'child_1_dob' => 'nullable|date',
            'child_2' => 'nullable|string|max:255',
            'child_2_dob' => 'nullable|date',
        ]);

        PersonalDirectory::create($validated);

        return redirect()->route('admin.personal-directory.index')
            ->with('success', 'Entry created successfully.');
    }

    public function show(PersonalDirectory $personalDirectory)
    {
        if (request()->wantsJson() || request()->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json($personalDirectory);
        }
        return view('admin.personal-directory.show', compact('personalDirectory'));
    }

    public function edit(PersonalDirectory $personalDirectory)
    {
        return view('admin.personal-directory.edit', compact('personalDirectory'));
    }

    public function update(Request $request, PersonalDirectory $personalDirectory)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'alt_code' => 'nullable|string|max:255',
            'address_office' => 'nullable|string',
            'address_residence' => 'nullable|string',
            'tel_office' => 'nullable|string|max:255',
            'tel_residence' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:255',
            'fax' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'status' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'birthday' => 'nullable|date',
            'anniversary' => 'nullable|date',
            'spouse' => 'nullable|string|max:255',
            'spouse_dob' => 'nullable|date',
            'child_1' => 'nullable|string|max:255',
            'child_1_dob' => 'nullable|date',
            'child_2' => 'nullable|string|max:255',
            'child_2_dob' => 'nullable|date',
        ]);

        $personalDirectory->update($validated);

        return redirect()->route('admin.personal-directory.index')
            ->with('success', 'Entry updated successfully.');
    }

    public function destroy(PersonalDirectory $personalDirectory)
    {
        $personalDirectory->delete();

        return redirect()->route('admin.personal-directory.index')
            ->with('success', 'Entry deleted successfully.');
    }
}
