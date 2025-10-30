<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralReminder;
use Illuminate\Http\Request;

class GeneralReminderController extends Controller
{
    public function index(Request $request)
    {
        $reminders = GeneralReminder::orderBy('id', 'desc')->paginate(10);
        
        // Handle AJAX requests for infinite scroll
        if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return view('admin.general-reminders.index', compact('reminders'))->render();
        }
        
        return view('admin.general-reminders.index', compact('reminders'));
    }

    public function create()
    {
        return view('admin.general-reminders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'code' => 'nullable|string|max:255',
            'due_date' => 'nullable|date',
            'status' => 'nullable|string|max:255',
        ]);

        GeneralReminder::create($validated);

        return redirect()->route('admin.general-reminders.index')
            ->with('success', 'Reminder created successfully.');
    }

    public function edit(GeneralReminder $generalReminder)
    {
        return view('admin.general-reminders.edit', compact('generalReminder'));
    }

    public function update(Request $request, GeneralReminder $generalReminder)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'code' => 'nullable|string|max:255',
            'due_date' => 'nullable|date',
            'status' => 'nullable|string|max:255',
        ]);

        $generalReminder->update($validated);

        return redirect()->route('admin.general-reminders.index')
            ->with('success', 'Reminder updated successfully.');
    }

    public function destroy(GeneralReminder $generalReminder)
    {
        $generalReminder->delete();

        return redirect()->route('admin.general-reminders.index')
            ->with('success', 'Reminder deleted successfully.');
    }
}
