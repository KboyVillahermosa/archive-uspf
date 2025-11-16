<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Program;

class DepartmentProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create departments
        $departments = [
            [
                'name' => 'College of Engineering and Architecture',
                'short_name' => 'CEA',
                'programs' => [
                    ['name' => 'Bachelor of Science in Civil Engineering', 'degree_level' => 'Bachelor'],
                    ['name' => 'Bachelor of Science in Geodetic Engineering', 'degree_level' => 'Bachelor'],
                    ['name' => 'Bachelor of Science in Architecture', 'degree_level' => 'Bachelor'],
                ]
            ],
            [
                'name' => 'College of Computer Studies',
                'short_name' => 'CCS',
                'programs' => [
                    ['name' => 'Bachelor of Science in Information Technology', 'degree_level' => 'Bachelor'],
                    ['name' => 'Bachelor of Science in Computer Science', 'degree_level' => 'Bachelor'],
                ]
            ],
            [
                'name' => 'College of Health Sciences',
                'short_name' => 'CHS',
                'programs' => [
                    ['name' => 'Bachelor of Science in Nursing', 'degree_level' => 'Bachelor'],
                    ['name' => 'Bachelor of Science in Pharmacy', 'degree_level' => 'Bachelor'],
                ]
            ],
            [
                'name' => 'College of Social Work',
                'short_name' => 'CSW',
                'programs' => [
                    ['name' => 'College of Social Work', 'degree_level' => 'Bachelor'],
                    ['name' => 'Master of Science in Social Work', 'degree_level' => 'Master'],
                ]
            ],
            [
                'name' => 'College of Teacher Education, Arts and Sciences',
                'short_name' => 'CTEAS',
                'programs' => [
                    ['name' => 'Bachelor of Elementary Education', 'degree_level' => 'Bachelor'],
                    ['name' => 'Bachelor of Secondary Education', 'degree_level' => 'Bachelor'],
                    ['name' => 'Bachelor of Arts in English Language Studies', 'degree_level' => 'Bachelor'],
                    ['name' => 'Bachelor of Arts in Literature and Cultural Studies', 'degree_level' => 'Bachelor'],
                    ['name' => 'Bachelor of Arts in Music', 'degree_level' => 'Bachelor'],
                    ['name' => 'Bachelor of Arts in Political Science', 'degree_level' => 'Bachelor'],
                    ['name' => 'Master of Arts in Education major in Educational Management', 'degree_level' => 'Master'],
                    ['name' => 'Master of Arts in Education major in Curriculum and Instruction', 'degree_level' => 'Master'],
                    ['name' => 'Master of Arts in Education major in Elementary Education', 'degree_level' => 'Master'],
                    ['name' => 'Master of Arts in Education major in Early Childhood Education', 'degree_level' => 'Master'],
                    ['name' => 'Master of Arts in Education major in Math Education', 'degree_level' => 'Master'],
                    ['name' => 'Master of Arts in Education major in Science Education', 'degree_level' => 'Master'],
                    ['name' => 'Master of Arts in Education major in English Language Teaching', 'degree_level' => 'Master'],
                    ['name' => 'Master of Arts in Education major in Physical Education', 'degree_level' => 'Master'],
                    ['name' => 'Master of Arts in Education major in Special Education', 'degree_level' => 'Master'],
                ]
            ],
            [
                'name' => 'School of Business and Accountancy',
                'short_name' => 'SBA',
                'programs' => [
                    ['name' => 'Bachelor of Science in Tourism Management', 'degree_level' => 'Bachelor'],
                    ['name' => 'Bachelor of Science in Hospitality Management', 'degree_level' => 'Bachelor'],
                    ['name' => 'Bachelor of Science in Accountancy', 'degree_level' => 'Bachelor'],
                    ['name' => 'Bachelor of Science in Business Administration', 'degree_level' => 'Bachelor'],
                    ['name' => 'Master of Business Administration', 'degree_level' => 'Master'],
                ]
            ],
            [
                'name' => 'Graduate School',
                'short_name' => 'GS',
                'programs' => [
                    ['name' => 'Doctor of Education major in Educational Management', 'degree_level' => 'Doctor'],
                ]
            ],
        ];

        foreach ($departments as $deptData) {
            $department = Department::create([
                'name' => $deptData['name'],
                'short_name' => $deptData['short_name'],
            ]);

            foreach ($deptData['programs'] as $programData) {
                Program::create([
                    'name' => $programData['name'],
                    'degree_level' => $programData['degree_level'],
                    'department_id' => $department->id,
                ]);
            }
        }

        $this->command->info('Departments and Programs seeded successfully!');
    }
}
