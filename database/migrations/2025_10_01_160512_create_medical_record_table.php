<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::create('medical_records', function (Blueprint $table) {
        $table->id();
        $table->foreignId('clinic_session_id')->constrained('clinic_sessions')->onDelete('cascade');

        $table->text('diagnosis')->nullable();
        $table->text('treatment')->nullable();
        $table->text('notes')->nullable();

    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_record');
    }
};
