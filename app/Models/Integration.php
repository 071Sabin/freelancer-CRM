<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Integration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ai_provider',
        'ai_api_key',
        'wa_access_token',
        'wa_phone_number_id',
        'wa_business_account_id',
    ];

    // Magic! Ye keys ko DB me encrypt karega aur access karne pe decrypt.
    protected $casts = [
        'ai_api_key' => 'encrypted',
        'wa_access_token' => 'encrypted',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
