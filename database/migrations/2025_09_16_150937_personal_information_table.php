<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal_information', function (Blueprint $table) {
            $table->id();

            // Link to users table
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Academic links (for patients only)
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('program_id')->nullable()->constrained()->onDelete('cascade');

            // School ID (unique per student/faculty/staff)
            $table->string('school_id')->unique();

            // Category of person (helps classify them)
            $table->enum('category', [
                'student',
                'faculty',
                'non_teaching_personnel',
                'admin',
                'other'
            ])->default('student');

            // Basic personal details
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('gender')->nullable(); // male, female, other
            $table->date('birthdate')->nullable();

            $table->string('address')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_no')->nullable();
            $table->string('emergency_contact_relationship')->nullable(); // Relationship to emergency contact

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_information');
    }
};
