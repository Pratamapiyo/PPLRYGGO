<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\VendorTransaction; // Ensure this is imported

class UserController extends Controller
{
    // ...existing code...

    public function profile()
    {
        return view('profile'); // Ensure a 'profile.blade.php' view exists in the resources/views directory.
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
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

    public function deactivateAccount()
    {
        $user = Auth::user();
        $user->delete();

        return redirect('/')->with('success', 'Account deactivated successfully.');
    }

    public function editProfile()
    {
        return view('edit-profile');
    }

    public function rankings()
    {
        $users = \App\Models\User::orderBy('points', 'desc')->get();
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

    // ...existing code...
}