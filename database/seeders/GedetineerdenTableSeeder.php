<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gedetineerde;

class GedetineerdenTableSeeder extends Seeder
{
    /**
     * Zaai de gegevens.
     *
     * @return void
     */
    public function run()
    {
        Gedetineerde::create([
            'naam_gedetineerd' => 'Jan Janssen',
            'geboortedatum_gedetineerd' => '1990-05-15',
            'id_nummer' => '123456',
            'adres_gedetineerd' => 'Straatnaam 123, Stad',
            'bezittingen' => 'Telefoon, Kleding',
            'datum_opsluiting' => '2025-03-01',
            'datum_vrijlating' => '2025-08-01',
            'datum_tijd_bezoek' => '2025-04-01 10:00:00',
            'aantal_bezoeken' => 2,
            'locatie_vleugel_cel' => 'Vleugel A, Cel 1',
            'historie_locatie' => 'Beginlocatie: Cel 1',
            'reden_gedetineerd' => 'Diefstal',
            'opmerkingen' => 'Geen',
        ]);

        // Voeg meer testgegevens toe als dat nodig is.
    }
}
