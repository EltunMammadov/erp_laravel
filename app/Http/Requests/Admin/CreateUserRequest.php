<?php

namespace App\Http\Requests\Admin;

use App\Enums\Role;
use App\Traits\RequestFieldValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CreateUserRequest extends FormRequest
{
    use RequestFieldValidation;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*[0-9])(?=.*[\W]).+$/'],
            'phone' => ['nullable', 'string'],
            'company_name' => ['nullable', 'string', 'max:100'],
            'role' => ['required', new Enum(Role::class)]
        ];
    }

    public function attributes(): array
    {
        return [
            'first_name' => 'Ad',
            'last_name' => 'Soyad',
            'email' => 'E-poçt ünvanı',
            'password' => 'Şifr',
            'role' => 'Rol'
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => ':attribute mütləqdir',
            'last_name.required' => ':attribute mütləqdir',
            'email.required' => ':attribute mütləqdir',
            'email.unique' => ':attribute artıq mövcuddur',
            'password.required' => ':attribute mütləqdir',
            'password.min' => ':attribute minimum 8 simvol olmalıdır',
            'password.regex' => ':attribute ən azı 1 böyük hərf, 1 rəqəm və 1 xüsusi simvol olmalıdır',
            'role.required' => ':attribute mütləqdir',
            'role.Illuminate\Validation\Rules\Enum' => ':attribute yalnız admin, manager və ya employee ola bilər'
        ];
    }
}
