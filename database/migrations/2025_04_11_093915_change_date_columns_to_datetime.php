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
    Schema::table('cel_geschiedenis', function (Blueprint $table) {
        $table->dateTime('van_datum')->change();
        $table->dateTime('tot_datum')->nullable()->change();
    });
}

public function down()
{
    Schema::table('cel_geschiedenis', function (Blueprint $table) {
        $table->date('van_datum')->change();
        $table->date('tot_datum')->nullable()->change();
    });
}
};
