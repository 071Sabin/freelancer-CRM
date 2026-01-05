<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    protected $table = 'clients';
    protected $primaryKey = 'id';
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}