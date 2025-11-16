<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FacultyResearch;

class FacultyResearchPolicy
{
    /**
     * Determine if the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-any faculty-research') 
            || $user->hasPermissionTo('view-any faculty_research')
            || $user->hasRole('admin');
    }

    /**
     * Determine if the user can view the model.
     */
    public function view(User $user, FacultyResearch $research): bool
    {
        // Can view if has permission or owns the research
        return $user->hasPermissionTo('view faculty-research')
            || $user->hasPermissionTo('view faculty_research')
            || $user->hasRole('admin')
            || $research->user_id === $user->id;
    }

    /**
     * Determine if the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create faculty-research')
            || $user->hasPermissionTo('create faculty_research')
            || $user->hasRole('admin');
    }

    /**
     * Determine if the user can update the model.
     */
    public function update(User $user, FacultyResearch $research): bool
    {
        // Can update if has permission or owns the research
        return $user->hasPermissionTo('update faculty-research')
            || $user->hasPermissionTo('update faculty_research')
            || $user->hasRole('admin')
            || $research->user_id === $user->id;
    }

    /**
     * Determine if the user can delete the model.
     */
    public function delete(User $user, FacultyResearch $research): bool
    {
        // Can delete if has permission or owns the research
        return ($user->hasPermissionTo('delete faculty-research')
            || $user->hasPermissionTo('delete faculty_research')
            || $user->hasRole('admin'))
            || $research->user_id === $user->id;
    }
}

