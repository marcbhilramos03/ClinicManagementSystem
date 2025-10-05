<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('archived_inventories', function (Blueprint $table) {
            $table->id();
            $table->string('name');              // Name of medicine/equipment
            $table->string('type')->nullable();  // e.g., Medicine, Equipment
            $table->integer('quantity')->default(0);
            $table->string('condition')->nullable(); // e.g., Expired, Used, Broken
            $table->date('expiration_date')->nullable();
            $table->text('notes')->nullable();   // Optional notes or remarks
            $table->timestamps();                // created_at = when archived
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archived_inventories');
    }
};
