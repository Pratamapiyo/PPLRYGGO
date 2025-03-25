<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorProduct extends Model
{
    use HasFactory;

    protected $fillable = ['vendor_id', 'name', 'description', 'points', 'stock', 'image', 'price', 'max_redeemable_points'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
