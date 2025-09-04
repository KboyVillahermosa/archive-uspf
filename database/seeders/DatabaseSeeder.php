<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create student user
        $user = User::factory()->create([
            'name' => 'Francisco Combong Villahermosa',
            'email' => 'fvillahermosa_ccs@uspf.edu.ph',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        // Create student record
        Student::create([
            'id_number' => '202200672',
            'first_name' => 'Francisco',
            'middle_name' => 'Combong',
            'last_name' => 'Villahermosa',
            'birthday' => '2003-03-25',
            'course_and_year' => 'BSIT 4',
            'user_id' => $user->id,
        ]);

        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@uspf.edu.ph',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create faculty user
        User::factory()->create([
            'name' => 'Dr. Jane Smith',
            'email' => 'faculty@uspf.edu.ph',
            'password' => Hash::make('faculty123'),
            'role' => 'faculty',
        ]);
    }
}
