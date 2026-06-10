<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SavedItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'savable_type',
        'savable_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function savable()
    {
        return $this->morphTo();
    }
}