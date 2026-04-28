<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'username', 'first_name', 'last_name',
        'name', 'email', 'password', 'role', 'locale', 'profile_photo_path',
        'phone', 'city', 'bio_en', 'bio_ku', 'is_verified_mechanic',
        'verification_document_path', 'theme_preference',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_verified_mechanic' => 'boolean',
    ];

    public function mechanicDetail()
    {
        return $this->hasOne(MechanicDetail::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function savedItems()
    {
        return $this->hasMany(SavedItem::class);
    }

    public function ownedCars()
    {
        return $this->belongsToMany(Car::class, 'user_cars')->withTimestamps();
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isMechanic()
    {
        return $this->role === 'mechanic';
    }

    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo_path
            ? asset('storage/' . $this->profile_photo_path)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=F47920&color=fff';
    }
}