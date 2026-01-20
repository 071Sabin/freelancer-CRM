<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'user_id',
        'client_id',
        'project_id',
        'invoice_number',
        'status',
        'issue_date',
        'due_date',
        'currency',
        'subtotal',
        'tax_total',
        'discount_total',
        'total',
        'notes',
        'terms',
        'sent_at',
        'paid_at',
    ];

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
}
