<?php

namespace App\Livewire\Dashboard;

use App\Models\AggregateStat;
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


    public function mount()
    {
        $userId = Auth::id();

        // ⚡ ONE QUERY TO RULE THEM ALL
        // This grabs every single stat for this user in 1-2 milliseconds.
        // It returns a clean array: ['total_clients' => 1500, 'active_projects' => 45, ...]
        $allStats = AggregateStat::where('user_id', $userId)
            ->pluck('value', 'key');

        // Dynamic keys for time-based metrics
        $clientMonthKey = "clients_" . now()->format('Y_m');
        $revMonthKey    = "revenue_" . now()->format('Y_m');

        // 🧠 The O(1) Match Statement
        // We are just reading from our pre-calculated $allStats array. Zero database hits here.
        $stats = match ($this->type) {
            'total_clients' => [
                'value' => $allStats['total_clients'] ?? 0,
                'meta'  => "+" . ($allStats[$clientMonthKey] ?? 0) . " new this month"
            ],

            'active_projects' => [
                'value' => $allStats['active_projects'] ?? 0,
                'meta'  => ($allStats['in_progress_projects'] ?? 0) . " in progress"
            ],

            'total_revenue' => [
                'value' => $allStats['total_revenue'] ?? 0,
                // Growth % is complex. Storing 'revenue_this_month' is safer and faster.
                'meta'  => "$" . number_format($allStats[$revMonthKey] ?? 0, 2) . " this month"
            ],

            'total_invoices' => [
                'value' => $allStats['total_invoices'] ?? 0,
                'meta'  => ($allStats['pending_invoices'] ?? 0) . " pending"
            ],

            default => ['value' => 0, 'meta' => '']
        };

        $this->value = $stats['value'];
        $this->dataOverTime = $stats['meta'];
    }


    public function render()
    {   
        return view('livewire.dashboard.dashboard-stats-card');
    }
}
