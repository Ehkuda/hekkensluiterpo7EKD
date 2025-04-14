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
            $table->date('datum_opsluiting')->change();
            $table->date('datum_vrijlating')->change();
        });
    }
    
    public function down()
    {
        Schema::table('gedetineerden', function (Blueprint $table) {
            $table->string('datum_opsluiting')->change();
            $table->string('datum_vrijlating')->change();
        });
    }
    
};
