<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminKey extends Model
{
    protected $table = 'admin_keys';
    
    protected $fillable = [
        'secret_key',
        'name', 
        'email',
        'is_active',
        'last_used_at'
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'last_used_at' => 'datetime'
    ];
}