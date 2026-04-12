<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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

    public function render()
    {
        $userId = Auth::id();
        $cacheTime = 600;

        $this->value = match ($this->type) {
            'total' => Cache::remember("{$userId}_client_count", $cacheTime, function () use ($userId) {
                return Client::where('user_id', $userId)->count();
            }),

            'active' => Cache::remember("{$userId}_active_clients", $cacheTime, function () use ($userId) {
                return Client::where('user_id', $userId)->where('status', 'active')->count();
            }),

            'acquisition' => Cache::remember("{$userId}_this_month_clients", $cacheTime, function () use ($userId) {
                return Client::where('user_id', $userId)
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count();
            }),

            default => 0,
        };

        return view('livewire.clients.client-stats-card');
    }
}
