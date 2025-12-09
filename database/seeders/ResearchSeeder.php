<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\StudentResearch;
use App\Models\FacultyResearch;
use App\Models\Thesis;
use App\Models\Dissertation;
use App\Models\Department;
use App\Models\Program;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ResearchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create departments and programs
        $departments = Department::all();
        $programs = Program::all();
        
        // Get existing users or create test users
        $studentUsers = User::whereHas('roles', function($q) {
            $q->where('name', 'student');
        })->get();
        
        $facultyUsers = User::whereHas('roles', function($q) {
            $q->where('name', 'faculty');
        })->get();
        
        // If no users exist, create some
        if ($studentUsers->isEmpty()) {
            for ($i = 1; $i <= 5; $i++) {
                $user = User::create([
                    'name' => "Student User $i",
                    'email' => "student$i@uspf.edu.ph",
                    'password' => Hash::make('password'),
                    'role' => 'student',
                    'status' => 'active',
                    'email_verified_at' => now(),
                ]);
                $user->assignRole('student');
                $studentUsers->push($user);
            }
        }
        
        if ($facultyUsers->isEmpty()) {
            for ($i = 1; $i <= 3; $i++) {
                $user = User::create([
                    'name' => "Dr. Faculty User $i",
                    'email' => "faculty$i@uspf.edu.ph",
                    'password' => Hash::make('password'),
                    'role' => 'faculty',
                    'status' => 'active',
                    'department' => $departments->random()->name ?? 'College of Computer Studies',
                    'email_verified_at' => now(),
                ]);
                $user->assignRole('faculty');
                $facultyUsers->push($user);
            }
        }
        
        // Get admin user for approval
        $admin = User::whereHas('roles', function($q) {
            $q->where('name', 'admin');
        })->first();
        
        // Sample departments
        $sampleDepartments = [
            'College of Computer Studies',
            'College of Engineering and Architecture',
            'College of Health Sciences',
            'College of Teacher Education, Arts and Sciences',
            'School of Business and Accountancy',
        ];
        
        // Sample programs
        $samplePrograms = [
            'Bachelor of Science in Information Technology',
            'Bachelor of Science in Computer Science',
            'Bachelor of Science in Civil Engineering',
            'Bachelor of Science in Nursing',
            'Bachelor of Elementary Education',
            'Bachelor of Science in Business Administration',
        ];
        
        // Seed Student Research
        $studentResearchTitles = [
            'Machine Learning Applications in Healthcare',
            'Web-Based Inventory Management System',
            'Mobile Application for Student Information System',
            'E-Commerce Platform Using Laravel Framework',
            'IoT-Based Smart Home Automation',
            'Data Mining Techniques for Customer Analysis',
            'Cloud Computing Security Analysis',
            'Blockchain Technology in Supply Chain Management',
            'Artificial Intelligence in Education',
            'Cybersecurity Threats and Prevention Methods',
            'Database Optimization Techniques',
            'User Interface Design for Mobile Applications',
            'Social Media Analytics Platform',
            'Automated Testing Framework',
            'Network Security Protocols Analysis',
        ];
        
        foreach ($studentResearchTitles as $index => $title) {
            $status = ['pending', 'approved', 'rejected'][rand(0, 2)];
            $user = $studentUsers->random();
            $department = $sampleDepartments[array_rand($sampleDepartments)];
            $program = $samplePrograms[array_rand($samplePrograms)];
            
            $research = StudentResearch::create([
                'title' => $title,
                'authors' => $this->generateAuthors($user->name, rand(1, 3)),
                'department' => $department,
                'program' => $program,
                'banner_image' => null,
                'research_file' => 'sample_research_' . ($index + 1) . '.pdf',
                'abstract' => $this->generateAbstract($title),
                'tags' => $this->generateTags($title),
                'status' => $status,
                'admin_notes' => $status === 'rejected' ? 'Needs revision in methodology section.' : null,
                'user_id' => $user->id,
                'approved_by' => $status === 'approved' && $admin ? $admin->id : null,
                'approved_at' => $status === 'approved' ? Carbon::now()->subDays(rand(1, 90)) : null,
                'views_count' => $status === 'approved' ? rand(10, 500) : rand(0, 10),
                'downloads_count' => $status === 'approved' ? rand(5, 200) : 0,
                'created_at' => Carbon::now()->subDays(rand(1, 180)),
            ]);
        }
        
        // Seed Faculty Research
        $facultyResearchTitles = [
            'Advanced Algorithms for Data Processing',
            'Sustainable Energy Solutions in Urban Planning',
            'Pedagogical Approaches in Digital Learning',
            'Healthcare Information Systems Integration',
            'Machine Learning in Financial Forecasting',
            'Cybersecurity Framework for Educational Institutions',
            'Human-Computer Interaction Research',
            'Database Management Systems Optimization',
            'Software Engineering Best Practices',
            'Network Architecture for Cloud Computing',
            'Data Analytics in Business Intelligence',
            'Mobile Computing Security Protocols',
        ];
        
        foreach ($facultyResearchTitles as $index => $title) {
            $status = ['pending', 'approved', 'rejected'][rand(0, 2)];
            $user = $facultyUsers->random();
            $department = $sampleDepartments[array_rand($sampleDepartments)];
            
            $research = FacultyResearch::create([
                'title' => $title,
                'co_researchers' => $this->generateCoResearchers(rand(1, 3)),
                'department' => $department,
                'banner_image' => null,
                'research_file' => 'faculty_research_' . ($index + 1) . '.pdf',
                'abstract' => $this->generateAbstract($title),
                'tags' => $this->generateTags($title),
                'status' => $status,
                'admin_notes' => $status === 'rejected' ? 'Please provide more detailed methodology.' : null,
                'user_id' => $user->id,
                'approved_by' => $status === 'approved' && $admin ? $admin->id : null,
                'approved_at' => $status === 'approved' ? Carbon::now()->subDays(rand(1, 120)) : null,
                'views_count' => $status === 'approved' ? rand(20, 800) : rand(0, 15),
                'downloads_count' => $status === 'approved' ? rand(10, 300) : 0,
                'created_at' => Carbon::now()->subDays(rand(1, 150)),
            ]);
        }
        
        // Seed Thesis
        $thesisTitles = [
            'The Impact of Social Media on Academic Performance',
            'E-Learning Platform Development and Implementation',
            'Customer Relationship Management System',
            'Library Management System with RFID Technology',
            'Online Examination System with Proctoring',
            'Hospital Management Information System',
            'Student Portal Development',
            'E-Commerce Website with Payment Gateway Integration',
            'Content Management System for Educational Institutions',
            'Attendance Monitoring System Using Biometrics',
            'Document Management System',
            'Event Management System',
            'Hotel Reservation System',
            'Pharmacy Management System',
            'School Management Information System',
        ];
        
        foreach ($thesisTitles as $index => $title) {
            $status = ['pending', 'approved', 'rejected'][rand(0, 2)];
            $user = $studentUsers->random();
            $department = $sampleDepartments[array_rand($sampleDepartments)];
            $program = $samplePrograms[array_rand($samplePrograms)];
            $yearCompleted = rand(2020, 2024);
            
            $thesis = Thesis::create([
                'title' => $title,
                'author' => $user->name,
                'department' => $department,
                'program' => $program,
                'year_completed' => $yearCompleted,
                'keywords' => $this->generateKeywords($title),
                'document_file' => 'thesis_' . ($index + 1) . '.pdf',
                'abstract' => $this->generateAbstract($title),
                'status' => $status,
                'admin_notes' => $status === 'rejected' ? 'Abstract needs improvement.' : null,
                'user_id' => $user->id,
                'approved_by' => $status === 'approved' && $admin ? $admin->id : null,
                'approved_at' => $status === 'approved' ? Carbon::now()->subDays(rand(1, 200)) : null,
                'views_count' => $status === 'approved' ? rand(15, 600) : rand(0, 12),
                'downloads_count' => $status === 'approved' ? rand(8, 250) : 0,
                'created_at' => Carbon::now()->subDays(rand(1, 365)),
            ]);
        }
        
        // Seed Dissertation
        $dissertationTitles = [
            'Educational Technology Integration in Higher Education',
            'Leadership Styles and Organizational Performance',
            'Curriculum Development in Digital Age',
            'Student Engagement Strategies in Online Learning',
            'Assessment Methods in Modern Education',
            'Teacher Professional Development Programs',
            'Educational Policy Implementation Analysis',
            'Learning Outcomes Measurement Framework',
            'Inclusive Education Practices',
            'Educational Research Methodology',
            'Technology-Enhanced Learning Environments',
            'Educational Administration and Management',
        ];
        
        foreach ($dissertationTitles as $index => $title) {
            $status = ['pending', 'approved', 'rejected'][rand(0, 2)];
            $user = $facultyUsers->random();
            $department = $sampleDepartments[array_rand($sampleDepartments)];
            $program = 'Doctor of Education major in Educational Management';
            $yearCompleted = rand(2019, 2024);
            
            $dissertation = Dissertation::create([
                'title' => $title,
                'author' => $user->name,
                'department' => $department,
                'program' => $program,
                'year_completed' => $yearCompleted,
                'keywords' => $this->generateKeywords($title),
                'document_file' => 'dissertation_' . ($index + 1) . '.pdf',
                'abstract' => $this->generateAbstract($title),
                'status' => $status,
                'admin_notes' => $status === 'rejected' ? 'Literature review section needs expansion.' : null,
                'user_id' => $user->id,
                'approved_by' => $status === 'approved' && $admin ? $admin->id : null,
                'approved_at' => $status === 'approved' ? Carbon::now()->subDays(rand(1, 300)) : null,
                'views_count' => $status === 'approved' ? rand(25, 1000) : rand(0, 20),
                'downloads_count' => $status === 'approved' ? rand(12, 400) : 0,
                'created_at' => Carbon::now()->subDays(rand(1, 500)),
            ]);
        }
        
        $this->command->info('Research data seeded successfully!');
        $this->command->info('Student Research: ' . StudentResearch::count());
        $this->command->info('Faculty Research: ' . FacultyResearch::count());
        $this->command->info('Thesis: ' . Thesis::count());
        $this->command->info('Dissertations: ' . Dissertation::count());
    }
    
    private function generateAuthors($primaryAuthor, $count)
    {
        $authors = [$primaryAuthor];
        $firstNames = ['John', 'Jane', 'Michael', 'Sarah', 'David', 'Emily', 'Robert', 'Jessica', 'William', 'Amanda'];
        $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez'];
        
        for ($i = 1; $i < $count; $i++) {
            $authors[] = $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
        }
        
        return implode(', ', $authors);
    }
    
    private function generateCoResearchers($count)
    {
        $researchers = [];
        $titles = ['Dr.', 'Prof.', 'Mr.', 'Ms.'];
        $firstNames = ['John', 'Jane', 'Michael', 'Sarah', 'David', 'Emily', 'Robert', 'Jessica'];
        $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis'];
        
        for ($i = 0; $i < $count; $i++) {
            $researchers[] = $titles[array_rand($titles)] . ' ' . $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
        }
        
        return implode(', ', $researchers);
    }
    
    private function generateAbstract($title)
    {
        return "This research study focuses on " . strtolower($title) . ". The study aims to investigate and analyze various aspects related to this topic. Through comprehensive data collection and analysis, this research provides valuable insights and recommendations. The methodology employed includes both qualitative and quantitative approaches to ensure a thorough examination of the subject matter. The findings contribute to the existing body of knowledge and offer practical implications for future research and implementation.";
    }
    
    private function generateTags($title)
    {
        $tags = [];
        $titleWords = explode(' ', strtolower($title));
        
        // Extract meaningful words (length > 3)
        foreach ($titleWords as $word) {
            $cleanWord = preg_replace('/[^a-z]/', '', $word);
            if (strlen($cleanWord) > 3) {
                $tags[] = $cleanWord;
            }
        }
        
        // Add some common research tags
        $commonTags = ['research', 'study', 'analysis', 'system', 'technology', 'education', 'management', 'development'];
        $tags = array_merge($tags, array_slice($commonTags, 0, rand(2, 4)));
        
        return implode(', ', array_unique($tags));
    }
    
    private function generateKeywords($title)
    {
        $keywords = [];
        $titleWords = explode(' ', strtolower($title));
        
        // Extract key words
        foreach ($titleWords as $word) {
            $cleanWord = preg_replace('/[^a-z]/', '', $word);
            if (strlen($cleanWord) > 4) {
                $keywords[] = ucfirst($cleanWord);
            }
        }
        
        // Add some related keywords
        $relatedKeywords = ['Technology', 'System', 'Management', 'Analysis', 'Implementation', 'Development', 'Research'];
        $keywords = array_merge($keywords, array_slice($relatedKeywords, 0, rand(2, 3)));
        
        return implode(', ', array_unique($keywords));
    }
}

