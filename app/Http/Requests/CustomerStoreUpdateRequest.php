<?php

namespace App\Http\Requests;

use App\Rules\UniqueCpf;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\ValidCpf;

class CustomerStoreUpdateRequest extends FormRequest
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
            'cpf' => [
                'required',
                new ValidCpf,
                new UniqueCpf(null)
            ],
            'phone' => [
                'required',
                'min:3',
                'max:20'
            ],
            'city' => [
                'required',
                'max:255',
            ],
            'state' => [
                'required',
                'max:2',
            ],
            'street' => [
                'required',
                'max:255',
            ],
            'number' => [
                'nullable',
            ],
            'complement' => [
                'nullable',
                'max:255'
            ]
        ];

        if ($this->method() == 'PUT') {
            $rules['cpf'] = [
                'required',
                new ValidCpf,
                new UniqueCpf($this->route('customer')->id)
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
            'cpf.required' => 'O campo CPF é obrigatório.',
            'phone.required' => 'O campo telefone é obrigatório.',
            'phone.min' => 'O telefone deve ter pelo menos 3 caracteres.',
            'phone.max' => 'O telefone não pode ter mais de 20 caracteres.',
            'city.required' => 'O campo cidade é obrigatório.',
            'city.max' => 'A cidade não pode ter mais de 255 caracteres.',
            'state.required' => 'O campo estado é obrigatório.',
            'state.max' => 'O estado não pode ter mais de 2 caracteres.',
            'street.required' => 'O campo rua é obrigatório.',
            'street.max' => 'A rua não pode ter mais de 255 caracteres.',
            'complement.max' => 'O complemento não pode ter mais de 255 caracteres.'
        ];
    }
}
