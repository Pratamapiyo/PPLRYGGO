<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:tags,slug',
        ]);

        // Generate slug if not provided
        $validated['slug'] = $validated['slug'] ?? \Str::slug($validated['name']);

        Tag::create($validated);

        return redirect()->route('admin.tags-categories.manage')->with('success', 'Tag created successfully.');
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:tags,slug,' . $id,
        ]);

        // Generate slug if not provided
        $validated['slug'] = $validated['slug'] ?? \Str::slug($validated['name']);

        $tag->update($validated);

        return redirect()->route('admin.tags-categories.manage')->with('success', 'Tag updated successfully.');
    }

    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return redirect()->route('admin.tags-categories.manage')->with('success', 'Tag deleted successfully.');
    }
}
