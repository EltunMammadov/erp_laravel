<?php

namespace App\Http\Requests\Product;

use App\Traits\RequestFieldValidation;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
        $productId = $this->route('product_id');

        return [
            'name'  => ['sometimes', 'string', 'max:150', 'unique:products,name,' . $productId],
            'sku' => ['sometimes', 'string', 'max:50', 'unique:products,sku,' . $productId],
            'description' => ['sometimes', 'nullable', 'string'],
            'category' => ['sometimes', 'string', 'in:raw_material,finished_good,service'],
            'unit_price' => ['sometimes', 'numeric', 'min:0'],
            'quantity_in_stock' => ['sometimes', 'integer', 'min:0'],
            'reorder_level' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean']
        ];
    }
}
