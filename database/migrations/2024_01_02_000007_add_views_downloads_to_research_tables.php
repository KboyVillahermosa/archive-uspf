<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_research', function (Blueprint $table) {
            $table->integer('views_count')->default(0);
            $table->integer('downloads_count')->default(0);
        });

        Schema::table('faculty_research', function (Blueprint $table) {
            $table->integer('views_count')->default(0);
            $table->integer('downloads_count')->default(0);
        });

        Schema::table('thesis', function (Blueprint $table) {
            $table->integer('views_count')->default(0);
            $table->integer('downloads_count')->default(0);
        });

        Schema::table('dissertations', function (Blueprint $table) {
            $table->integer('views_count')->default(0);
            $table->integer('downloads_count')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('student_research', function (Blueprint $table) {
            $table->dropColumn(['views_count', 'downloads_count']);
        });

        Schema::table('faculty_research', function (Blueprint $table) {
            $table->dropColumn(['views_count', 'downloads_count']);
        });

        Schema::table('thesis', function (Blueprint $table) {
            $table->dropColumn(['views_count', 'downloads_count']);
        });

        Schema::table('dissertations', function (Blueprint $table) {
            $table->dropColumn(['views_count', 'downloads_count']);
        });
    }
};
