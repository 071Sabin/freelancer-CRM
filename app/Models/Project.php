<?php

namespace App\Models;

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

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
