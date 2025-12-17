<?php

namespace App\Policies;

use App\Models\Breed;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BreedPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Breed $breed): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Breed $breed): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Breed $breed): bool
    {
        return $user->isAdmin();
    }
}
