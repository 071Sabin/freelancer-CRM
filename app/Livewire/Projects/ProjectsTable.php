<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Carbon\Carbon;
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
        // return Project::query()->where('projects.user_id', auth()->id());
        return Project::query()
            ->with(['client', 'currency']) // Fetch relationships instantly
            ->select('projects.*')         // Prevent ID column collisions
            ->where('projects.user_id', auth()->id());
    }


    public function columns(): array
    {
        return [
            Column::make('Project Currency', 'currency_id')->hideIf(true),
            Column::make('Id', 'id')->hideIf(true),
            Column::make('created at', 'created_at')->hideIf(true),

            // 👇 CRITICAL: ensures $row->client works reliably
            Column::make('Client ID', 'client_id')->hideIf(true),
            Column::make('Client Name', 'client.client_name')->hideIf(true),

            Column::make('Project', 'name')
                ->sortable()
                ->searchable()
                ->format(function ($value, $row) {
                    $projectName = $value ? ucwords($value) : 'Untitled Project';
                    $clientName = $row->client ? ucwords($row->client->client_name) : 'Unassigned';

                    $icon = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3 shrink-0 text-neutral-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>';

                    return '
                    <div class="flex flex-col justify-center min-w-[150px]">
                        <span class="font-medium text-sm text-neutral-900 dark:text-neutral-100 truncate max-w-[200px]" title="' . e($projectName) . '">
                            ' . e($projectName) . '
                        </span>
                        <div class="flex items-center gap-1 mt-0.5 text-xs text-neutral-500 dark:text-neutral-400">
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
                    return '<span class="font-mono text-neutral-700 dark:text-neutral-300 tabular-nums">' . ($row->currency->code ?? 'USD') . ' ' . number_format((float)$value, 2) . '
                            </span>';
                })
                ->html(),

            Column::make('Currency', 'currency_id')->hideIf(true),

            Column::make('Hourly rate', 'hourly_rate')->sortable()->format(function ($value, $row) {
                return strtoupper($row->currency->symbol ?? '$') . ' ' . e(strtoupper($value));
            }),

            // 👇 UPGRADE: Modern "Ring" Badges (Cleaner than borders)
            Column::make('Status', 'status')
                ->sortable()
                ->format(fn($value) => match ($value) {
                    'active' => '<span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-700/10 dark:bg-blue-400/10 dark:text-blue-400 dark:ring-blue-400/30">Active</span>',
                    'in_progress' => '<span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20 dark:bg-amber-400/10 dark:text-amber-400 dark:ring-amber-400/30">In Progress</span>',
                    'on_hold' => '<span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md bg-neutral-50 text-neutral-600 ring-1 ring-inset ring-neutral-500/10 dark:bg-neutral-400/10 dark:text-neutral-400 dark:ring-neutral-400/20">On Hold</span>',
                    'completed' => '<span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20 dark:bg-emerald-400/10 dark:text-emerald-400 dark:ring-emerald-400/30">Completed</span>',
                    'cancelled' => '<span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/10 dark:bg-rose-400/10 dark:text-rose-400 dark:ring-rose-400/30">Cancelled</span>',
                    default => '<span class="text-xs text-neutral-500">Unknown</span>',
                })
                ->html(),

            // 👇 UPGRADE: Precise Date with Relative time on secondary line
            Column::make('Deadline', 'deadline')
                ->sortable()
                ->format(function ($value, $row) {
                    if (!$value) return '<span class="text-neutral-400">No Deadline</span>';

                    // Check if the deadline has passed (is in the past)
                    $isOverdue = Carbon::parse($value)->isPast();
                    // $isOverdue = $value->isPast();

                    // Define the color: Red for overdue, Neutral for upcoming
                    $dateColorClass = $isOverdue
                        ? 'text-red-600 dark:text-red-400 font-bold'
                        : 'text-neutral-900 dark:text-neutral-200 font-medium';

                    return '
        <div class="flex flex-col">
            <div class="flex items-center gap-1.5">
                ' . ($isOverdue ? '<span class="flex h-1.5 w-1.5 rounded-full bg-red-600 animate-pulse"></span>' : '') . '
                <span class="' . $dateColorClass . '">' . Carbon::parse($value)->format('M d, Y') . '</span>
            </div>
            <span class="text-xs text-neutral-400">Issued: ' . $row->created_at->format('M d, Y') . '</span>
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
                    'in_progress' => 'In Progress',
                    'on_hold' => 'On Hold', 
                    'completed' => 'Completed',
                    'cancelled' => 'Cancelled',
                ])
                ->filter(function (Builder $query, $value) {
                    if ($value === '') {
                        return $query;
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
            // ::whereIn('id', $ids)->delete();
        Project::where('projects.user_id', auth()->id())->whereIn('id', $ids)->delete();
        });

        // Clear selection after delete
        $this->clearSelected();
    }


    public function placeholder()
    {
        return <<<'HTML'
        <div class="w-full min-w-full h-64 flex flex-col items-center justify-center transition-all duration-200">
            <svg class="animate-spin h-6 w-6 text-neutral-400 dark:text-neutral-500 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-sm font-medium text-neutral-500 dark:text-neutral-400 tracking-wide">
                Loading projects...
            </span>
        </div>
        HTML;
    }

}
