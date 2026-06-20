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

        $status = \App\Enums\ProjectStatus::tryFrom($project->status?->value ?? $project->status);
        if ($status === \App\Enums\ProjectStatus::ACTIVE) {
            AggregateStat::adjust($uid, 'active_projects', 1);
        } elseif ($status === \App\Enums\ProjectStatus::IN_PROGRESS) {
            AggregateStat::adjust($uid, 'in_progress_projects', 1);
        } elseif ($status === \App\Enums\ProjectStatus::COMPLETED) {
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
            $oldStatus = \App\Enums\ProjectStatus::tryFrom($project->getOriginal('status')?->value ?? $project->getOriginal('status'));
            if ($oldStatus === \App\Enums\ProjectStatus::ACTIVE) AggregateStat::adjust($uid, 'active_projects', -1);
            if ($oldStatus === \App\Enums\ProjectStatus::IN_PROGRESS) AggregateStat::adjust($uid, 'in_progress_projects', -1);
            if ($oldStatus === \App\Enums\ProjectStatus::COMPLETED) AggregateStat::adjust($uid, 'completed_projects', -1);

            // Add the new status count
            $newStatus = \App\Enums\ProjectStatus::tryFrom($project->status?->value ?? $project->status);
            if ($newStatus === \App\Enums\ProjectStatus::ACTIVE) AggregateStat::adjust($uid, 'active_projects', 1);
            if ($newStatus === \App\Enums\ProjectStatus::IN_PROGRESS) AggregateStat::adjust($uid, 'in_progress_projects', 1);
            if ($newStatus === \App\Enums\ProjectStatus::COMPLETED) AggregateStat::adjust($uid, 'completed_projects', 1);
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

        $status = \App\Enums\ProjectStatus::tryFrom($project->status?->value ?? $project->status);
        if ($status === \App\Enums\ProjectStatus::ACTIVE) {
            AggregateStat::adjust($uid, 'active_projects', -1);
        } elseif ($status === \App\Enums\ProjectStatus::IN_PROGRESS) {
            AggregateStat::adjust($uid, 'in_progress_projects', -1);
        } elseif ($status === \App\Enums\ProjectStatus::COMPLETED) {
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
