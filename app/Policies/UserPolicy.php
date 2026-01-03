<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can view the members list
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can view a specific member's details
     */
    public function view(User $user, User $member): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can create new members
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can update member information
     */
    public function update(User $user, User $member): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can delete a member
     * Cannot delete yourself
     */
    public function delete(User $user, User $member): bool
    {
        return $user->isAdmin() && $user->id !== $member->id;
    }

    /**
     * Determine if the user can change a member's role
     */
    public function changeRole(User $user, User $member): bool
    {
        return $user->isAdmin() && $user->id !== $member->id;
    }
}
