<?php

namespace App\Policies;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

        return $user->isAdmin() || $user->isVolunteer();
    }

    public function view(User $user, Contact $contact): bool
    {
        return $user->isAdmin() || $user->isVolunteer();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isVolunteer();
    }

    public function update(User $user, Contact $contact): bool
    {
        return $user->isAdmin() || $user->isVolunteer();
    }

    public function delete(User $user, Contact $contact): bool
    {
        return $user->isAdmin();
    }
}
