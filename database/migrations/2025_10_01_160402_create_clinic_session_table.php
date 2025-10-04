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
    Schema::create('clinic_sessions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('patient_id')->constrained('users')->onDelete('cascade'); 
        $table->foreignId('clinic_staff_id')->constrained('users')->onDelete('cascade'); 
        $table->foreignId('checkup_type_id')->constrained('checkup_types')->onDelete('cascade');

        $table->dateTime('session_date');
        $table->text('reason')->nullable();

    });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinic_session');
    }
};
