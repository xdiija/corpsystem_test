<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductStoreUpdateRequest extends FormRequest
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
        $rules = [
            'name' => [
                'required',
                'min:3',
                'max:255'
            ],
            'sku' => [
                'required',
                'min:3',
                'max:50',
                'unique:products'
            ],
            'description' => [
                'required',
                'min:3',
                'max:500'
            ],
            'price' => [
                'required',
                'min:3',
                'min:0.01'
            ],
            'stock' => [
                'required',
                'integer',
                'min:0',
                'not_in:-1',
            ]
        ];

        if ($this->method() == 'PUT') {
            $rules['sku'] = [
                'required',
                'min:3',
                'max:50',
                Rule::unique('products')->ignore(
                    $this->route('product')->id
                )
            ];
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.min' => 'O nome deve ter pelo menos 3 caracteres.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'sku.required' => 'O campo SKU é obrigatório.',
            'sku.min' => 'O SKU deve ter pelo menos 3 caracteres.',
            'sku.max' => 'O SKU não pode ter mais de 50 caracteres.',
            'sku.unique' => 'Este SKU já está cadastrado.',
            'price.required' => 'O campo preço é obrigatório.',
            'price.regex' => 'Formato de preço inválido. Use apenas números e até duas casas decimais.',
            'price.min' => 'O preço deve ser maior que 0.',
            'price.max' => 'Preço muito grande. Verifique o valor informado.',
            'stock.required' => 'O campo estoque é obrigatório.',
            'stock.integer' => 'O estoque deve ser um número inteiro.',
            'stock.min' => 'O estoque não pode ser negativo.',
            'stock.not_in' => 'O valor do estoque não pode ser -1.'
        ];
    }
}
