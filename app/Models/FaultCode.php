<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaultCode extends Model
{
    protected $fillable = [
        'code',
        'code_type',
        'make',
        'title_en',
        'title_ku',
        'description_en',
        'description_ku',
        'symptoms_en',
        'symptoms_ku',
        'possible_causes_en',
        'possible_causes_ku',
        'how_to_fix_en',
        'how_to_fix_ku',
        'severity',
        'system',
    ];

    public function getSeverityColorAttribute()
    {
        return match($this->severity) {
            'critical' => 'red',
            'high' => 'orange',
            'medium' => 'yellow',
            'low' => 'green',
            default => 'gray',
        };
    }
}