<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Models\VendorProduct; // Import VendorProduct model
use App\Models\VendorTransaction; // Import the new model
use App\Notifications\PointRedemptionStatusNotification;

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

            // Ensure the product is in stock
            if ($vendorProduct->stock <= 0) {
                return response()->json(['message' => 'Product out of stock.'], 400);
            }

            // Determine if the user wants to use points
            $usePoints = $request->input('use_points', false);

            $discount = 0;
            $pointsUsed = 0;

            if ($usePoints) {
                // Calculate the maximum discount in currency (1 point = Rp 1000)
                $maxDiscount = $vendorProduct->max_redeemable_points * 1000;

                // Ensure the user has enough points for the discount
                $userPointsInCurrency = $user->points * 1000; // Convert user points to currency
                $discount = min($userPointsInCurrency, $maxDiscount);

                // Deduct points from the user (convert discount back to points)
                $pointsUsed = $discount / 1000;
                $user->points -= $pointsUsed;
                $user->save();
            }

            // Calculate the final price after applying the discount
            $finalPrice = $vendorProduct->price - $discount;

            // Ensure the final price is not negative
            $finalPrice = max(0, $finalPrice);

            \Log::info('Final Price Calculated: ' . $finalPrice); // Log the final price for debugging

            // Create a vendor transaction record with status 'Pending'
            VendorTransaction::create([
                'user_id' => $user->id,
                'vendor_product_id' => $vendorProduct->id,
                'points_used' => $pointsUsed,
                'final_price' => $finalPrice,
                'status' => 'Pending', // Set status to 'Pending'
            ]);

            return response()->json([
                'message' => 'Your redemption request has been submitted and is pending approval.',
                'final_price' => $finalPrice,
                'discount' => $discount,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function redeemPointProduct(Request $request, $productId)
    {
        $user = Auth::user();
        $product = \App\Models\Product::findOrFail($productId);

        // Check if the user has enough points
        if ($user->points < $product->points) {
            return response()->json(['message' => 'You do not have enough points to redeem this product.'], 400);
        }

        // Check if the product is in stock
        if ($product->stock <= 0) {
            return response()->json(['message' => 'This product is out of stock.'], 400);
        }

        // Deduct points and reduce stock
        $user->points -= $product->points;
        $user->save();

        $product->stock -= 1;
        $product->save();

        // Create a transaction record with "pending" status
        \App\Models\Transaction::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'points_used' => $product->points,
            'status' => 'pending', // Set initial status to "pending"
        ]);

        return response()->json(['message' => 'Your redemption request has been submitted and is pending approval.']);
    }

    public function adminIndex()
    {
        $products = Product::all();
        return view('Admin-store', compact('products'));
    }

    public function redemptionManagement()
    {
        $transactions = \App\Models\Transaction::with(['user', 'product'])->latest()->get();
        return view('Admin-RedemptionManagement', compact('transactions'));
    }

    public function updateTransactionStatus(Request $request, $transactionId)
    {
        $transaction = \App\Models\Transaction::findOrFail($transactionId);

        $request->validate([
            'status' => 'required|string|in:pending,processed,completed,rejected',
        ]);

        $transaction->status = $request->status;
        $transaction->save();

        // Send notification to the user
        $transaction->user->notify(new PointRedemptionStatusNotification($transaction, $transaction->status));

        return redirect()->back()->with('success', 'Transaction status updated successfully.');
    }
}