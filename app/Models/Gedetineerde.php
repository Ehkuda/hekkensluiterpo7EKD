<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gedetineerde extends Model
{
    use HasFactory;

    protected $table = 'gedetineerd';

    protected $fillable = [
        'naam_gedetineerd', 'geboortedatum_gedetineerd', 'id_nummer', 'adres_gedetineerd', 
        'bezittingen', 'datum_opsluiting', 'datum_vrijlating', 'datum_tijd_bezoek', 
        'aantal_bezoeken', 'locatie_vleugel_cel', 'historie_locatie', 'reden_gedetineerd', 'opmerkingen'
    ];
}
