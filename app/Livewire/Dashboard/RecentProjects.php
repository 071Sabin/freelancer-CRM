<?php

namespace App\Livewire\Dashboard;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class RecentProjects extends Component
{
    public $recentProjects = null;

    public function render()
    {
        $userId = Auth::user()->id;
        $cacheTime = 3600;
        $userKey = "dashboard_stats_user_{$userId}";
        // dd(Cache::get("{$userKey}_recent_projects"));

        // sleep(5);
        // 3. Recent Projects (Usually cached for a shorter time, e.g., 5 mins)
        $this->recentProjects = Cache::remember("{$userKey}_recent_projects", $cacheTime, function () use ($userId) {
            return Project::query()
                ->with('client:id,client_name')
                ->where('user_id', $userId)
                ->latest('created_at')
                ->take(3)
                ->get();
        });

        return view('livewire.dashboard.recent-projects');
    }
}
