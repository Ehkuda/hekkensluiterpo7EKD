<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGedetineerdenTable extends Migration
{
    /**
     * Voer de migratie uit.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gedetineerden', function (Blueprint $table) {
            $table->id();
            $table->string('naam_gedetineerd');
            $table->date('geboortedatum_gedetineerd');
            $table->string('id_nummer')->unique(); // Uniek id nummer
            $table->string('adres_gedetineerd');
            $table->text('bezittingen')->nullable(); // Maak bezittingen nullable indien nodig
            $table->date('datum_opsluiting');
            $table->date('datum_vrijlating');
            $table->string('locatie_vleugel_cel');
            $table->text('historie_locatie')->nullable(); // Maak historie_locatie nullable indien nodig
            $table->string('reden_gedetineerd');
            $table->text('opmerkingen')->nullable();
            $table->timestamps();

            // Voeg een index toe voor snelle zoekopdrachten
            $table->index(['locatie_vleugel_cel', 'id_nummer']);
        });
    }

    /**
     * Zet de migratie terug.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gedetineerden');
    }
}
