<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gedetineerde extends Model
{
    use HasFactory;

    // Zorg ervoor dat de tabelnaam correct is
    protected $table = 'gedetineerden';

    protected $dates = [
        'datum_opsluiting',
        'datum_vrijlating',
        'datum_tijd_bezoek',
    ];

    protected $fillable = [
        'naam_gedetineerd',
        'achternaam_gedetineerd',
        'geboortedatum_gedetineerd',
        'id_nummer',
        'adres_gedetineerd',
        'datum_opsluiting',
        'datum_vrijlating',
        'locatie_vleugel_cel',
        'reden_gedetineerd',
        'opmerkingen',
        'foto',
        'verslag_path',
    ];

    // Relatie: een Gedetineerde behoort tot één Cel
    public function cel()
    {
        return $this->belongsTo(Cel::class, 'locatie_vleugel_cel');
    }

// In het Gedetineerde model (app/Models/Gedetineerde.php)

// In het Gedetineerde model
public function celGeschiedenis()
{
    return $this->hasMany(CelGeschiedenis::class, 'gedetineerde_id');
}

// app/Models/Gedetineerde.php
public function visits()
{
    return $this->hasMany(Visit::class, 'detainee_id');
}

}
