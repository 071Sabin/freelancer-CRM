<?php

namespace App\Observers;

use App\Models\Project;
use App\Models\AggregateStat;

class ProjectObserver
{
    /**
     * Handle the Project "created" event.
     */
    public function created(Project $project): void
    {
        $uid = $project->user_id;
        $monthKey = "projects_" . $project->created_at->format('Y_m');

        AggregateStat::adjust($uid, 'total_projects', 1);
        AggregateStat::adjust($uid, $monthKey, 1);

        if ($project->status === 'in_progress') {
            AggregateStat::adjust($uid, 'in_progress_projects', 1);
        } elseif ($project->status === 'completed') {
            AggregateStat::adjust($uid, 'completed_projects', 1);
        }
    }

    /**
     * Handle the Project "updated" event.
     */
    public function updated(Project $project): void
    {
        $uid = $project->user_id;

        if ($project->wasChanged('status')) {
            // Remove the old status count
            $oldStatus = $project->getOriginal('status');
            if ($oldStatus === 'in_progress') AggregateStat::adjust($uid, 'in_progress_projects', -1);
            if ($oldStatus === 'completed') AggregateStat::adjust($uid, 'completed_projects', -1);

            // Add the new status count
            $newStatus = $project->status;
            if ($newStatus === 'in_progress') AggregateStat::adjust($uid, 'in_progress_projects', 1);
            if ($newStatus === 'completed') AggregateStat::adjust($uid, 'completed_projects', 1);
        }
    }

    /**
     * Handle the Project "deleted" event.
     */
    public function deleted(Project $project): void
    {
        $uid = $project->user_id;
        $monthKey = "projects_" . $project->created_at->format('Y_m');

        AggregateStat::adjust($uid, 'total_projects', -1);
        AggregateStat::adjust($uid, $monthKey, -1);

        if ($project->status === 'in_progress') {
            AggregateStat::adjust($uid, 'in_progress_projects', -1);
        } elseif ($project->status === 'completed') {
            AggregateStat::adjust($uid, 'completed_projects', -1);
        }
    }

    /**
     * Handle the Project "restored" event.
     */
    public function restored(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "force deleted" event.
     */
    public function forceDeleted(Project $project): void
    {
        //
    }
}
