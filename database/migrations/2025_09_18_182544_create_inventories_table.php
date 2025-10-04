<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('category', ['medicine', 'equipment']);
            $table->string('type')->nullable();       // e.g., tablet, syringe, stethoscope
            $table->integer('quantity')->default(0);
            $table->string('condition')->nullable();  // e.g., new, good, fair, poor
            $table->date('expiration_date')->nullable(); // medicines or equipment lifespan

            // Track who added
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
