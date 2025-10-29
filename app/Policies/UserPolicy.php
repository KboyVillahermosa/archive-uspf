<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Check if user is admin (Spatie role or legacy role column)
     */
    private function isAdmin(User $user): bool
    {
        return $user->hasRole('admin') || ($user->role === 'admin');
    }

    /**
     * Determine if the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine if the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine if the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine if the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine if the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $this->isAdmin($user) && $user->id !== $model->id;
    }
}

