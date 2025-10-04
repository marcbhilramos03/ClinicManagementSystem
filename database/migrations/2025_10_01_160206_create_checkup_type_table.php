<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checkup_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');   // e.g. "Consultation", "Vitals Only"
            $table->text('description')->nullable(); // Optional extra info
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checkup_types');
    }
};
