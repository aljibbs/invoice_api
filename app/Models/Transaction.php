<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    protected $dates = ['due_date'];

    protected $fillable = [
        'user_id',
        'customer_id',
        'total_amount',
        'due_date',
        'invoice_number'
    ];

    protected $casts = [
        'total_amount' => 'float',
    ];

    protected function totalAmount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value, 2, '.', ''),
        );
    }

    public function getIssuedDateAttribute()
    {
        return $this->created_at->format('M d, Y');
    }

    public function getDueDateAttribute()
    {
        return $this->due_date->format('M d, Y');
    }

    public function transactionItems(): HasMany
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
