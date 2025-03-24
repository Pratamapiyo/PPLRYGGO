<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Models\VendorProduct; // Import VendorProduct model
use App\Models\VendorTransaction; // Import the new model

class ProductController extends Controller
{
    public function index()
    {
        $products = \App\Models\VendorProduct::all(); // Fetch all vendor products
        return view('store', compact('products')); // Pass vendor products to the view
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

    public function redeem(Request $request, VendorProduct $vendorProduct)
    {
        try {
            $user = Auth::user();

            // Check if the user has enough points
            if ($user->points < $vendorProduct->points) {
                return response()->json(['message' => 'Insufficient points.'], 400);
            }

            // Check if the product is in stock
            if ($vendorProduct->stock <= 0) {
                return response()->json(['message' => 'Product out of stock.'], 400);
            }

            // Deduct points from the user
            $user->points -= $vendorProduct->points;
            $user->save();

            // Reduce the product stock
            $vendorProduct->stock -= 1;
            $vendorProduct->save();

            // Create a vendor transaction record
            VendorTransaction::create([
                'user_id' => $user->id,
                'vendor_product_id' => $vendorProduct->id,
                'points_used' => $vendorProduct->points,
                'status' => 'Completed',
            ]);

            return response()->json(['message' => 'Product redeemed successfully.']);
        } catch (\Exception $e) {
            // Catch any unexpected errors and return a JSON response
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function adminIndex()
    {
        $products = Product::all();
        return view('Admin-store', compact('products'));
    }
}
