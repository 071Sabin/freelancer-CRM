<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceTax extends Model
{
    protected $fillable = [
        'invoice_id',
        'name',
        'rate',
        'amount',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
