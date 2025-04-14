<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCelsTable extends Migration
{
    /**
     * Voer de migratie uit.
     *
     * @return void
     */
    public function up()
    {
        // Controleer of de tabel al bestaat voordat je probeert deze aan te maken
        if (!Schema::hasTable('cels')) {
            Schema::create('cels', function (Blueprint $table) {
                $table->id();
                $table->string('naam'); // Naam van de cel (bijv. A100, B200, etc.)
                $table->timestamps(); // Gegevens voor created_at en updated_at
            });
        }
    }

    /**
     * Zet de migratie terug.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cels');
    }
}
