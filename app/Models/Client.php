<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Client extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'clients';

    protected $primaryKey = 'id';

    protected $fillable = [
        'client_name',
        'client_email',
        'company_name',
        'company_email',
        'company_website',
        'company_phone',
        'billing_address',
        'hourly_rate',
        'currency_id',
        'status',
        'private_notes',
        'user_id',
    ];


    /**
     * Interact with the client's name.
     * Automatically capitalizes first letter of each word when accessed.
     */
    protected function clientName(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => $value ? Str::title($value) : null,
        );
    }

    /**
     * Interact with the company name.
     */
    protected function companyName(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => $value ? Str::title($value) : null,
        );
    }

    /**
     * Interact with the status (e.g., 'active' becomes 'Active').
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => $value ? ucfirst($value) : null,
        );
    }

    /**
     * Interact with the billing address (Title Case).
     */
    protected function billingAddress(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => $value ? Str::title($value) : null,
        );
    }

    /**
     * Interact with the currency (Uppercase).
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    /**
     * Interact with private notes (Sentence case).
     */
    protected function privateNotes(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => $value ? ucfirst(strtolower($value)) : null,
        );
    }


    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
