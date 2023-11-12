<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'name' => 'sometimes|required|string',
            'quantity' => 'sometimes|required|integer|min:1',
            'cost_price' => 'sometimes|required|decimal:2|min:1.00',
            'selling_price' => 'sometimes|required|decimal:2|min:1.00'
        ];
    }
}
