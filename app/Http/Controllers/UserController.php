<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\VendorTransaction; // Ensure this is imported
use App\Models\Vendor;

class UserController extends Controller
{
    // ...existing code...

    public function profile()
    {
        $user = auth()->user();
        $vendor = $user->vendor; // Assuming a one-to-one relationship between User and Vendor
        return view('profile', compact('user', 'vendor'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        // Validate basic information
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'region' => 'required|string|max:255',
        ]);

        // Check if password is being updated
        if ($request->filled('password')) {
            // Validate password update
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|string|min:8',
            ]);

            // Verify the current password
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'The current password is incorrect.'])->withInput();
            }

            // Update password
            $user->password = Hash::make($request->password);
            
            // Update user information
            $user->name = $request->name;
            $user->email = $request->email;
            $user->region = $request->region;
            $user->save();
            
            // Return to edit profile page with success message
            return redirect()->route('profile.edit')->with('success', 'Profile and password updated successfully.');
        }

        // If not updating password, just update other details
        $user->name = $request->name;
        $user->email = $request->email;
        $user->region = $request->region;
        $user->save();

        // Return to edit profile page with success message
        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }

    public function uploadProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $user = Auth::user();
        $path = $request->file('profile_picture')->store('profile_pictures', 'public');
        $user->profile_picture = $path;
        $user->save();
        return redirect()->route('profile')->with('success', 'Profile picture updated successfully.');
    }

    public function deactivateAccount(Request $request)
    {
        // Implement validation for the confirmation text
        $request->validate([
            'confirmation_text' => 'required|in:saya ingin tutup akun ini'
        ], [
            'confirmation_text.in' => 'The confirmation text you entered is incorrect.'
        ]);
        
        $user = Auth::user();
        $user->delete();
        
        return redirect('/')->with('success', 'Account deactivated successfully.');
    }

    public function editProfile()
    {
        return view('edit-profile');
    }

    public function rankings(Request $request)
    {
        $query = \App\Models\User::orderBy('points', 'desc');
        if ($request->has('region')) {
            $query->where('region', $request->region); // Filter by region
        }
        $users = $query->get();
        return view('rankings', compact('users'));
    }

    public function pointHistory()
    {
        $user = Auth::user();
        $transactions = $user->transactions()->with('product')->latest()->paginate(10);
        $donations = $user->donations()->with('donationProgram')->latest()->paginate(10);
        return view('pointhistory', compact('transactions', 'donations'));
    }

    public function transactionHistory()
    {
        $user = Auth::user();
        $transactions = VendorTransaction::where('user_id', $user->id)
            ->with('vendorProduct')
            ->latest()
            ->get(); // Removed pagination

        return view('transaction-history', compact('transactions'));
    }

    public function points()
    {
        $user = Auth::user();
        $pointHistories = \App\Models\EcoCycle::where('user_id', $user->id)
            ->where('status', 'approved') // Only approved submissions contribute to points
            ->select(['kategori_sampah', 'berat', 'created_at'])
            ->get()
            ->map(function ($history) {
                $history->points = floor($history->berat); // Calculate points based on weight
                return $history;
            });
        $products = \App\Models\Product::where('stock', '>', 0)->get(); // Fetch products with stock > 0
        $transactions = \App\Models\Transaction::where('user_id', $user->id)->with('product')->latest()->get(); // Fetch redemption history

        return view('point', compact('user', 'pointHistories', 'products', 'transactions'));
    }
}