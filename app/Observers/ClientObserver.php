<?php

namespace App\Observers;

use App\Models\AggregateStat;
use App\Models\Client;

class ClientObserver
{
    /**
     * Handle the Client "created" event.
     */
    public function created(Client $client): void
    {
        $uid = $client->user_id;
        $monthKey = "clients_" . $client->created_at->format('Y_m');

        AggregateStat::adjust($uid, 'total_clients', 1);
        AggregateStat::adjust($uid, $monthKey, 1);

        if (\App\Enums\ClientStatus::tryFrom($client->status?->value ?? $client->status) === \App\Enums\ClientStatus::ACTIVE) {
            AggregateStat::adjust($uid, 'active_clients', 1);
        }
    }

    /**
     * Handle the Client "updated" event.
     */
    public function updated(Client $client): void
    {
        $uid = $client->user_id;

        // Only fire if the status specifically changed
        if ($client->wasChanged('status')) {

            // It became active
            if (\App\Enums\ClientStatus::tryFrom($client->status?->value ?? $client->status) === \App\Enums\ClientStatus::ACTIVE) {
                AggregateStat::adjust($uid, 'active_clients', 1);
            }
            // It was active, but changed to something else (inactive, pending, etc)
            elseif (\App\Enums\ClientStatus::tryFrom($client->getOriginal('status')?->value ?? $client->getOriginal('status')) === \App\Enums\ClientStatus::ACTIVE) {
                AggregateStat::adjust($uid, 'active_clients', -1);
            }
        }
    }

    /**
     * Handle the Client "deleted" event.
     */
    public function deleted(Client $client): void
    {
        $uid = $client->user_id;
        $monthKey = "clients_" . $client->created_at->format('Y_m');

        // Pass negative numbers to decrement
        AggregateStat::adjust($uid, 'total_clients', -1);
        AggregateStat::adjust($uid, $monthKey, -1);

        if (\App\Enums\ClientStatus::tryFrom($client->status?->value ?? $client->status) === \App\Enums\ClientStatus::ACTIVE) {
            AggregateStat::adjust($uid, 'active_clients', -1);
        }
    }

    /**
     * Handle the Client "restored" event.
     */
    public function restored(Client $client): void
    {
        // If you use SoftDeletes and they click "Restore", add the numbers back
        $this->created($client);
    }

    /**
     * Handle the Client "force deleted" event.
     */
    public function forceDeleted(Client $client): void
    {
        //
    }
}
