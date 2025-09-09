<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Drop the table if it exists first, then recreate it
        Schema::dropIfExists('research_analytics');
        
        Schema::create('research_analytics', function (Blueprint $table) {
            $table->id();
            $table->string('research_type'); // student, faculty, thesis, dissertation
            $table->unsignedBigInteger('research_id');
            $table->string('action'); // view, download
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable(); // Changed to text for longer user agents
            $table->string('download_purpose')->nullable();
            $table->text('download_notes')->nullable();
            $table->timestamps();
            
            $table->index(['research_type', 'research_id', 'action']);
            $table->index(['ip_address', 'action', 'created_at']); // For efficient deduplication queries
        });
    }

    public function down()
    {
        Schema::dropIfExists('research_analytics');
    }
};
