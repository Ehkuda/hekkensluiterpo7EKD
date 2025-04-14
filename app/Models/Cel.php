<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cel extends Model
{
    protected $table = 'cels';
    protected $fillable = ['naam', 'gedetineerde_id']; // Voeg dit toe als het nog niet in je migratie zit

    public function gedetineerde()
    {
        return $this->belongsTo(\App\Models\Gedetineerde::class);
    }

// In het Cel model (app/Models/Cel.php)

public function celGeschiedenis()
{
    return $this->hasMany(CelGeschiedenis::class);
}




}
