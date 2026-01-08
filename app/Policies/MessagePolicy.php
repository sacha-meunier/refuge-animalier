<?php

namespace App\Policies;

use App\Models\Message;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isVolunteer();
    }

    public function view(User $user, Message $message): bool
    {
        return $user->isAdmin() || $user->isVolunteer();
    }

    public function delete(User $user, Message $message): bool
    {
        return $user->isAdmin();
    }
}
