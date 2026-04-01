<?php

namespace App\Http\Requests\Auth;

use App\Traits\RequestFieldValidation;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    use RequestFieldValidation;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
            'token' => ['required', 'string'],
            'password' => ['required', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*[0-9])(?=.*[\W]).+$/']
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => 'E-poçt ünvanı',
            'token' => 'Token',
            'password' => 'Şifr'
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => ':attribute mütləqdir',
            'email.email' => ':attribute standarta uyğun deyil',
            'email.exists' => ':attribute sistemdə mövcud deyil',
            'token.required' => ':attribute mütləqdir',
            'password.required' => ':attribute mütləqdir',
            'password.min' => ':attribute minimum 8 simvol olmalıdır',
            'password.regex' => ':attribute ən azı 1 böyük hərf, 1 rəqəm və 1 xüsusi simvol olmalıdır'
        ];
    }
}
