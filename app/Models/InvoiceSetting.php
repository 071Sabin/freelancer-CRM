<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceSetting extends Model
{
    protected $fillable = [
        'user_id',
        'prefix',
        'next_number',
        'number_format',
        'default_currency',
        'default_tax_rate',
        'default_tax_inclusive',
        'default_due_days',
        'default_payment_terms',
        'default_discount_rate',
        'default_late_fee_rate',
        'default_late_fee_amount',
        'default_late_fee_type',
        'allow_partial_payments',
        'default_terms',
        'default_notes',
        'default_footer',
        'company_name',
        'company_email',
        'company_phone',
        'company_website',
        'tax_id',
        'company_address',
        'bank_details',
        'payment_methods',
        'locale',
        'timezone',
        'logo_path',
    ];

    protected $casts = [
        'default_tax_inclusive' => 'boolean',
        'allow_partial_payments' => 'boolean',
        'default_tax_rate' => 'decimal:2',
        'default_discount_rate' => 'decimal:2',
        'default_late_fee_rate' => 'decimal:2',
        'default_late_fee_amount' => 'decimal:2',
        'company_address' => 'array',
        'bank_details' => 'array',
        'payment_methods' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
