<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AggregateStat extends Model
{
    protected $guarded = [];

    /**
     * Atomically increment or decrement a stat.
     */
    public static function adjust($userId, $key, $amount = 1)
    {
        DB::table('aggregate_stats')->updateOrInsert(
            ['user_id' => $userId, 'key' => $key],
            ['value' => DB::raw("value + ($amount)"), 'updated_at' => now()]
        );
    }
}
