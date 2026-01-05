<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVolunteerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^[0-9\s\+\-\(\)\/\.]{8,20}$/'],
            'address' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('client.form_name'),
            'email' => __('client.form_email'),
            'phone' => __('client.form_phone'),
            'address' => __('client.form_address'),
            'message' => __('client.form_message'),
        ];
    }
}
