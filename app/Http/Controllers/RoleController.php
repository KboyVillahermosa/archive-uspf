<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    /**
     * Display a listing of roles.
     */
    public function index()
    {
        $user = auth()->user();
        if (!$user->hasPermissionTo('view-any roles') && !$user->hasRole('admin')) {
            abort(403, 'Access denied. You do not have permission to view roles.');
        }
        
        $roles = Role::with('permissions')->withCount('users')->get();
        $allPermissions = Permission::orderBy('name')->get()->groupBy(function ($permission) {
            // Group permissions by their prefix (e.g., 'view-any', 'create', etc.)
            $parts = explode(' ', $permission->name);
            return $parts[0] ?? 'other';
        });
        
        return view('admin.roles.index', compact('roles', 'allPermissions'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        $this->authorize('create', \App\Models\User::class);
        
        $allPermissions = Permission::orderBy('name')->get()->groupBy(function ($permission) {
            $parts = explode(' ', $permission->name);
            return $parts[0] ?? 'other';
        });
        
        return view('admin.roles.form', compact('allPermissions'));
    }

    /**
     * Store a newly created role.
     */
    public function store(Request $request)
    {
        $this->authorize('create', \App\Models\User::class);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role = Role::create([
            'name' => Str::lower(Str::slug($request->name, '_')),
            'guard_name' => 'web',
        ]);

        if ($request->filled('permissions')) {
            $permissions = Permission::whereIn('name', $request->permissions)->get();
            $role->syncPermissions($permissions);
        }

        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Role created successfully!']);
        }
        
        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully!');
    }

    /**
     * Check if the authenticated user is an admin
     */
    private function checkAdminAccess()
    {
        $user = auth()->user();
        if (!$user || (!$user->hasRole('admin') && $user->role !== 'admin')) {
            abort(403, 'Access denied. Admin privileges required.');
        }
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role)
    {
        $this->checkAdminAccess();
        
        $allPermissions = Permission::orderBy('name')->get()->groupBy(function ($permission) {
            $parts = explode(' ', $permission->name);
            return $parts[0] ?? 'other';
        });
        
        return view('admin.roles.form', compact('role', 'allPermissions'));
    }

    /**
     * Update the specified role.
     */
    public function update(Request $request, Role $role)
    {
        $this->checkAdminAccess();
        
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role->update([
            'name' => Str::lower(Str::slug($request->name, '_')),
        ]);

        if ($request->filled('permissions')) {
            $permissions = Permission::whereIn('name', $request->permissions)->get();
            $role->syncPermissions($permissions);
        } else {
            $role->syncPermissions([]);
        }

        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Role updated successfully!']);
        }
        
        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully!');
    }

    /**
     * Remove the specified role.
     */
    public function destroy(Role $role)
    {
        $this->checkAdminAccess();
        
        // Prevent deletion of roles that have users
        if ($role->users()->count() > 0) {
            if (request()->expectsJson() || request()->wantsJson()) {
                return response()->json([
                    'status' => 'error', 
                    'message' => 'Cannot delete role. There are users assigned to this role.'
                ], 422);
            }
            return redirect()->back()->with('error', 'Cannot delete role. There are users assigned to this role.');
        }
        
        $role->delete();

        if (request()->expectsJson() || request()->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Role deleted successfully!']);
        }
        
        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully!');
    }
}

