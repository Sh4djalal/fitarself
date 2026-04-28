<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MechanicDetail extends Model
{
    protected $fillable = [
        'user_id', 'specialization_en', 'specialization_ku',
        'experience_years', 'workshop_name', 'workshop_address',
        'workshop_city', 'workshop_phone', 'workshop_email',
        'workshop_hours', 'specialty_tags', 'latitude', 'longitude',
        'is_featured', 'featured_expires_at',
    ];

    protected function casts(): array
    {
        return [
            'experience_years' => 'integer',
            'workshop_hours' => 'array',
            'specialty_tags' => 'array',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'is_featured' => 'boolean',
            'featured_expires_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}