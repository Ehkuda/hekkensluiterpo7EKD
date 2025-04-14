<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Controleer of de tabel al bestaat
        if (!Schema::hasTable('cel_geschiedenis')) {
            Schema::create('cel_geschiedenis', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('gedetineerde_id'); // De gedetineerde die de cel heeft
                $table->unsignedBigInteger('cel_id'); // De cel waaraan de gedetineerde is toegewezen
                $table->timestamp('van_datum');
                $table->timestamp('tot_datum')->nullable();
                $table->timestamps();

                // Relaties
                $table->foreign('gedetineerde_id')->references('id')->on('gedetineerden');
                $table->foreign('cel_id')->references('id')->on('cels');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cel_geschiedenis');
    }
};
