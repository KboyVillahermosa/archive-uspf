<?php

namespace App\Policies;

use App\Models\User;
use App\Models\StudentResearch;

class StudentResearchPolicy
{
    /**
     * Determine if the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-any student-research')
            || $user->hasPermissionTo('view-any student_research')
            || $user->hasRole('admin');
    }

    /**
     * Determine if the user can view the model.
     */
    public function view(User $user, StudentResearch $research): bool
    {
        // Can view if has permission or owns the research
        return $user->hasPermissionTo('view student-research')
            || $user->hasPermissionTo('view student_research')
            || $user->hasRole('admin')
            || $research->user_id === $user->id;
    }

    /**
     * Determine if the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create student-research')
            || $user->hasPermissionTo('create student_research')
            || $user->hasRole('admin');
    }

    /**
     * Determine if the user can update the model.
     */
    public function update(User $user, StudentResearch $research): bool
    {
        // Can update if has permission or owns the research
        return $user->hasPermissionTo('update student-research')
            || $user->hasPermissionTo('update student_research')
            || $user->hasRole('admin')
            || $research->user_id === $user->id;
    }

    /**
     * Determine if the user can delete the model.
     */
    public function delete(User $user, StudentResearch $research): bool
    {
        // Can delete if has permission or owns the research
        return ($user->hasPermissionTo('delete student-research')
            || $user->hasPermissionTo('delete student_research')
            || $user->hasRole('admin'))
            || $research->user_id === $user->id;
    }
}

