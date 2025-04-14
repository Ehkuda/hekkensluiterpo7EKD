<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CelGeschiedenis extends Model
{
    use HasFactory;

    protected $table = 'cel_geschiedenis'; // De naam van de tabel

    protected $fillable = [
        'cel_id',
        'gedetineerde_id',
        'van_datum',  // Correcte naam voor de startdatum
        'tot_datum',  // Correcte naam voor de einddatum
    ];

    // Relatie naar de Cel
    public function cel()
    {
        return $this->belongsTo(Cel::class);
    }

    // Relatie naar de Gedetineerde
    public function gedetineerde()
    {
        return $this->belongsTo(Gedetineerde::class);
    }
}
