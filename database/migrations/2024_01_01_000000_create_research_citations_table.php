<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('research_citations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('citing_user_id'); // User who is citing
            $table->string('citing_research_title'); // Title of the research that cites
            $table->string('citing_research_type'); // student, faculty, thesis, dissertation
            $table->unsignedBigInteger('cited_research_id'); // Referenced research ID
            $table->string('cited_research_type'); // student, faculty, thesis, dissertation
            $table->text('citation_context')->nullable(); // Why/how they used it
            $table->timestamps();
            
            $table->foreign('citing_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['cited_research_id', 'cited_research_type']);
            $table->index(['citing_user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('research_citations');
    }
};
