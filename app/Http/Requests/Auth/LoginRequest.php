<?php

namespace App\Http\Requests\Auth;

use App\Traits\RequestFieldValidation;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    use RequestFieldValidation;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "email" => ["required", "email"],
            "password" => ["required", "min:6", "max:25"]
        ];
    }

    public function attributes(): array
    {
        return [
            "email" => "E-poçt ünvanı",
            "password" => "Şifr"
        ];
    }

    public function messages()
    {
        return [
            "email.required" => ":attribute mütləqdir",
            "email.email" => ":attribite standarda uyğun deyil",
            "password.required" => ":attribute mütləqdir",
            "password.min" => ":attribute minimum 6 simvol ola bilər",
            "password.max" => ":attribute maksimum 25 simvol ola bilər"
        ];
    }
}
