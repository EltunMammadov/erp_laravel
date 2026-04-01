<?php

namespace App\Http\Requests\Product;

use App\Traits\RequestFieldValidation;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:150', 'unique:products,name'],
            'sku' => ['nullable', 'string', 'max:50', 'unique:products,sku'],
            'description' => ['nullable', 'string'],
            'category' => ['required', 'string', 'in:raw_material,finished_good,service'],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'quantity_in_stock' => ['required', 'integer', 'min:0'],
            'reorder_level' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean']
        ];
    }
}
