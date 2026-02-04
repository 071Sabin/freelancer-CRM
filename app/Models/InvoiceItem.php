<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id',
        'position',
        'name',
        'description',
        'sku',
        'unit',
        'quantity',
        'unit_price',
        'discount_rate',
        'discount_amount',
        'tax_rate',
        'tax_amount',
        'line_total',
        'is_tax_inclusive',
        'metadata',
    ];

    protected $casts = [
        'is_tax_inclusive' => 'boolean',
        'metadata' => 'array',
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'discount_rate' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'line_total' => 'decimal:2',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
