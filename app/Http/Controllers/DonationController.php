<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\DonationProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    public function store(Request $request, DonationProgram $donationProgram)
    {
        $user = Auth::user();

        // Validasi poin yang didonasikan
        $request->validate([
            'points_donated' => 'required|integer|min:1|max:' . $user->points,
        ]);

        // Cek apakah donasi melebihi target program
        if ($donationProgram->collected_points + $request->points_donated > $donationProgram->goal_points) {
            return redirect()->back()->withErrors(['message' => 'Donation exceeds the program goal.']);
        }

        // Kurangi poin pengguna
        $user->points -= $request->points_donated;
        $user->save();

        // Tambahkan poin ke program donasi
        $donationProgram->collected_points += $request->points_donated;
        $donationProgram->save();

        // Buat catatan donasi
        Donation::create([
            'user_id' => $user->id,
            'donation_program_id' => $donationProgram->id,
            'points_donated' => $request->points_donated,
            'status' => 'Completed',
        ]);

        return redirect()->route('ecogive.show', $donationProgram->id)->with('success', 'Donation successful!');
    }

    public function donate(Request $request, DonationProgram $donationProgram)
    {
        $user = Auth::user();

        // Validate donation points
        $request->validate([
            'points_donated' => 'required|integer|min:1|max:' . $user->points,
        ]);

        // Check if donation exceeds program goal
        if ($donationProgram->collected_points + $request->points_donated > $donationProgram->goal_points) {
            return response()->json(['message' => 'Donation exceeds the program goal.'], 400);
        }

        // Deduct user points
        $user->points -= $request->points_donated;
        $user->save();

        // Add points to the donation program
        $donationProgram->collected_points += $request->points_donated;
        $donationProgram->save();

        // Create a donation record
        Donation::create([
            'user_id' => $user->id,
            'donation_program_id' => $donationProgram->id,
            'points_donated' => $request->points_donated,
            'status' => 'Completed',
        ]);

        return response()->json(['message' => 'Donation successful!']);
    }

    public function history()
    {
        $donations = Auth::user()->donations()->with('donationProgram')->latest()->paginate(10);
        return view('donations.history', compact('donations'));
    }
}
