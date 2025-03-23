<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Vendor;

class VendorSeeder extends Seeder
{
    public function run()
    {
        // Create a new vendor user
        $newVendorUser = User::create([
            'name' => 'New Vendor User',
            'email' => 'newvendor@example.com',
            'password' => bcrypt('password123'), // Use a secure password
        ]);

        // Assign the 'Vendor' role to the new user
        $newVendorUser->assignRole('Vendor');

        // Create a vendor profile for the new user
        Vendor::create([
            'user_id'       => $newVendorUser->id,
            'business_name' => 'New Vendor Business',
            'description'   => 'Deskripsi singkat untuk New Vendor Business',
            'location'      => 'Jl. Baru No. 456, Kota Baru',
            'contact'       => '081298765432',
            'status'        => 'active',
        ]);

        // Mapping manual untuk business_name berdasarkan email
        $manualNames = [
            'vendor@example.com' => 'Toko Plastik Hijau',
            // Tambahkan mapping lain jika ada vendor lain, contoh:
            // 'vendor2@example.com' => 'Bisnis Vendor 2',
        ];

        // Ambil semua user dengan peran 'Vendor'
        $vendorUsers = User::role('Vendor')->get();

        foreach ($vendorUsers as $user) {
            // Gunakan mapping manual jika tersedia, jika tidak fallback ke nama user
            $businessName = isset($manualNames[$user->email]) ? $manualNames[$user->email] : $user->name;

            Vendor::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'business_name' => $businessName,
                    'description'   => 'Deskripsi singkat untuk ' . $user->name,
                    'location'      => 'Jl. Contoh No. 123, Kota Contoh',
                    'contact'       => '08123456789',
                    'status'        => 'active',
                ]
            );
        }
    }
}
