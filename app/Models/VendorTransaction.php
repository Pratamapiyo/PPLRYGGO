<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'vendor_product_id', 'points_used', 'final_price', 'status'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->status = strtolower($model->status); // Ensure status is always stored in lowercase
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vendorProduct()
    {
        return $this->belongsTo(VendorProduct::class);
    }
}
