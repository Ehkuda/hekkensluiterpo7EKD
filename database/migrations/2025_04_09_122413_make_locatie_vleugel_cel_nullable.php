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
        Schema::table('gedetineerden', function (Blueprint $table) {
            $table->string('locatie_vleugel_cel')->nullable()->change(); // Maak de kolom nullable
        });
    }
    
    public function down()
    {
        Schema::table('gedetineerden', function (Blueprint $table) {
            $table->string('locatie_vleugel_cel')->nullable(false)->change(); // Zet nullable terug naar false
        });
    }
    
};
