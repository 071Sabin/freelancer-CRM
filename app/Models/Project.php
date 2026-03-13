<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;
    protected $table = 'projects';

    protected $primaryKey = 'id';
    protected $timestamp = true;

    protected $fillable = [
        'name',
        'description',
        'value',
        'client_id',
        'status',
        'currency_id',
        'hourly_rate',
        'deadline',
        'user_id',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }
    /**
     * Accessor for Name
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => $value ? Str::title($value) : null,
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
            get: fn(?string $value) => $value ? Str::ucfirst($value) : null,
        );
    }
    /**
     * The Relationship
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function tasks()
    {
        // Tasks will always be sorted by their position, ensuring a consistent order in the UI.
        return $this->hasMany(\App\Models\Task::class)->orderBy('position', 'asc');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
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

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
