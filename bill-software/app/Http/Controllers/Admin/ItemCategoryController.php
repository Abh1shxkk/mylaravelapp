<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ItemCategory;
use Illuminate\Http\Request;

class ItemCategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = ItemCategory::orderBy('id', 'desc')->paginate(10);
        
        // Handle AJAX requests for infinite scroll
        if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return view('admin.item-category.index', compact('categories'))->render();
        }
        
        return view('admin.item-category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.item-category.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'alter_code' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
        ]);

        ItemCategory::create($validated);

        return redirect()->route('admin.item-category.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(ItemCategory $itemCategory)
    {
        return view('admin.item-category.edit', compact('itemCategory'));
    }

    public function update(Request $request, ItemCategory $itemCategory)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'alter_code' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
        ]);

        $itemCategory->update($validated);

        return redirect()->route('admin.item-category.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(ItemCategory $itemCategory)
    {
        $itemCategory->delete();

        return redirect()->route('admin.item-category.index')
            ->with('success', 'Category deleted successfully.');
    }
}
