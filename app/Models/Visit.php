<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'visitor_id',
        'detainee_id',
        'arrival_time',
        'departure_time',
    ];

    // Hier zorg je dat arrival_time en departure_time automatisch Carbon objects zijn
    protected $casts = [
        'arrival_time' => 'datetime',
        'departure_time' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }

    public function detainee()
    {
        return $this->belongsTo(Gedetineerde::class, 'detainee_id');
    }
}
