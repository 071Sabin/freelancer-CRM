<?php

namespace App\Livewire\Projects;

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
        $userId = Auth::user()->id;
        $cacheTime = 3600;

        $stats = match ($this->type) {

            'project_count' => Cache::remember("user:{$userId}:project_count_data", $cacheTime, fn() => [
                'value' => Project::where('user_id', $userId)->count(),
                'meta'  => Project::where('user_id', $userId)->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count() . " this month",
            ]),

            'progress_projects' => Cache::remember("user:{$userId}:progress_projects_data", $cacheTime, fn() => [
                'value' => Project::where(['user_id' => $userId, 'status' => 'in_progress'])->count(),
                'meta'  => Project::where(['user_id' => $userId, 'status' => 'completed'])->count() . " completed",
            ]),

            'this_month_projects' => Cache::remember("user:{$userId}:this_month_projects_data", $cacheTime, fn() => [
                'value' => Project::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->where('user_id', $userId)->count(),
                'meta'  => Project::whereMonth('created_at', now()->subMonth()->month)->whereYear('created_at', now()->subMonth()->year)->where('user_id', $userId)->count() . " last month",
            ]),

            default => ['value' => 0, 'meta' => ''],
        };

        $this->value = $stats['value'] ?? 0;
        $this->dataOverTime = $stats['meta'] ?? '';
    }
    public function render()
    {
        return view('livewire.projects.projects-stats-card');
    }
}
