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
        Schema::table('thesis', function (Blueprint $table) {
            $table->foreignId('adviser_id')->nullable()->after('user_id')->constrained('users')->onDelete('set null');
            $table->timestamp('adviser_approved_at')->nullable()->after('approved_at');
            $table->foreignId('adviser_approved_by')->nullable()->after('adviser_approved_at')->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('thesis', function (Blueprint $table) {
            $table->dropForeign(['adviser_id']);
            $table->dropForeign(['adviser_approved_by']);
            $table->dropColumn(['adviser_id', 'adviser_approved_at', 'adviser_approved_by']);
        });
    }
};
