<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    
        public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
