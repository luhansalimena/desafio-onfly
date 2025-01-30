<?php

namespace App\Http\Requests;

use App\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SearchTripOrdersRequest extends FormRequest
{
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['sometimes', 'string', Rule::in(array_column(OrderStatus::cases(), 'value'))]
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'status' => strtolower($this->status),
        ]);
    }
}
