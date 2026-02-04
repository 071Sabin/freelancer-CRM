<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceAttachment extends Model
{
    protected $fillable = [
        'invoice_id',
        'user_id',
        'disk',
        'path',
        'filename',
        'mime_type',
        'size',
        'is_public',
        'meta',
    ];

    protected $casts = [
        'is_public' => 'boolean',
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
