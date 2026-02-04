<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceStatusHistory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'invoice_id',
        'user_id',
        'from_status',
        'to_status',
        'reason',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
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
