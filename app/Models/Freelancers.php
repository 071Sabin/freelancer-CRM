<?php

namespace App\Models;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Freelancers extends Authenticatable
{
    use Notifiable;

    protected $table = "freelancers";
    protected $primaryKey = "id";
}