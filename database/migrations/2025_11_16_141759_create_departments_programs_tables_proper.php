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
        // Drop existing departments table if it exists
        Schema::dropIfExists('departments');
        Schema::dropIfExists('programs');
        
        // Create departments table
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('short_name')->nullable();
            $table->timestamps();
        });

        // Create programs table
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('degree_level'); // Bachelor, Master, Doctor
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['department_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
        Schema::dropIfExists('departments');
    }
};
