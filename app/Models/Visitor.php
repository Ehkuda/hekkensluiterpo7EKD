<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'id_document_number'];

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
}