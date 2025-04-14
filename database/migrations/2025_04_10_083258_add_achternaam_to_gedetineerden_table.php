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
        // Controleer of de kolom 'achternaam_gedetineerd' al bestaat
        if (!Schema::hasColumn('gedetineerden', 'achternaam_gedetineerd')) {
            Schema::table('gedetineerden', function (Blueprint $table) {
                $table->string('achternaam_gedetineerd')->after('naam_gedetineerd')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('gedetineerden', function (Blueprint $table) {
            $table->dropColumn('achternaam_gedetineerd');
        });
    }
};
