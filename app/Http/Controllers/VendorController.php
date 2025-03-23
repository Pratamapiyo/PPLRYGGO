<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\EcoCycle; // Ensure this line is present
use App\Models\User;

class VendorController extends Controller
{
    // Tampilkan daftar vendor
    public function index()
    {
        $vendors = Vendor::all();
        return view('vendor.index', compact('vendors'));
    }

    // Tampilkan form pembuatan vendor baru
    public function create()
    {
        // Jika diperlukan, ambil data user tertentu atau data lainnya
        return view('vendor.create');
    }

    // Simpan vendor baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'business_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            // 'vendor_photo' => 'nullable|image|max:2048', // Jika menggunakan field vendor_photo
        ]);

        // Jika Anda menghandle upload foto, contoh:
        // if ($request->hasFile('vendor_photo')) {
        //     $path = $request->file('vendor_photo')->store('vendors', 'public');
        //     $validated['vendor_photo'] = $path;
        // }

        Vendor::create($validated);

        return redirect()->route('vendor.index')->with('success', 'Vendor berhasil ditambahkan.');
    }

    // Tampilkan detail vendor
    public function show($id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('vendor.show', compact('vendor'));
    }

    // Tampilkan form edit vendor
    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('vendor.edit', compact('vendor'));
    }

    // Update data vendor
    public function update(Request $request, $id)
    {
        $vendor = Vendor::findOrFail($id);
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            // 'vendor_photo' => 'nullable|image|max:2048',
        ]);

        // Handle upload foto jika diperlukan:
        // if ($request->hasFile('vendor_photo')) {
        //     $path = $request->file('vendor_photo')->store('vendors', 'public');
        //     $validated['vendor_photo'] = $path;
        // }

        $vendor->update($validated);

        return redirect()->route('vendor.index')->with('success', 'Data vendor berhasil diperbarui.');
    }

    // Hapus vendor
    public function destroy($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();

        return redirect()->route('vendor.index')->with('success', 'Vendor berhasil dihapus.');
    }

    public function createOrEdit()
    {
        $vendor = Vendor::where('user_id', auth()->id())->first();
        return view('vendor.profile', compact('vendor'));
    }

    public function storeOrUpdate(Request $request)
    {
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
        ]);

        Vendor::updateOrCreate(
            ['user_id' => auth()->id()],
            $validated + ['user_id' => auth()->id()]
        );

        return redirect()->route('vendor.profile')->with('success', 'Vendor profile updated successfully.');
    }

    public function viewRequests()
    {
        $vendor = Vendor::where('user_id', auth()->id())->firstOrFail();

        $requests = EcoCycle::where('vendor_id', $vendor->id)
            ->where('status', 'pending')
            ->with('user')
            ->get();

        $history = EcoCycle::where('vendor_id', $vendor->id)
            ->whereIn('status', ['approved', 'rejected'])
            ->with('user')
            ->get();

        return view('vendor-PengajuanDaurUlang', compact('requests', 'history'));
    }
}
