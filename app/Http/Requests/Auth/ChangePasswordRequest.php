<?php

namespace App\Http\Requests\Auth;

use App\Traits\RequestFieldValidation;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    use RequestFieldValidation;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*[0-9])(?=.*[\W]).+$/', 'confirmed']
        ];
    }

    public function attributes(): array
    {
        return [
            'current_password' => 'Cari şifr',
            'new_password' => 'Yeni şifr'
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => ':attribute mütləqdir',
            'new_password.required' => ':attribute mütləqdir',
            'new_password.min' => ':attribute minimum 8 simvol olmalıdır',
            'new_password.regex' => ':attribute ən azı 1 böyük hərf, 1 rəqəm və 1 xüsusi simvol olmalıdır',
            'new_password.confirmed' => 'Yeni şifr təsdiqi uyğun deyil'
        ];
    }
}
