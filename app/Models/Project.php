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

    protected $fillable = [
        'name',
        'description',
        'value',
        'client_id',
        'status',
    ];

    protected $casts = [
        'updated_at' => 'datetime',
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

    /**
     * Accessor for Description
     */
    protected function description(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ? Str::ucfirst($value) : null,
        );
    }
    /**
     * Accessor for Deadlines
     */
    protected function deadline(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ? Carbon::parse($value) : null,
        );
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
