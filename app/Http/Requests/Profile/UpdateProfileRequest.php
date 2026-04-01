<?php

namespace App\Http\Requests\Profile;

use App\Traits\RequestFieldValidation;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    use RequestFieldValidation;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['sometimes', 'string', 'max:50'],
            'last_name' => ['sometimes', 'string', 'max:50'],
            'phone' => ['sometimes', 'nullable', 'string'],
            'company_name' => ['sometimes', 'nullable', 'string', 'max:100'],
        ];
    }

    public function attributes(): array
    {
        return [
            'first_name' => 'Ad',
            'last_name' => 'Soyad',
            'phone' => 'Telefon',
            'company_name' => 'Şirkət adı',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.max' => ':attribute maksimum 50 simvol ola bilər',
            'last_name.max' => ':attribute maksimum 50 simvol ola bilər',
            'company_name.max' => ':attribute maksimum 100 simvol ola bilər',
        ];
    }
}
