<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Controleer of de kolom 'cel_id' al bestaat
        if (!Schema::hasColumn('gedetineerden', 'cel_id')) {
            Schema::table('gedetineerden', function (Blueprint $table) {
                $table->unsignedBigInteger('cel_id')->nullable()->after('id');
                $table->foreign('cel_id')->references('id')->on('cels')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gedetineerden', function (Blueprint $table) {
            // Verwijder de buitenlandse sleutel voordat je de kolom verwijdert
            $table->dropForeign(['cel_id']);
            $table->dropColumn('cel_id');
        });
    }
};
