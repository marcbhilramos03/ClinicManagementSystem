<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credentials', function (Blueprint $table) {
            $table->id();
            
            // Link to personal_information (1-to-1 relationship)
            $table->foreignId('personal_information_id')->constrained('personal_information')->onDelete('cascade');

            $table->enum('credential_type', ['none', 'license', 'degree'])->default('none');
            $table->string('license_type')->nullable();   // e.g., RN, MD, RMT
            $table->string('degree')->nullable();         // e.g., BScN, MD, RMT

    
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credentials');
    }
};
