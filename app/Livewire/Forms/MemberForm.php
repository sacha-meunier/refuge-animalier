<?php

namespace App\Livewire\Forms;

use App\Enums\UserRole;
use App\Mail\NewMemberCreated;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Form;

class MemberForm extends Form
{
    public ?string $name = null;

    public ?string $email = null;

    public ?string $role = null;

    public function rules()
    {
        return [
            'name' => 'required|min:2|max:60',
            'email' => 'required|email|min:2|max:60|unique:users,email',
            'role' => ['required', Rule::enum(UserRole::class)],
        ];
    }

    public function store()
    {
        $this->validate();

        // Generate random password
        $randomPassword = Str::random(12);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'password' => bcrypt($randomPassword),
        ]);

        // Send email with credentials
        Mail::to($user->email)
            ->send(new NewMemberCreated($user, $randomPassword));
    }

    public function delete(User $user)
    {
        $user->delete();
    }
}
