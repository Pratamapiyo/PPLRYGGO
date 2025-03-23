<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Category;
use App\Models\Tag;

class EcoNewsController extends Controller
{
    public function index()
    {
        $newsItems = News::all();
        $categories = Category::withCount('news')->get();
        $tags = Tag::all();
        $recentNews = News::latest()->take(3)->get();

        return view('econews', compact('newsItems', 'categories', 'tags', 'recentNews'));
    }

    public function show($id)
    {
        $news = News::findOrFail($id);
        $categories = Category::withCount('news')->get();
        $tags = Tag::all();
        $recentNews = News::latest()->take(5)->get();

        return view('econews-detail', compact('news', 'categories', 'tags', 'recentNews'));
    }

    public function filterByCategory($id)
    {
        $newsItems = News::whereHas('categories', function ($query) use ($id) {
            $query->where('id', $id);
        })->get();

        $categories = Category::withCount('news')->get();
        $tags = Tag::all();
        $recentNews = News::latest()->take(3)->get();
        $selectedCategory = Category::find($id);

        return view('econews', compact('newsItems', 'categories', 'tags', 'recentNews', 'selectedCategory'));
    }

    public function filterByTag($id)
    {
        $newsItems = News::whereHas('tags', function ($query) use ($id) {
            $query->where('id', $id);
        })->get();

        $categories = Category::withCount('news')->get();
        $tags = Tag::all();
        $recentNews = News::latest()->take(3)->get();
        $selectedTag = Tag::find($id);

        return view('econews', compact('newsItems', 'categories', 'tags', 'recentNews', 'selectedTag'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('Admin-EcoNews-Add', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:news,slug',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
            'categories' => 'nullable|array',
            'tags' => 'nullable|array',
        ]);

        $news = new News();
        $news->title = $validated['title'];
        $news->slug = $validated['slug'] ?? \Str::slug($validated['title'], '-');
        $news->slug = $this->ensureUniqueSlug($news->slug);
        $news->body = $validated['content'];
        $news->author_id = auth()->id();
        $news->published_at = now();

        if ($request->hasFile('image')) {
            $news->image = $request->file('image')->store('news_images', 'public');
        }

        $news->save();

        if (!empty($validated['categories'])) {
            $news->categories()->sync($validated['categories']);
        }

        if (!empty($validated['tags'])) {
            $news->tags()->sync($validated['tags']);
        }

        return redirect()->route('admin.econews.manage')->with('success', 'News added successfully.');
    }

    private function ensureUniqueSlug($slug)
    {
        $originalSlug = $slug;
        $counter = 1;

        while (News::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}