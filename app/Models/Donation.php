<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'donation_program_id', 'points_donated', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function donationProgram()
    {
        return $this->belongsTo(DonationProgram::class);
    }
}
