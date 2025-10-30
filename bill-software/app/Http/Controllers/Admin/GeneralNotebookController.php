<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralNotebook;
use Illuminate\Http\Request;

class GeneralNotebookController extends Controller
{
    public function index()
    {
        $notebooks = GeneralNotebook::paginate(15);
        return view('admin.general-notebook.index', compact('notebooks'));
    }

    public function create()
    {
        return view('admin.general-notebook.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Add validation rules as you specify fields
        ]);

        GeneralNotebook::create($validated);

        return redirect()->route('admin.general-notebook.index')
            ->with('success', 'Note created successfully.');
    }

    public function show(GeneralNotebook $generalNotebook)
    {
        return view('admin.general-notebook.show', compact('generalNotebook'));
    }

    public function edit(GeneralNotebook $generalNotebook)
    {
        return view('admin.general-notebook.edit', compact('generalNotebook'));
    }

    public function update(Request $request, GeneralNotebook $generalNotebook)
    {
        $validated = $request->validate([
            // Add validation rules as you specify fields
        ]);

        $generalNotebook->update($validated);

        return redirect()->route('admin.general-notebook.index')
            ->with('success', 'Note updated successfully.');
    }

    public function destroy(GeneralNotebook $generalNotebook)
    {
        $generalNotebook->delete();

        return redirect()->route('admin.general-notebook.index')
            ->with('success', 'Note deleted successfully.');
    }
}
