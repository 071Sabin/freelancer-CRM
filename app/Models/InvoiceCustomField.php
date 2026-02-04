<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceCustomField extends Model
{
    protected $fillable = [
        'invoice_id',
        'name',
        'value',
        'position',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
