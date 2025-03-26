<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EcoCycle; // Ensure this line is present
use App\Models\Vendor; // Ensure this line is present
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\StatusUpdateNotification;

class EcoCycleController extends Controller
{
    // Menampilkan daftar pengajuan eco cycle untuk user yang sedang login
    public function index()
    {
        $ecoCycles = EcoCycle::where('user_id', Auth::id())->get();
        $vendors = Vendor::all(); // Fetch all vendors
        return view('ecocycle-home', compact('ecoCycles', 'vendors')); // Pass vendors to the view
    }

    // Menampilkan form pengajuan eco cycle
    public function create()
    {
        return view('ecocycle.create');
    }

    // Menyimpan data pengajuan eco cycle
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_sampah' => 'required|string|max:255',
            'berat' => 'required|numeric',
            'alamat' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto' => 'required|image|max:2048', // Validasi file foto
            'vendor_id' => 'required|exists:vendors,id', // Validasi vendor_id
            'jadwal_pengambilan' => 'required|date|after:now', // Validasi jadwal pengambilan
        ]);

        // Upload file foto
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('eco_cycles', 'public');
            $validated['foto'] = $path;
        }

        // Set data tambahan
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending'; // Status default pengajuan

        // Buat record baru
        EcoCycle::create($validated);

        return response()->json(['success' => true]);
    }

    // Menampilkan detail pengajuan tertentu
    public function show($id)
    {
        $ecoCycle = EcoCycle::findOrFail($id);
        // Pastikan user hanya bisa melihat pengajuan miliknya
        if ($ecoCycle->user_id !== Auth::id()) {
            abort(403);
        }
        return view('ecocycle.show', compact('ecoCycle'));
    }

    // Mengupdate status atau data pengajuan (contoh: untuk vendor mengupdate status)
    public function update(Request $request, $id)
    {
        $ecoCycle = EcoCycle::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|string|max:50',
        ]);

        // Check if the status is being updated to "approved"
        if ($validated['status'] === 'approved' && $ecoCycle->status !== 'approved') {
            // Calculate points based on weight (e.g., 1 point per kg)
            $points = floor($ecoCycle->berat);
            $user = $ecoCycle->user;
            $user->points += $points;
            $user->save();
        }

        $ecoCycle->update($validated);

        // Send notification to the user
        $ecoCycle->user->notify(new StatusUpdateNotification($ecoCycle));

        return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui.');
    }

    // Menghapus pengajuan (hanya oleh pemilik)
    public function destroy($id)
    {
        $ecoCycle = EcoCycle::findOrFail($id);
        if ($ecoCycle->user_id !== Auth::id()) {
            abort(403);
        }
        $ecoCycle->delete();

        return redirect()->route('ecocycle.index')->with('success', 'Pengajuan berhasil dihapus.');
    }

    // Menampilkan detail pengajuan untuk AJAX request
    public function getDetails($id)
    {
        $ecoCycle = EcoCycle::with('vendor')->findOrFail($id);

        // Ensure the user can only view their own submissions
        if ($ecoCycle->user_id !== Auth::id()) {
            abort(403);
        }

        return response()->json($ecoCycle);
    }
}
