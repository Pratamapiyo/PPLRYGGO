<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $newsItems = News::with(['categories', 'author'])->latest()->get();
        $recentNews = News::latest()->take(5)->get();
        $categories = Category::withCount('news')->get();
        $tags = Tag::all();

        return view('econews', compact('newsItems', 'recentNews', 'categories', 'tags'));
    }

    public function show($id)
    {
        $news = News::with(['categories', 'tags', 'author'])->findOrFail($id);

        // Fetch the two latest news items for related news
        $relatedNews = News::where('id', '!=', $news->id)->latest()->take(2)->get();

        return view('news-detail', compact('news', 'relatedNews'));
    }

    public function manage()
    {
        $newsItems = News::with('author')->latest()->get(); // Fetch news with author details
        return view('Admin-EcoNews', compact('newsItems')); // Pass $newsItems to the view
    }

    public function edit($id)
    {
        $news = News::with(['categories', 'tags'])->findOrFail($id); // Fetch the news with related data
        $categories = Category::all(); // Fetch all categories
        $tags = Tag::all(); // Fetch all tags
        return view('Admin-EcoNews-Edit', compact('news', 'categories', 'tags')); // Pass the data to the view
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        // Generate slug if not provided
        $validatedData['slug'] = $validatedData['slug'] ?? \Str::slug($validatedData['title']);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            if ($news->image && \Storage::exists('public/' . $news->image)) {
                \Storage::delete('public/' . $news->image);
            }
            $imagePath = $request->file('image')->store('news_images', 'public');
            $validatedData['image'] = $imagePath;
        }

        // Update the news record
        $news->update(array_filter([
            'title' => $validatedData['title'],
            'body' => $validatedData['content'] ?? $news->body,
            'image' => $validatedData['image'] ?? $news->image,
            'slug' => $validatedData['slug'],
        ]));

        // Sync categories and tags
        $news->categories()->sync($validatedData['categories'] ?? []);
        $news->tags()->sync($validatedData['tags'] ?? []);

        return redirect()->route('admin.econews.manage')->with('success', 'News updated successfully.');
    }
}
