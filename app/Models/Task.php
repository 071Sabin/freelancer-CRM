<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Task extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'id';

    protected $fillable = [
        'project_id',
        'description',
        'title',
        'is_completed',
        'position',
    ];

    // 🚨 DATA INTEGRITY: This ensures that in the API or frontend,
    // `is_completed` always appears as true/false, not 1 or 0.
    protected $casts = [
        'is_completed' => 'boolean',
        'position' => 'integer',
    ];

    protected function title(): Attribute
    {
        return Attribute::make(
            get: fn($value) => \Illuminate\Support\Str::title($value)
        );
    }

    protected function description(): Attribute
    {
        return Attribute::make(
            get: fn($value) => \Illuminate\Support\Str::ucfirst($value)
        );
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
