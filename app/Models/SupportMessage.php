<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupportMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'message',
        'sender',
        'is_read',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}