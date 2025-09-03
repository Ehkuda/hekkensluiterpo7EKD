<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('gedetineerden', function (Blueprint $table) {
            $table->string('verslag_path')->nullable()->after('opmerkingen');
        });
    }

    public function down(): void
    {
        Schema::table('gedetineerden', function (Blueprint $table) {
            $table->dropColumn('verslag_path');
        });
    }
};
