<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('visit_requests', function (Blueprint $table) {
            $table->id();
            $table->string('visitor_name');
            $table->string('visitor_id_document');
            $table->string('visitor_email');
            $table->string('visitor_phone')->nullable();
            $table->foreignId('detainee_id')->constrained('gedetineerden')->onDelete('cascade');
            $table->datetime('requested_visit_time');
            $table->text('reason_for_visit')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('staff_notes')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->datetime('reviewed_at')->nullable();
            $table->foreignId('visit_id')->nullable()->constrained('visits')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('visit_requests');
    }
};