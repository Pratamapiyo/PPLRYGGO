<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\EcoCycle; // Ensure this line is present
use App\Models\User;
use App\Models\VendorTransaction; // Ensure this model is imported

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
            'distance' => 'nullable|numeric|min:0',
            'spesialisasi' => 'nullable|string|max:255', // Validate spesialisasi
        ]);

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
        $user = $vendor->user;

        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'distance' => 'nullable|numeric|min:0',
            'spesialisasi' => 'nullable|string|max:255', // Validate spesialisasi
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
        ]);

        // Update vendor details
        $vendor->update([
            'business_name' => $validated['business_name'],
            'description' => $validated['description'],
            'location' => $validated['location'],
            'contact' => $validated['contact'],
            'distance' => $validated['distance'],
            'spesialisasi' => $validated['spesialisasi'], // Update spesialisasi
        ]);

        // Update user details
        $user->email = $validated['email'];
        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }
        $user->save();

        return redirect()->route('admin.vendor.management')->with('success', 'Vendor updated successfully.');
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
        $vendor = auth()->user()->vendor; // Fetch the vendor profile for the logged-in user
        return view('vendor-profile', compact('vendor'));
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

    public function buyerManagement()
    {
        $vendor = auth()->user()->vendor;

        if (!$vendor) {
            return redirect()->route('vendor.profile')->with('error', 'Anda harus melengkapi profil vendor terlebih dahulu.');
        }

        $transactions = VendorTransaction::whereHas('vendorProduct', function ($query) use ($vendor) {
            $query->where('vendor_id', $vendor->id);
        })->with(['user', 'vendorProduct'])->latest()->get();

        return view('vendor-buyer', compact('transactions'));
    }

    public function listVendors()
    {
        $vendors = \App\Models\Vendor::with('user')->get(); // Fetch vendors with their associated user data
        return view('Admin-vendormanagement', compact('vendors'));
    }

    public function registerVendor(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'business_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'distance' => 'nullable|numeric|min:0', // Validate distance
        ]);

        // Create the user
        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        // Assign the "Vendor" role to the user
        $user->assignRole('Vendor');

        // Create the vendor profile
        Vendor::create([
            'user_id' => $user->id,
            'business_name' => $validated['business_name'],
            'location' => $validated['location'],
            'contact' => $validated['contact'],
            'distance' => $validated['distance'], // Save distance
            'status' => 'active', // Default status
        ]);

        return redirect()->route('admin.vendor.management')->with('success', 'Vendor registered successfully.');
    }

    public function toggleStatus($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->status = $vendor->status === 'active' ? 'inactive' : 'active';
        $vendor->save();

        return redirect()->route('admin.vendor.management')->with('success', 'Vendor status updated successfully.');
    }

    public function delete($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();

        return redirect()->route('admin.vendor.management')->with('success', 'Vendor deleted successfully.');
    }
}
