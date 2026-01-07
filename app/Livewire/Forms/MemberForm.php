<?php

namespace App\Livewire\Forms;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Form;

class MemberForm extends Form
{
    public ?User $user;

    public ?string $name = null;

    public ?string $email = null;

    public ?string $role = null;

    //public ?string $email_verified_at = '';

    public ?string $password = '';

    //public $two_factor_secret = '';

    //public $two_factor_recovery_codes = '';

    //public $two_factor_confirmed_at = '';

    public function rules()
    {
        return [
            'name' => 'required|min:2|max:60',
            'email' => 'required|email|min:2|max:60',
            'role' => ['required', Rule::enum(UserRole::class)],
            /*'email_verified_at' => 'nullable|date',*/
            'password' => 'required',
            /*'two_factor_secret' => 'nullable',*/
            /*'two_factor_recovery_codes' => 'nullable',*/
            /*'two_factor_confirmed_at' => 'nullable|date',*/
        ];
    }

    public function delete(User $user)
    {
        $user->delete();
    }
}
