<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'region' => 'required|string|max:255', // Validate region
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'full_address' => 'nullable|string|max:500',
        ]);

        try {
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'region' => $data['region'], // Save region
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'full_address' => $data['full_address'],
            ]);

            // Flash success message
            return redirect()->route('login.form')->with('success', 'Account successfully registered!');
        } catch (\Exception $e) {
            // Flash error message
            return back()->withInput()->withErrors(['error' => 'An error occurred. Please try again.']);
        }
    }
}