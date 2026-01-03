<?php

namespace App\Policies;

use App\Models\Specie;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpeciePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Specie $specie): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Specie $specie): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Specie $specie): bool
    {
        return $user->isAdmin();
    }
}
