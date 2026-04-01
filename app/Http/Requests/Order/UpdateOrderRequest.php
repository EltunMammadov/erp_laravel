<?php

namespace App\Http\Requests\Order;

use App\Enums\OrderStatus;
use App\Traits\RequestFieldValidation;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateOrderRequest extends FormRequest
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
            'customer_id' => ['sometimes', 'integer', 'exists:customers,id'],
            'order_date' => ['sometimes', 'date'],
            'status' => ['sometimes', new Enum(OrderStatus::class)],
            'total_amount' => ['sometimes', 'numeric', 'min:0'],
            'discount_pct' => ['sometimes', 'numeric', 'min:0', 'max:100'],
            'net_amount' => ['sometimes', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
            'assigned_to' => ['nullable', 'integer', 'exists:users,id'],
        ];
    }
}
