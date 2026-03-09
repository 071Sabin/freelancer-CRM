<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'id';

    protected $fillable = [
        'project_id',
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

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
