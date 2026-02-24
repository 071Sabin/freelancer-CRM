<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    protected $table = 'projects';

    protected $primaryKey = 'id';
    protected $timestamp = true;

    protected $fillable = [
        'name',
        'description',
        'value',
        'client_id',
        'status',
        'project_currency',
        'hourly_rate',
        'deadline',
    ];


    /**
     * Accessor for Name
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ? Str::title($value) : null,
        );
    }

    protected function deadline(): Attribute
    {
        return Attribute::make(
            // Always returns the format needed for the <input type="date">
            get: fn($value) => $value ? Carbon::parse($value)->format('Y-m-d') : null,
        );
    }

    /**
     * Accessor for Description
     */
    protected function description(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ? Str::ucfirst($value) : null,
        );
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    /**
     * The Relationship
     */
    public function currency()
    {
        return $this->belongsTo(currency::class);
    }

    /**
     * Professional Accessor: $project->price_display
     */
    public function getPriceDisplayAttribute()
    {
        // Fail-safe if relation isn't loaded
        if (!$this->currency) return number_format($this->value, 2);

        return $this->currency->symbol . ' ' . number_format($this->value, $this->currency->precision);
    }
}
