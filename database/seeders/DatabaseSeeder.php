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
        // Seed roles and permissions first
        $this->call([
            RoleSeeder::class,
        ]);
        
        // Seed departments and programs if they don't exist
        if (\App\Models\Department::count() === 0) {
            $this->call([
                DepartmentProgramSeeder::class,
            ]);
        }
        
        // Seed research data (uncomment to seed research)
        // $this->call([
        //     ResearchSeeder::class,
        // ]);

        // Create student user (only if doesn't exist)
        $user = User::firstOrCreate(
            ['email' => 'fvillahermosa_ccs@uspf.edu.ph'],
            [
                'name' => 'Francisco Combong Villahermosa',
                'password' => Hash::make('password'),
                'role' => 'student',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        
        // Assign student role if not already assigned
        if (!$user->hasRole('student')) {
            $user->assignRole('student');
        }

        // Create student record (only if doesn't exist)
        Student::firstOrCreate(
            ['user_id' => $user->id],
            [
                'id_number' => '202200672',
                'first_name' => 'Francisco',
                'middle_name' => 'Combong',
                'last_name' => 'Villahermosa',
                'birthday' => '2003-03-25',
                'course_and_year' => 'BSIT 4',
            ]
        );

        // Create admin user (only if doesn't exist)
        $admin = User::firstOrCreate(
            ['email' => 'admin@uspf.edu.ph'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        
        // Assign admin role if not already assigned
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // Create faculty user (only if doesn't exist)
        $faculty = User::firstOrCreate(
            ['email' => 'faculty@uspf.edu.ph'],
            [
                'name' => 'Dr. Jane Smith',
                'password' => Hash::make('faculty123'),
                'role' => 'faculty',
                'status' => 'active',
                'department' => 'College of Computer Studies',
                'course' => 'BSIT',
                'email_verified_at' => now(),
            ]
        );
        
        // Assign faculty role if not already assigned
        if (!$faculty->hasRole('faculty')) {
            $faculty->assignRole('faculty');
        }
    }
}
