<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\\Contracts\\Console\\Kernel')->bootstrap();

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

// Create the permission
$permission = Permission::firstOrCreate([
    'name' => 'manage department users',
    'guard_name' => 'web'
]);

echo "Permission 'manage department users' exists.\n";

// Get or create faculty role
$facultyRole = Role::firstOrCreate([
    'name' => 'faculty',
    'guard_name' => 'web'
]);

// Assign permission to role
if (!$facultyRole->hasPermissionTo('manage department users')) {
    $facultyRole->givePermissionTo('manage department users');
    echo "Assigned permission to faculty role.\n";
} else {
    echo "Faculty role already has permission.\n";
}

// Find faculty user
$faculty = User::where('email', 'faculty@uspf.edu.ph')->first();

if ($faculty) {
    // Assign role
    if (!$faculty->hasRole('faculty')) {
        $faculty->assignRole('faculty');
        echo "Assigned faculty role to user.\n";
    }
    
    // Assign permission directly
    if (!$faculty->hasPermissionTo('manage department users')) {
        $faculty->givePermissionTo('manage department users');
        echo "Assigned permission directly to user.\n";
    }
    
    // Update department info
    $faculty->update([
        'department' => 'College of Computer Studies',
        'course' => 'BSIT'
    ]);
    
    echo "Faculty user configured successfully!\n";
    echo "Email: " . $faculty->email . "\n";
    echo "Name: " . $faculty->name . "\n";
    echo "Department: " . $faculty->department . "\n";
    echo "Course: " . $faculty->course . "\n";
    echo "Has permission: " . ($faculty->hasPermissionTo('manage department users') ? 'Yes' : 'No') . "\n";
} else {
    echo "No faculty user found. Creating one...\n";
    
    $faculty = User::create([
        'name' => 'Faculty User',
        'email' => 'faculty@uspf.edu.ph',
        'password' => bcrypt('password123'),
        'role' => 'faculty',
        'department' => 'College of Computer Studies',
        'course' => 'BSIT',
        'email_verified_at' => now(),
    ]);
    
    $faculty->assignRole('faculty');
    $faculty->givePermissionTo('manage department users');
    
    echo "Faculty user created and configured!\n";
}

echo "\nDone!\n";