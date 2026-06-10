<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'make', 'model','year_start', 'year_end', 'year', 'region', 'trim', 'engine_type', 'horsepower',
        'zero_to_100_kmh', 'top_speed_kmh', 'transmission', 'gears',
        'drivetrain', 'fuel_type', 'body_type', 'oil_capacity_l',
        'oil_density_type', 'hydraulic_capacity_l', 'hydraulic_fluid_type',
        'fuel_combined_l_100km', 'fuel_city_l_100km', 'fuel_highway_l_100km',
        'description_en', 'description_ku', 'image_path',
    ];

    protected $casts = [
        'year_start' => 'integer',
        'year_end' => 'integer',
        'year' => 'integer',
        'horsepower' => 'integer',
        'gears' => 'integer',
        'top_speed_kmh' => 'integer',
        'zero_to_100_kmh' => 'decimal:2',
        'oil_capacity_l' => 'decimal:2',
        'hydraulic_capacity_l' => 'decimal:2',
        'fuel_combined_l_100km' => 'decimal:2',
        'fuel_city_l_100km' => 'decimal:2',
        'fuel_highway_l_100km' => 'decimal:2',
        'average_rating' => 'decimal:2',
        'review_count' => 'integer',
    ];

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    

    public function savedByUsers()
    {
        return $this->morphMany(SavedItem::class, 'savable');
    }

   public function getImageUrlAttribute()
{
    if ($this->image_path) {
        return asset('images/' . $this->image_path);
    }
    return 'https://via.placeholder.com/800x400/1a1a2e/F47920?text=' . urlencode($this->make . '+' . $this->model);
}
}