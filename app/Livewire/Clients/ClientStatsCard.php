<?php

namespace App\Livewire\Clients;

use App\Models\AggregateStat;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ClientStatsCard extends Component
{
    public $type; // 'total', 'active', 'acquisition'
    public $heading;
    public $icon, $value;
    public $dataOverTime;
    public $dataColor;

    public function placeholder()
    {
        return view('components.skeleton-cards');
    }


    public function mount()
    {
        $userId = Auth::id();

        // 1. Map the component's 'type' to our exact database keys
        $statKey = match ($this->type) {
            'total'       => 'total_clients',
            'active'      => 'active_clients',
            'acquisition' => 'clients_' . now()->format('Y_m'), // e.g., 'clients_2026_04'
            default       => null,
        };

        // 2. Fetch the pre-calculated value in O(1) time
        if ($statKey) {
            // Because of our composite index ['user_id', 'key'], 
            // this query executes in < 1 millisecond, even with 1M rows.
            $this->value = AggregateStat::where('user_id', $userId)
                ->where('key', $statKey)
                ->value('value') ?? 0;
        } else {
            $this->value = 0;
        }
    }

    public function render()
    {
        return view('livewire.clients.client-stats-card');
    }
}
