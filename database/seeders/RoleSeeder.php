<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define role-specific permissions
        $rolePermissions = [
            'admin' => [
                'view-any users',
                'view users',
                'create users',
                'update users',
                'delete users',
                'view-any student-research',
                'view student-research',
                'approve student-research',
                'reject student-research',
                'view-any faculty-research',
                'view faculty-research',
                'approve faculty-research',
                'reject faculty-research',
                'view-any thesis',
                'view thesis',
                'approve thesis',
                'reject thesis',
                'view-any dissertations',
                'view dissertations',
                'approve dissertations',
                'reject dissertations',
            ],
            'faculty' => [
                'view-any faculty-research',
                'view faculty-research',
                'create faculty-research',
                'update faculty-research',
                'delete faculty-research',
                'view-any student-research',
                'view student-research',
                'view-any thesis',
                'view thesis',
                'view-any dissertations',
                'view dissertations',
            ],
            'student' => [
                'view-any student-research',
                'view student-research',
                'create student-research',
                'update student-research',
                'delete student-research',
                'view-any faculty-research',
                'view faculty-research',
                'view-any thesis',
                'view thesis',
                'view-any dissertations',
                'view dissertations',
            ],
        ];

        // Create roles and assign permissions
        foreach ($rolePermissions as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            
            // Get or create permission models for the role
            $permissionModels = [];
            foreach ($permissions as $permissionName) {
                $permission = Permission::firstOrCreate(['name' => $permissionName]);
                $permissionModels[] = $permission;
            }
            
            // Sync permissions to role
            $role->syncPermissions($permissionModels);
        }
    }
}
