<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_name',
        'description',
        'location',
        'contact',
        'status',
        'distance',
        'spesialisasi', // Add spesialisasi to fillable
        // 'vendor_photo', // Uncomment jika Anda menambahkan field ini di migration
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ecoCycles()
    {
        return $this->hasMany(EcoCycle::class, 'vendor_id'); // Ensure this relationship is correct
    }

    public function vendorProducts()
    {
        return $this->hasMany(VendorProduct::class);
    }
}
