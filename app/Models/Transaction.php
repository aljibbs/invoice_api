<?php

namespace App\Models;

use Carbon\Carbon;
use DateTime;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    protected $dates = ['due_date'];

    protected $with = ['customer', 'transactionItems'];

    protected $fillable = [
        'user_id',
        'customer_id',
        'total_amount',
        'due_date',
        'invoice_number'
    ];

    protected $appends = [ 'issued_date' ];

    protected $casts = [
        'total_amount' => 'float',
    ];

    protected $hidden = [
        'id',
        'user_id',
        'customer_id',
        'created_at',
        'updated_at'
    ];

    protected function totalAmount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value, 2, '.', ''),
        );
    }

    protected function getIssuedDateAttribute()
    {
        return $this->created_at->toFormattedDateString();
    }

    protected function dueDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->toFormattedDateString(),
        );
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
