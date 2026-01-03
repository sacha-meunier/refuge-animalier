<?php

namespace App\Policies;

use App\Models\Animal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnimalPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can view the list of animal entities
     * Both admins and volunteers can view reference data
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isVolunteer();
    }

    /**
     * Determine if the user can view a specific entity
     * Both admins and volunteers can view reference data
     */
    public function view(User $user, Animal $animal): bool
    {
        return $user->isAdmin() || $user->isVolunteer();
    }

    /**
     * Determine if the user can create new entities
     * Both admins and volunteers can add animals
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isVolunteer();
    }

    /**
     * Determine if the user can update entities
     * Both admins and volunteers can update animals
     */
    public function update(User $user, Animal $animal): bool
    {
        return $user->isAdmin() || $user->isVolunteer();
    }

    /**
     * Determine if the user can delete entities
     * Only admins can delete reference data
     */
    public function delete(User $user, Animal $animal): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can publish an animal
     * Only admins can delete reference data
     */
    public function publish(User $user, Animal $animal): bool
    {
        return $user->isAdmin();
    }
}
