<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MechanicDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialization_en',
        'specialization_ku',
        'experience_years',
        'workshop_name',
        'workshop_address',
        'workshop_city',
        'workshop_phone',
        'workshop_email',
        'workshop_hours',
        'specialty_tags',
        'latitude',
        'longitude',
        'is_featured',
        'featured_expires_at',
    ];

    protected $casts = [
        'specialty_tags' => 'array',
        'is_featured' => 'boolean',
        'featured_expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper method to get specialization based on locale
    public function getSpecializationAttribute()
    {
        $locale = app()->getLocale();
        if ($locale === 'ku') {
            return $this->specialization_ku ?? $this->specialization_en;
        }
        return $this->specialization_en;
    }

    // Helper method to get experience years
    public function getYearsExperienceAttribute()
    {
        return $this->experience_years;
    }
}