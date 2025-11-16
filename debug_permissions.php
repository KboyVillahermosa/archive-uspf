<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\\Contracts\\Console\\Kernel')->bootstrap();

use App\Models\User;

echo "=== Debug User Permissions ===\n\n";

// Check if we have a faculty user
$faculty = User::where('email', 'faculty@uspf.edu.ph')->first();
if (!$faculty) {
    echo "No faculty user found!\n";
    exit;
}

echo "User found:\n";
echo "ID: " . $faculty->id . "\n";
echo "Name: " . $faculty->name . "\n";
echo "Email: " . $faculty->email . "\n";
echo "Role: " . $faculty->role . "\n";
echo "Department: " . $faculty->department . "\n";
echo "Course: " . $faculty->course . "\n\n";

echo "Spatie Roles:\n";
foreach ($faculty->roles as $role) {
    echo "- " . $role->name . "\n";
}
echo "\n";

echo "Direct Permissions:\n";
foreach ($faculty->getDirectPermissions() as $permission) {
    echo "- " . $permission->name . "\n";
}
echo "\n";

echo "All Permissions (including via roles):\n";
foreach ($faculty->getAllPermissions() as $permission) {
    echo "- " . $permission->name . "\n";
}
echo "\n";

echo "Permission Checks:\n";
echo "hasRole('faculty'): " . ($faculty->hasRole('faculty') ? 'Yes' : 'No') . "\n";
echo "hasPermissionTo('manage department users'): " . ($faculty->hasPermissionTo('manage department users') ? 'Yes' : 'No') . "\n";

// Check what happens in the downloadUserTemplate method logic
$isAdmin = $faculty->hasRole('admin') || ($faculty->role === 'admin');
$isFaculty = $faculty->hasRole('faculty') || ($faculty->role === 'faculty');
$hasPermission = $faculty->hasPermissionTo('manage department users');

echo "\nController Logic Check:\n";
echo "isAdmin: " . ($isAdmin ? 'Yes' : 'No') . "\n";
echo "isFaculty: " . ($isFaculty ? 'Yes' : 'No') . "\n";
echo "hasPermissionTo('manage department users'): " . ($hasPermission ? 'Yes' : 'No') . "\n";

$shouldPass = $isAdmin || ($isFaculty && $hasPermission);
echo "Should pass authorization: " . ($shouldPass ? 'Yes' : 'No') . "\n";

echo "\n=== End Debug ===\n";