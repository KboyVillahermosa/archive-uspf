<?php

namespace App\Policies;

use App\Models\User;
use App\Models\StudentResearch;

class StudentResearchPolicy
{
    /**
     * Safely check if user has permission (handles non-existent permissions)
     */
    private function hasPermissionSafely(User $user, string $permission): bool
    {
        try {
            return $user->hasPermissionTo($permission);
        } catch (\Spatie\Permission\Exceptions\PermissionDoesNotExist $e) {
            return false;
        }
    }

    /**
     * Determine if the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->hasPermissionSafely($user, 'view-any student-research')
            || $this->hasPermissionSafely($user, 'view-any student_research')
            || $user->hasRole('admin');
    }

    /**
     * Determine if the user can view the model.
     */
    public function view(User $user, StudentResearch $research): bool
    {
        // Can view if has permission or owns the research
        return $this->hasPermissionSafely($user, 'view student-research')
            || $this->hasPermissionSafely($user, 'view student_research')
            || $user->hasRole('admin')
            || $research->user_id === $user->id;
    }

    /**
     * Determine if the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->hasPermissionSafely($user, 'create student-research')
            || $this->hasPermissionSafely($user, 'create student_research')
            || $user->hasRole('admin');
    }

    /**
     * Determine if the user can update the model.
     */
    public function update(User $user, StudentResearch $research): bool
    {
        // Can update if has permission or owns the research
        return $this->hasPermissionSafely($user, 'update student-research')
            || $this->hasPermissionSafely($user, 'update student_research')
            || $user->hasRole('admin')
            || $research->user_id === $user->id;
    }

    /**
     * Determine if the user can delete the model.
     */
    public function delete(User $user, StudentResearch $research): bool
    {
        // Can delete if has permission or owns the research
        return ($this->hasPermissionSafely($user, 'delete student-research')
            || $this->hasPermissionSafely($user, 'delete student_research')
            || $user->hasRole('admin'))
            || $research->user_id === $user->id;
    }
}

