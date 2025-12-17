<?php

namespace App\Policies;

use App\Models\Adoption;
use App\Models\Animal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdoptionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

        return $user->isAdmin() || $user->isVolunteer();
    }

    public function view(User $user, Adoption $adoptionsRequest): bool
    {
        return $user->isAdmin() || $user->isVolunteer();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isVolunteer();
    }

    public function update(User $user, Adoption $adoptionsRequest): bool
    {
        return $user->isAdmin() || $user->isVolunteer();
    }

    public function delete(User $user, Adoption $adoptionsRequest): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, Adoption $adoptionsRequest): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Adoption $adoptionsRequest): bool
    {
        return $user->isAdmin();
    }

    public function validate(User $user, Adoption $adoptionsRequest): bool
    {
        return $user->isAdmin();
    }
}
