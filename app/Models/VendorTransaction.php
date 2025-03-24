<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'vendor_product_id', 'points_used', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vendorProduct()
    {
        return $this->belongsTo(VendorProduct::class);
    }
}
