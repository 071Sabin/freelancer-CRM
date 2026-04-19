<?php

namespace App\Livewire\Dashboard;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;

class DashboardStatsCard extends Component
{
    public $heading, $type;
    public $icon, $value, $dataOverTime, $dataColor;

    public function placeholder()
    {
        return view('components.skeleton-cards');
    }


    public function mount(){
        $userId = Auth::user()->id;
        $cacheTime = 3600;

        // This is where the card "decides" who it is
        $stats = match ($this->type) {
            'total_clients' => [
                'value' => Cache::remember("{$userId}_client_count", $cacheTime, fn() => Client::where('user_id', $userId)->count()),
                'meta'  => "+3 new this month"
            ],
            'active_projects' => [
                'value' => Cache::remember("user_{$userId}_proj", $cacheTime, fn() => Project::where(['user_id' => $userId, 'status' => 'active'])->count()),
                'meta'  => Project::where(['user_id' => $userId, 'status' => 'in_progress'])->count() . " in progress"
            ],
            'total_revenue' => [
                'value' => Cache::remember("user_{$userId}_rev", $cacheTime, fn() => Invoice::where(['user_id' => $userId, 'invoice_status' => 'paid'])->sum('paid_total')),
                'meta'  => "+12% growth"
            ],
            'total_invoices' => Cache::remember("user_{$userId}_total_invoices_data", $cacheTime, function () use ($userId) {
                // Explicitly run raw counts to avoid scope overhead
                return [
                    'value' => (int) Invoice::where('user_id', $userId)->count(),
                    'meta'  => (int) Invoice::where('user_id', $userId)->pending()->count() . " pending"
                ];
            }),
            default => ['value' => 0, 'meta' => '']
        };
        $this->value = $stats['value'] ?? 0;
        $this->dataOverTime = $stats['meta'] ?? '';
    }
    public function render()
    {   
        return view('livewire.dashboard.dashboard-stats-card');
    }
}
