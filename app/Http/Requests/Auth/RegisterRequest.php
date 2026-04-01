<?php

namespace App\Http\Requests\Auth;

use App\Traits\RequestFieldValidation;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "first_name" => ["required", "string", "max:50"],
            "last_name" => ["required","string", "max:50"],
            "email" => ["required","email", "unique:users,email"],
            "password" => ["required", "min:8","regex:/^(?=.*[A-Z])(?=.*[0-9])(?=.*[\W]).+$/"],
            "phone" => ["nullable", "string"],
            "company_name" => ["nullable","string" ,"max:100"]
        ];
    }

    public function attributes(): array
    {
        return [
            "first_name" => "Ad",
            "last_name" => "Soyad",
            "email" => "E-poçt ünvanı",
            "password" => "Şifr",
            "phone" => "Telefon nömrəniz",
            "company_name" => "Şirkət adı"
        ];
    }

    public function messages()
    {
        return [
            "first_name.required" => ":attribute mütləqdir",
            "first_name.string" => ":attribute mətn olmalıdır",
            "first_name.max" => ":attribute maksimum 50 simvol ola bilər",
            "last_name.required" => ":attribute mütləqdir",
            "last_name.max" => ":attribute maksimum 50 simvol ola bilər",
            "last_name.string" => ":attribute mətn olmalıdır",
            "email.required" => ":attribute mütləqdir",
            "email.email" => ":attribute standarda uyğun deyil",
            "email.unique" => ":attribute artıq mövcuddur",
            "password.required" => ":attribute mütləqdir",
            "password.min" => ":attribute minium 8 simvol ola bilər",
            "password.regex" => ":attribute ən azı 1 böyük hərf, 1 rəqəm və 1 xüsusi simvol olmalıdır",
            "phone.string" => ":attribute mətn olmalıdır",
            "company_name.string" => ":attribute mətn olmalıdır",
            "company_name.max" => ":attribute maksimum 100 simvol ol bilər"
        ];
    }
}
