<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'cpf', 'phone', 'city', 'state', 'street', 'number', 'complement'];

    /**
     * Set the customer's CPF.
     *
     * @param string $value
     * @return void
     */
    public function setCpfAttribute($value)
    {
        $this->attributes['cpf'] = preg_replace('/\D/', '', $value);
    }

    public function getCpfAttribute($value)
    {
        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $value);
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = preg_replace('/\D/', '', $value);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::make($value)->format('d-m-Y');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::make($value)->format('d-m-Y');
    }

    public function getPhoneAttribute($value)
    {
        $phoneDigits = preg_replace('/\D/', '', $value);
        $length = strlen($phoneDigits);
        if ($length === 10) {
            return "(" . substr($phoneDigits, 0, 2) . ") " . substr($phoneDigits, 2, 4) . "-" . substr($phoneDigits, 6);
        } elseif ($length === 11) {
            return "(" . substr($phoneDigits, 0, 2) . ") " . substr($phoneDigits, 2, 5) . "-" . substr($phoneDigits, 7);
        } else {
            return $value;
        }
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
