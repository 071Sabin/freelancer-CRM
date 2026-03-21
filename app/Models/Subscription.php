<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'subscriptions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'plan_id',
        'dodo_subscription_id',
        'dodo_customer_id',
        'billing_cycle',
        'status',
        'current_period_start',
        'current_period_end',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'current_period_start' => 'datetime',
        'current_period_end'   => 'datetime',
    ];
}
