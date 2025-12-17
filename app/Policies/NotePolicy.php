<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isVolunteer();
    }

    public function view(User $user, Note $note): bool
    {
        return $user->isAdmin() || $user->isVolunteer();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isVolunteer();
    }

    public function update(User $user, Note $note): bool
    {
        return $user->isAdmin() || $user->isVolunteer();
    }

    public function delete(User $user, Note $note): bool
    {
        return $user->isAdmin();
    }
}
