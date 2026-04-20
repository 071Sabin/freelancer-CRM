<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'plans';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;
    
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
