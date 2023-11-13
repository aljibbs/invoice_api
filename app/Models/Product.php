<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'quantity',
        'cost_price',
        'selling_price',
    ];

    protected $casts = [
        'selling_price' => 'float',
    ];

    protected $hidden = [
        'cost_price',
        'created_at',
        'updated_at'
    ];

    protected function sellingPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value, 2, '.', ''),
        );
    }
}
