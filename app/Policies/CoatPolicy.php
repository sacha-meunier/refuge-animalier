<?php

namespace App\Policies;

use App\Models\Coat;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoatPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Coat $coat): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Coat $coat): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Coat $coat): bool
    {
        return $user->isAdmin();
    }
}
