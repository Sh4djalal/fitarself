<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Part extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name_en', 'name_ku', 'description_en', 'description_ku',
        'category', 'price', 'currency', 'image_path', 'brand',
        'part_number', 'compatible_cars', 'in_stock', 'stock_quantity',
        'condition', 'seller_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compatible_cars' => 'json',
        'in_stock' => 'boolean',
        'stock_quantity' => 'integer',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}