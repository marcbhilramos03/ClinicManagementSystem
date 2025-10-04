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
    Schema::create('prescriptions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('clinic_session_id')->constrained('clinic_sessions')->onDelete('cascade');
        $table->foreignId('inventory_id')->constrained('inventories')->onDelete('cascade'); // Link to inventory

        $table->string('dosage');       // e.g., "500mg"
        $table->string('frequency');    // e.g., "2x a day"
        $table->string('duration')->nullable(); // e.g., "5 days"
        $table->integer('quantity');    // How many units are given to patient
    });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescription');
    }
};
