<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $transactions = Auth::user()->transactions()->with('product')->latest()->paginate(10);
        return view('pointhistory', compact('transactions'));
    }

    // ...existing code...
}