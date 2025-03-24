<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all(); // Fetch all products from the database
        return view('store', compact('products')); // Pass products to the view
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = new Product($request->only(['name', 'description', 'points', 'stock']));

        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('product_images', 'public');
        }

        $product->save();

        return redirect()->route('admin.store.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product->fill($request->only(['name', 'description', 'points', 'stock']));

        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('product_images', 'public');
        }

        $product->save();

        return redirect()->route('admin.store.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.store.index')->with('success', 'Product deleted successfully.');
    }

    public function redeem(Request $request, Product $product)
    {
        $user = Auth::user();

        if ($user->points < $product->points) {
            return response()->json(['message' => 'Insufficient points.'], 400);
        }

        if ($product->stock <= 0) {
            return response()->json(['message' => 'Product out of stock.'], 400);
        }

        $user->points -= $product->points;
        $user->save();

        $product->stock -= 1;
        $product->save();

        Transaction::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'points_used' => $product->points,
            'status' => 'Completed',
        ]);

        return response()->json(['message' => 'Product redeemed successfully.']);
    }

    public function adminIndex()
    {
        $products = Product::all();
        return view('Admin-store', compact('products'));
    }
}
