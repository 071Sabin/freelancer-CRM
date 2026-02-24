<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'currencies';
    protected $primaryKey = 'id';

    protected $fillable = ['code', 'name', 'symbol', 'precision'];

    // Relation: One currency is used by many projects
    public function projects()
    {
        return $this->hasMany(Project::class, 'currency_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'currency_id');
    }
    public function clients()
    {
        return $this->hasMany(Client::class, 'currency_id');
    }
}
