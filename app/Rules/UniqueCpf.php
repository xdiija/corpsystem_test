<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Customer;

class UniqueCpf implements Rule
{
    protected $ignoreId;

    public function __construct($ignoreId = null)
    {
        $this->ignoreId = $ignoreId;
    }

    public function passes($attribute, $value)
    {
        $cpfDigits = preg_replace('/\D/', '', $value);
        $query = Customer::where('cpf', $cpfDigits);

        if ($this->ignoreId) {
            $query->where('id', '!=', $this->ignoreId);
        }

        return ! $query->exists();
    }

    public function message()
    {
        return 'O CPF fornecido já está cadastrado.';
    }
}
