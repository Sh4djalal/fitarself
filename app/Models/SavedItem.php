<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedItem extends Model
{
    protected $fillable = ['user_id', 'savable_type', 'savable_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function savable()
    {
        return $this->morphTo();
    }
}