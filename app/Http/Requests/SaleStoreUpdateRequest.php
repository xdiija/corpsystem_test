<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleStoreUpdateRequest extends FormRequest
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
            'customer_id' => 'required|exists:customers,id',
            'payment_method' => 'required|string|max:255',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'customer_id.required' => 'O campo cliente é obrigatório.',
            'customer_id.exists' => 'Cliente inválido.',
            'payment_method.required' => 'O campo método de pagamento é obrigatório.',
            'payment_method.string' => 'O método de pagamento deve ser um texto.',
            'payment_method.max' => 'O método de pagamento não pode ter mais de 255 caracteres.',
            'products.required' => 'É necessário adicionar pelo menos um produto.',
            'products.array' => 'O campo produtos deve ser um array.',
            'products.*.id.required' => 'O campo ID do produto é obrigatório.',
            'products.*.id.exists' => 'Produto inválido.',
            'products.*.quantity.required' => 'O campo quantidade é obrigatório.',
            'products.*.quantity.integer' => 'A quantidade deve ser um número inteiro.',
            'products.*.quantity.min' => 'A quantidade deve ser pelo menos 1.',
        ];
    }
}
