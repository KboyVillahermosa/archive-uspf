<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing faculty user with department and course
        DB::table('users')
            ->where('email', 'faculty@uspf.edu.ph')
            ->update([
                'department' => 'College of Computer Studies',
                'course' => 'BSIT'
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')
            ->where('email', 'faculty@uspf.edu.ph')
            ->update([
                'department' => null,
                'course' => null
            ]);
    }
};
