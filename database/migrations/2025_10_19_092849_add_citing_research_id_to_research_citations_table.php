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
        Schema::table('research_citations', function (Blueprint $table) {
            $table->unsignedBigInteger('citing_research_id')->nullable()->after('citing_research_type');
            $table->index(['citing_research_id', 'citing_research_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('research_citations', function (Blueprint $table) {
            $table->dropIndex(['citing_research_id', 'citing_research_type']);
            $table->dropColumn('citing_research_id');
        });
    }
};
