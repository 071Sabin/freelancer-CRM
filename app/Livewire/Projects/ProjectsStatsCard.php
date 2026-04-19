<?php

namespace App\Livewire\Projects;

use App\Models\AggregateStat;
use App\Models\Client;
use App\Models\Currency;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

use Illuminate\Support\Facades\Cache;


class ProjectsStatsCard extends Component
{

    public $projectCount, $progressProjects, $thisMonthProjects, $clients, $currencies;
    public $heading, $type;
    public $icon, $value, $dataOverTime, $dataColor;

    public function mount()
    {
        $userId = Auth::id();

        // 1. Fetch ALL stats for this user in 1 millisecond
        $allStats = AggregateStat::where('user_id', $userId)->pluck('value', 'key');

        // 2. Generate dynamic time-series keys
        $thisMonthKey = "projects_" . now()->format('Y_m');
        $lastMonthKey = "projects_" . now()->subMonth()->format('Y_m');

        // 3. Map the O(1) dictionary values to the UI
        $stats = match ($this->type) {
            'project_count' => [
                'value' => $allStats['total_projects'] ?? 0,
                'meta'  => '<i class="bi bi-graph-up"></i> '.($allStats[$thisMonthKey] ?? 0) . " this month",
            ],

            'progress_projects' => [
                'value' => $allStats['in_progress_projects'] ?? 0,
                'meta'  => ($allStats['completed_projects'] ?? 0) . " completed",
            ],

            'this_month_projects' => [
                'value' => $allStats[$thisMonthKey] ?? 0,
                'meta'  => ($allStats[$lastMonthKey] ?? 0) . " last month",
            ],

            default => ['value' => 0, 'meta' => ''],
        };

        $this->value = $stats['value'];
        $this->dataOverTime = $stats['meta'];
    }

    public function render()
    {
        return view('livewire.projects.projects-stats-card');
    }
}
