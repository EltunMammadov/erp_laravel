<?php

namespace App\Http\Requests\Auth;

use App\Traits\RequestFieldValidation;
use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    use RequestFieldValidation;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email']
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => 'E-poçt ünvanı'
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => ':attribute mütləqdir',
            'email.email' => ':attribute standarta uyğun deyil',
            'email.exists' => ':attribute sistemdə mövcud deyil'
        ];
    }
}
