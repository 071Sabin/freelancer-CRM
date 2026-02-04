<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceTax extends Model
{
    protected $fillable = [
        'invoice_id',
        'name',
        'tax_code',
        'type',
        'scope',
        'rate',
        'amount',
        'is_inclusive',
        'is_compound',
        'jurisdiction',
        'priority',
        'metadata',
    ];

    protected $casts = [
        'is_inclusive' => 'boolean',
        'is_compound' => 'boolean',
        'metadata' => 'array',
        'rate' => 'decimal:2',
        'amount' => 'decimal:2',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
