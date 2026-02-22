<?php

namespace App\Livewire\Projects;

use App\Models\Project;
// use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Facades\DB;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class ProjectsTable extends DataTableComponent
{
    protected $model = Project::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setPerPageAccepted([10, 25, 50, 100]);

        $this->setSearchPlaceholder('Search Projects...');

        $this->setSearchFieldAttributes([
            'class' => 'transition-none',
            'default' => true,
        ]);
    }

    public function builder(): Builder
    {
        return Project::query()
            ->with('client');
    }

    public function columns(): array
    {
        return [
            Column::make('Project Currency', 'project_currency')->hideIf(true),
            Column::make('Id', 'id')->hideIf(true),

            // 👇 CRITICAL: ensures $row->client works reliably
            Column::make('Client ID', 'client_id')->hideIf(true),
            Column::make('Client Name', 'client.client_name')->hideIf(true),

            Column::make('Project', 'name')
                ->sortable()
                ->searchable()
                ->format(function ($value, $row) {
                    $projectName = $value ? ucwords($value) : 'Untitled Project';
                    $clientName = $row->client ? ucwords($row->client->client_name) : 'Unassigned';

                    $icon = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3 shrink-0 text-zinc-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>';

                    return '
                    <div class="flex flex-col justify-center min-w-[150px]">
                        <span class="font-medium text-sm text-zinc-900 dark:text-zinc-100 truncate max-w-[200px]" title="' . e($projectName) . '">
                            ' . e($projectName) . '
                        </span>
                        <div class="flex items-center gap-1 mt-0.5 text-xs text-zinc-500 dark:text-zinc-400">
                            ' . $icon . '
                            <span class="truncate max-w-[180px]" title="' . e($clientName) . '">
                                ' . e($clientName) . '
                            </span>
                        </div>
                    </div>';
                })
                ->html(),

            // 👇 UPGRADE: Formatted Money Column
            Column::make('Value', 'value')
                ->sortable()
                ->format(function ($value, $row) {
                    if ($value === null) return '<span class="text-zinc-400">—</span>';
                    return '<span class="font-mono text-zinc-700 dark:text-zinc-300 tabular-nums">' . $row->project_currency . ' ' . number_format((float)$value, 2) . '
                            </span>';
                })
                ->html(),

            Column::make('Hourly Rate', 'hourly_rate')
                ->sortable(),

            // 👇 UPGRADE: Modern "Ring" Badges (Cleaner than borders)
            Column::make('Status', 'status')
                ->sortable()
                ->format(fn($value) => match ($value) {
                    'active' => '<span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-700/10 dark:bg-blue-400/10 dark:text-blue-400 dark:ring-blue-400/30">Active</span>',
                    'in_progress' => '<span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20 dark:bg-amber-400/10 dark:text-amber-400 dark:ring-amber-400/30">In Progress</span>',
                    'on_hold' => '<span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md bg-zinc-50 text-zinc-600 ring-1 ring-inset ring-zinc-500/10 dark:bg-zinc-400/10 dark:text-zinc-400 dark:ring-zinc-400/20">On Hold</span>',
                    'completed' => '<span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20 dark:bg-emerald-400/10 dark:text-emerald-400 dark:ring-emerald-400/30">Completed</span>',
                    'cancelled' => '<span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/10 dark:bg-rose-400/10 dark:text-rose-400 dark:ring-rose-400/30">Cancelled</span>',
                    default => '<span class="text-xs text-zinc-500">Unknown</span>',
                })
                ->html(),

            // 👇 UPGRADE: Precise Date with Relative time on secondary line
            Column::make('Created', 'created_at')
                ->sortable()
                ->format(function ($value) {
                    return '
                    <div class="flex flex-col">
                        <span class="text-zinc-900 dark:text-zinc-200 font-medium">' . $value->format('M d, Y') . '</span>
                        <span class="text-xs text-zinc-400">' . $value->diffForHumans() . '</span>
                    </div>';
                })
                ->html(),

            Column::make('Actions', 'id')
                ->format(fn($value, $row) => view('components.actions.project-actions', ['row' => $row]))
                ->html(),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Status', 'status')
                ->options([
                    '' => 'All',
                    'active' => 'Active',
                    'in-progress' => 'In Progress',
                    'on-hold' => 'On Hold',
                    'completed' => 'Completed',
                    'cancelled' => 'Cancelled',
                ])
                // Explicitly qualify `projects.status` to avoid SQL ambiguity when joins exist.
                // This filter applies ONLY to the project lifecycle status, not client status.
                ->filter(function (Builder $query, $value) {
                    if ($value === '') {
                        return $query; // No filter applied when "All" is selected
                    }

                    return $query->where('projects.status', $value);
                }),
        ];
    }

    public function bulkActions(): array
    {
        return [
            'deleteSelected' => 'Delete Selected',
        ];
    }

    public function deleteSelected(): void
    {
        $ids = $this->getSelected();

        if (empty($ids)) {
            return;
        }

        DB::transaction(function () use ($ids) {
            Project::whereIn('id', $ids)->delete();
        });

        // Clear selection after delete
        $this->clearSelected();
    }
}
