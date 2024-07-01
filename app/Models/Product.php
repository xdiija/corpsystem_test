<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'sku', 'price', 'stock'];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::make($value)->format('d-m-Y');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::make($value)->format('d-m-Y');
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = (float) str_replace(',', '.', str_replace('.', '', $value));
    }

    public function sales()
    {
        return $this->belongsToMany(Sale::class)->withPivot('quantity');
    }
}
