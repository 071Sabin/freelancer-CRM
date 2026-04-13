<?php

namespace App\Livewire\Dashboard;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class DashboardStatsCard extends Component
{
    public $totalClients = 0, $progressProjects = null, $activeProjects = null;
    public $totalRevenue = 0;
    public $pendingInvoices = 0;
    public $overdueInvoices = 0;
    public $invoices;

    public $heading, $type;
    public $icon, $value, $dataOverTime, $dataColor;

    public function placeholder()
    {
        return view('components.skeleton-cards');
    }


    public function render()
    {
        $userId = Auth::user()->id;
        $cacheTime = 3600;

        // This is where the card "decides" who it is
        $stats = match ($this->type) {
            'total_clients' => [
                'value' => Cache::remember("user_{$userId}_clients", $cacheTime, fn() => Client::where('user_id', $userId)->count()),
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
                return [
                    'value' => Invoice::totalInvoices($userId)->count(),
                    'meta'  => Invoice::where('user_id', $userId)->pending()->count() . " pending"
                ];
            }),
            default => ['value' => 0, 'meta' => '']
        };
        $this->value = $stats['value'] ?? 0;
        $this->dataOverTime = $stats['meta'] ?? '';
        
        return view('livewire.dashboard.dashboard-stats-card');
    }
}
