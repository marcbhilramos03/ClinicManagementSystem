<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')
                  ->constrained('departments')
                  ->onDelete('cascade'); // if department is deleted, its programs are too
            $table->string('name'); // e.g., BSIT, BSN, ABM Strand
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
