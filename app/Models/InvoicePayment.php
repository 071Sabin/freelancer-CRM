<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoicePayment extends Model
{
    protected $fillable = [
        'invoice_id',
        'user_id',
        'provider',
        'method',
        'reference',
        'amount',
        'currency',
        'exchange_rate',
        'fee_amount',
        'status',
        'paid_at',
        'notes',
        'meta',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'meta' => 'array',
        'exchange_rate' => 'decimal:6',
        'amount' => 'decimal:2',
        'fee_amount' => 'decimal:2',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
