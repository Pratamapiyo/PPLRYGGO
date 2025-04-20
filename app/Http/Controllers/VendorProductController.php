<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VendorProduct;
use Illuminate\Support\Facades\Auth;

class VendorProductController extends Controller
{
    public function index()
    {
        $vendor = Auth::user()->vendor;

        // Check if the user has a Vendor record
        if (!$vendor) {
            return redirect()->route('vendor.profile')->with('error', 'You need to complete your vendor profile before managing products.');
        }

        // Fetch products specific to the vendor
        $products = $vendor->vendorProducts;

        // Return the view with the vendor's products
        return view('vendor-store', compact('products'));
    }

    public function create()
    {
        return view('vendor.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'points' => 'required|integer|min:0', // Add validation for points
            'max_redeemable_points' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $vendor = Auth::user()->vendor;
        $product = new VendorProduct($request->only([
            'name', 
            'description', 
            'price', 
            'points', // Include points field
            'max_redeemable_points', 
            'stock'
        ]));

        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('vendor_product_images', 'public');
        }

        $vendor->vendorProducts()->save($product);

        return redirect()->route('vendor.store.index')->with('success', 'Product created successfully.');
    }

    public function edit(VendorProduct $vendorProduct)
    {
        return view('vendor.products.edit', compact('vendorProduct'));
    }

    public function update(Request $request, VendorProduct $vendorProduct)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'points' => 'required|integer|min:0', // Add validation for points
            'max_redeemable_points' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $vendor = Auth::user()->vendor;

        if ($vendor->id !== $vendorProduct->vendor_id) {
            abort(403, 'Unauthorized action.');
        }

        $vendorProduct->fill($request->only([
            'name', 
            'description', 
            'price', 
            'points', // Include points field
            'max_redeemable_points', 
            'stock'
        ]));

        if ($request->hasFile('image')) {
            $vendorProduct->image = $request->file('image')->store('vendor_product_images', 'public');
        }

        $vendorProduct->save();

        return redirect()->route('vendor.store.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(VendorProduct $vendorProduct)
    {
        $vendor = Auth::user()->vendor;

        if ($vendor->id !== $vendorProduct->vendor_id) {
            abort(403, 'Unauthorized action.');
        }

        $vendorProduct->delete();

        return redirect()->route('vendor.store.index')->with('success', 'Product deleted successfully.');
    }
}
