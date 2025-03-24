<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationProgram extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'goal_points', 'collected_points', 'image'];

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
