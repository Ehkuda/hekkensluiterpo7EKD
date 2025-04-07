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
            $table->string('id_nummer');
            $table->string('adres_gedetineerd');
            $table->text('bezittingen');
            $table->date('datum_opsluiting');
            $table->date('datum_vrijlating');
            $table->datetime('datum_tijd_bezoek');
            $table->integer('aantal_bezoeken');
            $table->string('locatie_vleugel_cel');
            $table->text('historie_locatie');
            $table->string('reden_gedetineerd');
            $table->text('opmerkingen')->nullable();
            $table->timestamps();
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
