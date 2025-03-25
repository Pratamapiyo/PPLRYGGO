<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Remove the achievements relationship

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function vendor()
    {
        return $this->hasOne(Vendor::class);
    }

    public function pointHistories()
    {
        return $this->hasMany(PointHistory::class);
    }
}