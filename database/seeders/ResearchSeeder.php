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
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ResearchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get departments and their programs
        $departments = Department::with('programs')->get();
        
        if ($departments->isEmpty()) {
            $this->command->warn('No departments found. Please run DepartmentProgramSeeder first.');
            return;
        }

        // Get admin user for approval
        $admin = User::whereHas('roles', function($q) {
            $q->where('name', 'admin');
        })->first();

        // Create users for each department
        $departmentUsers = $this->createUsersPerDepartment($departments);

        // JSON data structure for research
        $researchData = $this->getResearchData();

        // Seed Student Research
        $this->seedStudentResearch($researchData['student'], $departmentUsers['students'], $departments, $admin);

        // Seed Faculty Research
        $this->seedFacultyResearch($researchData['faculty'], $departmentUsers['faculty'], $departments, $admin);

        // Seed Thesis
        $this->seedThesis($researchData['thesis'], $departmentUsers['students'], $departments, $admin);

        // Seed Dissertation
        $this->seedDissertation($researchData['dissertation'], $departmentUsers['faculty'], $departments, $admin);

        $this->command->info('Research data seeded successfully!');
        $this->command->info('Student Research: ' . StudentResearch::count());
        $this->command->info('Faculty Research: ' . FacultyResearch::count());
        $this->command->info('Thesis: ' . Thesis::count());
        $this->command->info('Dissertations: ' . Dissertation::count());
    }

    /**
     * Create users for each department (2-3 per department)
     */
    private function createUsersPerDepartment($departments)
    {
        $studentUsers = collect();
        $facultyUsers = collect();

        foreach ($departments as $department) {
            // Create 2-3 student users per department
            $studentCount = rand(2, 3);
            $deptShortName = $department->short_name ?: $department->name;
            $deptShortNameClean = strtolower(str_replace(' ', '', $deptShortName));
            
            for ($i = 1; $i <= $studentCount; $i++) {
                $user = User::firstOrCreate(
                    [
                        'email' => $deptShortNameClean . "_student{$i}@uspf.edu.ph"
                    ],
                    [
                        'name' => "Student {$i} - {$deptShortName}",
                    'password' => Hash::make('password'),
                    'role' => 'student',
                    'status' => 'active',
                        'department' => $department->name,
                    'email_verified_at' => now(),
                    ]
                );
                if (!$user->hasRole('student')) {
                $user->assignRole('student');
                }
                $studentUsers->push($user);
            }

            // Create 2-3 faculty users per department
            $facultyCount = rand(2, 3);
            for ($i = 1; $i <= $facultyCount; $i++) {
                $user = User::firstOrCreate(
                    [
                        'email' => $deptShortNameClean . "_faculty{$i}@uspf.edu.ph"
                    ],
                    [
                        'name' => "Dr. Faculty {$i} - {$deptShortName}",
                    'password' => Hash::make('password'),
                    'role' => 'faculty',
                    'status' => 'active',
                        'department' => $department->name,
                    'email_verified_at' => now(),
                    ]
                );
                if (!$user->hasRole('faculty')) {
                $user->assignRole('faculty');
                }
                $facultyUsers->push($user);
            }
        }
        
        return [
            'students' => $studentUsers,
            'faculty' => $facultyUsers
        ];
    }

    /**
     * Get research data in JSON structure
     */
    private function getResearchData()
    {
        return [
            'student' => [
                ['title' => 'Machine Learning Applications in Healthcare', 'tags' => 'machine learning, healthcare, ai'],
                ['title' => 'Web-Based Inventory Management System', 'tags' => 'web development, inventory, system'],
                ['title' => 'Mobile Application for Student Information System', 'tags' => 'mobile app, student, information'],
                ['title' => 'E-Commerce Platform Using Laravel Framework', 'tags' => 'e-commerce, laravel, web'],
                ['title' => 'IoT-Based Smart Home Automation', 'tags' => 'iot, automation, smart home'],
                ['title' => 'Data Mining Techniques for Customer Analysis', 'tags' => 'data mining, analysis, customer'],
                ['title' => 'Cloud Computing Security Analysis', 'tags' => 'cloud computing, security, analysis'],
                ['title' => 'Blockchain Technology in Supply Chain Management', 'tags' => 'blockchain, supply chain, management'],
                ['title' => 'Artificial Intelligence in Education', 'tags' => 'ai, education, technology'],
                ['title' => 'Cybersecurity Threats and Prevention Methods', 'tags' => 'cybersecurity, threats, prevention'],
                ['title' => 'Database Optimization Techniques', 'tags' => 'database, optimization, techniques'],
                ['title' => 'User Interface Design for Mobile Applications', 'tags' => 'ui, design, mobile'],
                ['title' => 'Social Media Analytics Platform', 'tags' => 'social media, analytics, platform'],
                ['title' => 'Automated Testing Framework', 'tags' => 'testing, automation, framework'],
                ['title' => 'Network Security Protocols Analysis', 'tags' => 'network, security, protocols'],
            ],
            'faculty' => [
                ['title' => 'Advanced Algorithms for Data Processing', 'tags' => 'algorithms, data processing, advanced'],
                ['title' => 'Sustainable Energy Solutions in Urban Planning', 'tags' => 'energy, sustainability, urban'],
                ['title' => 'Pedagogical Approaches in Digital Learning', 'tags' => 'pedagogy, digital learning, education'],
                ['title' => 'Healthcare Information Systems Integration', 'tags' => 'healthcare, information systems, integration'],
                ['title' => 'Machine Learning in Financial Forecasting', 'tags' => 'machine learning, finance, forecasting'],
                ['title' => 'Cybersecurity Framework for Educational Institutions', 'tags' => 'cybersecurity, framework, education'],
                ['title' => 'Human-Computer Interaction Research', 'tags' => 'hci, interaction, research'],
                ['title' => 'Database Management Systems Optimization', 'tags' => 'database, management, optimization'],
                ['title' => 'Software Engineering Best Practices', 'tags' => 'software engineering, best practices'],
                ['title' => 'Network Architecture for Cloud Computing', 'tags' => 'network, architecture, cloud'],
                ['title' => 'Data Analytics in Business Intelligence', 'tags' => 'data analytics, business, intelligence'],
                ['title' => 'Mobile Computing Security Protocols', 'tags' => 'mobile, computing, security'],
            ],
            'thesis' => [
                ['title' => 'The Impact of Social Media on Academic Performance', 'keywords' => 'Social Media, Academic Performance, Education'],
                ['title' => 'E-Learning Platform Development and Implementation', 'keywords' => 'E-Learning, Platform, Development'],
                ['title' => 'Customer Relationship Management System', 'keywords' => 'CRM, Management, System'],
                ['title' => 'Library Management System with RFID Technology', 'keywords' => 'Library, RFID, Management'],
                ['title' => 'Online Examination System with Proctoring', 'keywords' => 'Examination, Online, Proctoring'],
                ['title' => 'Hospital Management Information System', 'keywords' => 'Hospital, Management, Information'],
                ['title' => 'Student Portal Development', 'keywords' => 'Student, Portal, Development'],
                ['title' => 'E-Commerce Website with Payment Gateway Integration', 'keywords' => 'E-Commerce, Payment, Gateway'],
                ['title' => 'Content Management System for Educational Institutions', 'keywords' => 'CMS, Education, Management'],
                ['title' => 'Attendance Monitoring System Using Biometrics', 'keywords' => 'Attendance, Biometrics, Monitoring'],
                ['title' => 'Document Management System', 'keywords' => 'Document, Management, System'],
                ['title' => 'Event Management System', 'keywords' => 'Event, Management, System'],
                ['title' => 'Hotel Reservation System', 'keywords' => 'Hotel, Reservation, System'],
                ['title' => 'Pharmacy Management System', 'keywords' => 'Pharmacy, Management, System'],
                ['title' => 'School Management Information System', 'keywords' => 'School, Management, Information'],
            ],
            'dissertation' => [
                ['title' => 'Educational Technology Integration in Higher Education', 'keywords' => 'Education, Technology, Integration'],
                ['title' => 'Leadership Styles and Organizational Performance', 'keywords' => 'Leadership, Organization, Performance'],
                ['title' => 'Curriculum Development in Digital Age', 'keywords' => 'Curriculum, Development, Digital'],
                ['title' => 'Student Engagement Strategies in Online Learning', 'keywords' => 'Student, Engagement, Online'],
                ['title' => 'Assessment Methods in Modern Education', 'keywords' => 'Assessment, Methods, Education'],
                ['title' => 'Teacher Professional Development Programs', 'keywords' => 'Teacher, Development, Programs'],
                ['title' => 'Educational Policy Implementation Analysis', 'keywords' => 'Education, Policy, Implementation'],
                ['title' => 'Learning Outcomes Measurement Framework', 'keywords' => 'Learning, Outcomes, Measurement'],
                ['title' => 'Inclusive Education Practices', 'keywords' => 'Inclusive, Education, Practices'],
                ['title' => 'Educational Research Methodology', 'keywords' => 'Education, Research, Methodology'],
                ['title' => 'Technology-Enhanced Learning Environments', 'keywords' => 'Technology, Learning, Environments'],
                ['title' => 'Educational Administration and Management', 'keywords' => 'Education, Administration, Management'],
            ]
        ];
    }

    /**
     * Seed Student Research
     */
    private function seedStudentResearch($data, $users, $departments, $admin)
    {
        // Exclude fvillahermosa account from research assignments
        $excludedEmails = ['fvillahermosa_ccs@uspf.edu.ph'];
        $availableUsers = $users->reject(function($user) use ($excludedEmails) {
            return in_array($user->email, $excludedEmails);
        });
        
        if ($availableUsers->isEmpty()) {
            $this->command->warn('No available users for student research (all excluded).');
            return;
        }
        
        foreach ($data as $index => $item) {
            $status = ['pending', 'approved', 'rejected'][rand(0, 2)];
            $user = $availableUsers->random();
            
            // Get department and assign 2-3 programs from that department
            $department = $departments->random();
            $departmentPrograms = $department->programs;
            
            if ($departmentPrograms->isEmpty()) {
                continue;
            }
            
            // Select 2-3 programs (or all if less than 2)
            $programCount = min(rand(2, 3), $departmentPrograms->count());
            $selectedProgram = $departmentPrograms->random();
            
            // Create dummy PDF files
            $pdfPath = $this->createDummyPdf('research/student', "student_research_{$index}.pdf");
            $abstractPath = $this->createDummyPdf('research/abstracts', "student_abstract_{$index}.pdf");
            $bannerPath = $this->createDummyBanner('banners/student', "student_banner_{$index}.jpg", 'tech');

            StudentResearch::create([
                'title' => $item['title'],
                'authors' => $this->generateAuthors($user->name, rand(1, 3)),
                'department' => $department->name,
                'program' => $selectedProgram->name,
                'banner_image' => $bannerPath,
                'research_file' => $pdfPath,
                'abstract_file' => $abstractPath,
                'abstract' => $this->generateAbstract($item['title']),
                'tags' => $item['tags'],
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
    }

    /**
     * Seed Faculty Research
     */
    private function seedFacultyResearch($data, $users, $departments, $admin)
    {
        // Exclude fvillahermosa account from research assignments
        $excludedEmails = ['fvillahermosa_ccs@uspf.edu.ph'];
        $availableUsers = $users->reject(function($user) use ($excludedEmails) {
            return in_array($user->email, $excludedEmails);
        });
        
        if ($availableUsers->isEmpty()) {
            $this->command->warn('No available users for faculty research (all excluded).');
            return;
        }
        
        foreach ($data as $index => $item) {
            $status = ['pending', 'approved', 'rejected'][rand(0, 2)];
            $user = $availableUsers->random();
            $department = $departments->random();
            
            // Create dummy PDF files
            $pdfPath = $this->createDummyPdf('research/faculty', "faculty_research_{$index}.pdf");
            $abstractPath = $this->createDummyPdf('research/abstracts', "faculty_abstract_{$index}.pdf");
            $bannerPath = $this->createDummyBanner('banners/faculty', "faculty_banner_{$index}.jpg", 'edu');

            FacultyResearch::create([
                'title' => $item['title'],
                'co_researchers' => $this->generateCoResearchers(rand(1, 3)),
                'department' => $department->name,
                'banner_image' => $bannerPath,
                'research_file' => $pdfPath,
                'abstract_file' => $abstractPath,
                'abstract' => $this->generateAbstract($item['title']),
                'tags' => $item['tags'],
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
    }

    /**
     * Seed Thesis
     */
    private function seedThesis($data, $users, $departments, $admin)
    {
        // Exclude fvillahermosa account from research assignments
        $excludedEmails = ['fvillahermosa_ccs@uspf.edu.ph'];
        $availableUsers = $users->reject(function($user) use ($excludedEmails) {
            return in_array($user->email, $excludedEmails);
        });
        
        if ($availableUsers->isEmpty()) {
            $this->command->warn('No available users for thesis (all excluded).');
            return;
        }
        
        foreach ($data as $index => $item) {
            $status = ['pending', 'approved', 'rejected'][rand(0, 2)];
            $user = $availableUsers->random();
            $department = $departments->random();
            $departmentPrograms = $department->programs->where('degree_level', 'Bachelor');
            
            if ($departmentPrograms->isEmpty()) {
                $departmentPrograms = $department->programs;
            }
            
            if ($departmentPrograms->isEmpty()) {
                continue;
            }
            
            $selectedProgram = $departmentPrograms->random();
            $yearCompleted = rand(2020, 2024);
            
            // Create dummy PDF files
            $pdfPath = $this->createDummyPdf('thesis', "thesis_{$index}.pdf");
            $abstractPath = $this->createDummyPdf('research/abstracts', "thesis_abstract_{$index}.pdf");
            $bannerPath = $this->createDummyBanner('banners/thesis', "thesis_banner_{$index}.jpg", 'edu');

            Thesis::create([
                'title' => $item['title'],
                'author' => $user->name,
                'department' => $department->name,
                'program' => $selectedProgram->name,
                'banner_image' => $bannerPath,
                'year_completed' => $yearCompleted,
                'keywords' => $item['keywords'],
                'document_file' => $pdfPath,
                'abstract_file' => $abstractPath,
                'abstract' => $this->generateAbstract($item['title']),
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
    }

    /**
     * Seed Dissertation
     */
    private function seedDissertation($data, $users, $departments, $admin)
    {
        // Exclude fvillahermosa account from research assignments
        $excludedEmails = ['fvillahermosa_ccs@uspf.edu.ph'];
        $availableUsers = $users->reject(function($user) use ($excludedEmails) {
            return in_array($user->email, $excludedEmails);
        });
        
        if ($availableUsers->isEmpty()) {
            $this->command->warn('No available users for dissertation (all excluded).');
            return;
        }
        
        foreach ($data as $index => $item) {
            $status = ['pending', 'approved', 'rejected'][rand(0, 2)];
            $user = $availableUsers->random();
            $department = $departments->random();
            $departmentPrograms = $department->programs->where('degree_level', 'Doctor');
            
            if ($departmentPrograms->isEmpty()) {
                // Fallback to any program if no doctoral program
                $departmentPrograms = $department->programs->where('degree_level', 'Master');
            }
            
            if ($departmentPrograms->isEmpty()) {
                $selectedProgram = 'Doctor of Education major in Educational Management';
            } else {
                $selectedProgram = $departmentPrograms->random()->name;
            }
            
            $yearCompleted = rand(2019, 2024);
            
            // Create dummy PDF files
            $pdfPath = $this->createDummyPdf('dissertations', "dissertation_{$index}.pdf");
            $abstractPath = $this->createDummyPdf('research/abstracts', "dissertation_abstract_{$index}.pdf");
            $bannerPath = $this->createDummyBanner('banners/dissertation', "dissertation_banner_{$index}.jpg", 'edu');

            Dissertation::create([
                'title' => $item['title'],
                'author' => $user->name,
                'department' => $department->name,
                'program' => $selectedProgram,
                'banner_image' => $bannerPath,
                'year_completed' => $yearCompleted,
                'keywords' => $item['keywords'],
                'document_file' => $pdfPath,
                'abstract_file' => $abstractPath,
                'abstract' => $this->generateAbstract($item['title']),
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
    }

    /**
     * Create dummy PDF file
     */
    private function createDummyPdf($directory, $filename)
    {
        $path = $directory . '/' . $filename;
        
        // Create directory if it doesn't exist
        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }
        
        // Check if file already exists
        if (Storage::disk('public')->exists($path)) {
            return $path;
        }
        
        // Create a more complete PDF with actual content
        $pdfContent = "%PDF-1.4\n";
        $pdfContent .= "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n";
        $pdfContent .= "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n";
        $pdfContent .= "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 << /Type /Font /Subtype /Type1 /BaseFont /Helvetica >> >> >> >>\nendobj\n";
        
        // Add more content to the PDF
        $text = "Research Document\n\nThis is a sample research document.\n\n";
        $text .= "Title: Sample Research\n";
        $text .= "Author: Research Team\n";
        $text .= "Date: " . date('Y-m-d') . "\n\n";
        $text .= "Abstract:\n";
        $text .= "This document contains sample research content for testing purposes.\n";
        $text .= "It includes various sections and demonstrates the structure of a research paper.\n\n";
        $text .= "Introduction\n";
        $text .= "This section introduces the research topic and provides background information.\n\n";
        $text .= "Methodology\n";
        $text .= "This section describes the research methods and approaches used.\n\n";
        $text .= "Results\n";
        $text .= "This section presents the findings and results of the research.\n\n";
        $text .= "Conclusion\n";
        $text .= "This section summarizes the key findings and provides recommendations.\n";
        
        $textLength = strlen($text);
        $pdfContent .= "4 0 obj\n<< /Length {$textLength} >>\nstream\nBT\n/F1 12 Tf\n50 750 Td\n";
        $pdfContent .= str_replace("\n", " T*\n", $text);
        $pdfContent .= "ET\nendstream\nendobj\n";
        
        $pdfContent .= "xref\n0 5\n0000000000 65535 f \n0000000009 00000 n \n0000000058 00000 n \n0000000115 00000 n \n";
        $xrefOffset = strlen($pdfContent);
        $pdfContent .= sprintf("%010d 00000 n \n", $xrefOffset);
        $pdfContent .= "trailer\n<< /Size 5 /Root 1 0 R >>\nstartxref\n" . ($xrefOffset + 10) . "\n%%EOF";
        
        Storage::disk('public')->put($path, $pdfContent);
        
        $this->command->info("Created PDF: {$path}");
        
        return $path;
    }

    /**
     * Create dummy banner image
     */
    private function createDummyBanner($directory, $filename, $type = 'tech')
    {
        $path = $directory . '/' . $filename;
        
        // Create directory if it doesn't exist
        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }
        
        // Check if our high-quality samples exist and use them
        $samplePath = $type === 'tech' ? 'banners/samples/tech_banner.png' : 'banners/samples/education_banner.png';
        if (Storage::disk('public')->exists($samplePath)) {
            Storage::disk('public')->copy($samplePath, $path);
            return $path;
        }

        // Check if file already exists
        if (Storage::disk('public')->exists($path)) {
            return $path;
        }
        
        // Try to use GD library to create an image
        if (extension_loaded('gd')) {
            // Create a 1200x400 banner image
            $width = 1200;
            $height = 400;
            $image = imagecreatetruecolor($width, $height);
            
            // Set colors
            $bgColor = imagecolorallocate($image, 38, 34, 92); // #26225C
            $textColor = imagecolorallocate($image, 255, 199, 44); // #FFC72C
            $white = imagecolorallocate($image, 255, 255, 255);
            
            // Fill background
            imagefill($image, 0, 0, $bgColor);
            
            // Add some decorative elements
            imagefilledrectangle($image, 0, 0, $width, 80, $textColor);
            imagefilledrectangle($image, 0, $height - 80, $width, $height, $textColor);
            
            // Add text
            $text = "Research Banner";
            $fontSize = 5; // Use built-in font
            $textX = ($width - imagefontwidth($fontSize) * strlen($text)) / 2;
            $textY = ($height - imagefontheight($fontSize)) / 2;
            imagestring($image, $fontSize, $textX, $textY, $text, $white);
            
            // Save as PNG
            ob_start();
            imagepng($image);
            $pngContent = ob_get_contents();
            ob_end_clean();
            imagedestroy($image);
            
            Storage::disk('public')->put($path, $pngContent);
        } else {
            // Fallback: Create a simple valid PNG using a known working base64 image
            // This is a 1x1 pixel PNG that we'll scale conceptually
            // For a better visible image, we'll create a simple colored PNG
            $this->command->warn("GD library not available. Creating minimal PNG image.");
            
            // Create a simple 800x300 PNG with solid color
            // Using a pre-encoded valid PNG structure
            // This is a minimal valid PNG (1x1 pixel, will be stretched by browser)
            $pngContent = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');
            
            // Try to create a better PNG manually
            // Create a valid 800x300 PNG
            $width = 800;
            $height = 300;
            
            // PNG signature
            $png = "\x89PNG\r\n\x1a\n";
            
            // IHDR chunk
            $ihdrData = pack("NN", $width, $height) . "\x08\x06\x00\x00\x00";
            $ihdrChunk = "IHDR" . $ihdrData;
            $png .= pack("N", strlen($ihdrData)) . $ihdrChunk . pack("N", crc32($ihdrChunk));
            
            // Create image data (RGBA format)
            $imageData = '';
            for ($y = 0; $y < $height; $y++) {
                $imageData .= "\x00"; // Filter: None
                for ($x = 0; $x < $width; $x++) {
                    // Use brand color #26225C (38, 34, 92) with full alpha
                    $imageData .= "\x26\x22\x5C\xFF";
                }
            }
            
            // Compress the image data
            $compressed = gzcompress($imageData, 9);
            $idatChunk = "IDAT" . $compressed;
            $png .= pack("N", strlen($compressed)) . $idatChunk . pack("N", crc32($idatChunk));
            
            // IEND chunk
            $png .= pack("N", 0) . "IEND" . "\xAE\x42\x60\x82";
            
            Storage::disk('public')->put($path, $png);
        }
        
        $this->command->info("Created banner image: {$path}");
        
        return $path;
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
}
