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

    protected $fillable = [
        'client_name',
        'company_name',
        'company_email',
        'company_website',
        'company_phone',
        'billing_address',
        'hourly_rate',
        'currency',
        'status',
        'private_notes',
    ];


    /**
     * Interact with the client's name.
     * Automatically capitalizes first letter of each word when accessed.
     */
    protected function clientName(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ? Str::title($value) : null,
        );
    }

    /**
     * Interact with the company name.
     */
    protected function companyName(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ? Str::title($value) : null,
        );
    }

    /**
     * Interact with the status (e.g., 'active' becomes 'Active').
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ? ucfirst($value) : null,
        );
    }

    /**
     * Interact with the billing address (Title Case).
     */
    protected function billingAddress(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ? Str::title($value) : null,
        );
    }

    /**
     * Interact with the currency (Uppercase).
     */
    protected function currency(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ? strtoupper($value) : null,
        );
    }

    /**
     * Interact with private notes (Sentence case).
     */
    protected function privateNotes(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ? ucfirst(strtolower($value)) : null,
        );
    }

    protected $table = 'clients';

    protected $primaryKey = 'id';

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
