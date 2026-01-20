<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceSetting extends Model
{
    protected $fillable = [
        'user_id',
        'prefix',
        'next_number',
        'default_currency',
        'default_tax_rate',
        'default_terms',
        'default_notes',
        'logo_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
