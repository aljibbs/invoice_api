<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'product_id',
        'unit_price',
        'quantity',
        'amount',
        'description',
    ];

    protected $casts = [
        'unit_price' => 'float',
        'amount' => 'float',
    ];

    protected $hidden = [
        'id',
        'transaction_id',
        'product_id',
        'created_at',
        'updated_at'
    ];

    protected $with = ['product'];


    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected function amount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value, 2, '.', ''),
        );
    }


    protected function unitPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value, 2, '.', ''),
        );
    }

}
