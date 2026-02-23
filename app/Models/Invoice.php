<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'client_id',
        'project_id',
        'approved_by',
        'uuid',
        'invoice_number',
        'type',
        'invoice_status',
        'reference',
        'public_token',
        'issue_date',
        'due_date',
        'approved_at',
        'viewed_at',
        'canceled_at',
        'voided_at',
        'currency',
        'base_currency',
        'exchange_rate',
        // 'tax_rate', // Removed as per user request to use metadata/settings
        'subtotal',
        'tax_total',
        'discount_total',
        'shipping_total',
        'adjustment_total',
        'total',
        'paid_total',
        'balance_due',
        'is_tax_inclusive',
        'notes',
        'terms',
        'payment_terms',
        'due_days',
        'sent_at',
        'paid_at',
        'client_snapshot',
        'company_snapshot',
        'billing_address',
        'shipping_address',
        'metadata',
        'discount_value',
        'discount_type',
        'late_fee_value',
        'late_fee_type',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'viewed_at' => 'datetime',
        'canceled_at' => 'datetime',
        'voided_at' => 'datetime',
        'sent_at' => 'datetime',
        'paid_at' => 'datetime',
        'client_snapshot' => 'array',
        'company_snapshot' => 'array',
        'billing_address' => 'array',
        'shipping_address' => 'array',
        'metadata' => 'array',
        'is_tax_inclusive' => 'boolean',
        'exchange_rate' => 'decimal:6',
        'subtotal' => 'decimal:2',
        'tax_total' => 'decimal:2',
        'discount_total' => 'decimal:2',
        'shipping_total' => 'decimal:2',
        'adjustment_total' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_total' => 'decimal:2',
        'balance_due' => 'decimal:2',
    ];

    protected $table = 'invoices';
    protected $primaryKey = 'id';

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function taxes()
    {
        return $this->hasMany(InvoiceTax::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(InvoiceActivityLog::class);
    }

    public function payments()
    {
        return $this->hasMany(InvoicePayment::class);
    }

    public function attachments()
    {
        return $this->hasMany(InvoiceAttachment::class);
    }

    public function customFields()
    {
        return $this->hasMany(InvoiceCustomField::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(InvoiceStatusHistory::class);
    }
}
