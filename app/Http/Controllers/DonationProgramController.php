<?php

namespace App\Http\Controllers;

use App\Models\DonationProgram;
use Illuminate\Http\Request;

class DonationProgramController extends Controller
{
    public function index()
    {
        $programs = DonationProgram::all();
        return view('Admin-donations', compact('programs'));
    }

    public function userIndex()
    {
        $programs = DonationProgram::all();
        return view('ecogive', compact('programs'));
    }

    public function show(DonationProgram $donationProgram)
    {
        return view('ecogive-detail', ['program' => $donationProgram]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'goal_points' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'goal_points']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('donation_program_images', 'public');
        }

        DonationProgram::create($data);

        return redirect()->route('admin.donations.index')->with('success', 'Donation program created successfully.');
    }

    public function update(Request $request, DonationProgram $donationProgram)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'goal_points' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'goal_points']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('donation_program_images', 'public');
        }

        $donationProgram->update($data);

        return redirect()->route('admin.donations.index')->with('success', 'Donation program updated successfully.');
    }

    public function destroy(DonationProgram $donationProgram)
    {
        // Hapus program donasi
        $donationProgram->delete();

        return redirect()->route('admin.donations.index')->with('success', 'Donation program deleted successfully.');
    }
}
