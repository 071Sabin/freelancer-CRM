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
        $updated = DB::table('aggregate_stats')
            ->where('user_id', $userId)
            ->where('key', $key)
            ->update([
                'value' => DB::raw('value + (' . (float) $amount . ')'),
                'updated_at' => now(),
            ]);

        if ($updated === 0) {
            DB::table('aggregate_stats')->insert([
                'user_id' => $userId,
                'key' => $key,
                'value' => $amount,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
