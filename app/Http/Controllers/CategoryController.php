<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
        ]);

        // Generate slug if not provided
        $validated['slug'] = $validated['slug'] ?? \Str::slug($validated['name']);

        Category::create($validated);

        return redirect()->route('admin.tags-categories.manage')->with('success', 'Category created successfully.');
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $id,
        ]);

        // Generate slug if not provided
        $validated['slug'] = $validated['slug'] ?? \Str::slug($validated['name']);

        $category->update($validated);

        return redirect()->route('admin.tags-categories.manage')->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.tags-categories.manage')->with('success', 'Category deleted successfully.');
    }
}
