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
                ->format(
                    fn($value, $row) => view('components.badges.project-status', [
                        'project_status' => $value,
                    ])
                ),

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
    <div class="w-full min-w-full animate-pulse">

        <!-- Top Controls -->
        <div class="flex items-center justify-between p-4">
            <div class="flex gap-3 w-full max-w-md">
                <div class="h-10 w-full bg-neutral-200 dark:bg-neutral-700 rounded-lg"></div>
                <div class="h-10 w-28 bg-neutral-200 dark:bg-neutral-700 rounded-lg"></div>
            </div>

            <div class="flex gap-3">
                <div class="h-10 w-24 bg-neutral-200 dark:bg-neutral-700 rounded-lg"></div>
                <div class="h-10 w-16 bg-neutral-200 dark:bg-neutral-700 rounded-lg"></div>
            </div>
        </div>

        <!-- Table Header -->
        <div class="px-4 py-3 border-t border-b border-neutral-200 dark:border-neutral-700">
            <div class="grid grid-cols-12 gap-4">
                <div class="h-4 bg-neutral-200 dark:bg-neutral-700 rounded col-span-2"></div>
                <div class="h-4 bg-neutral-200 dark:bg-neutral-700 rounded col-span-4"></div>
                <div class="h-4 bg-neutral-200 dark:bg-neutral-700 rounded col-span-2"></div>
                <div class="h-4 bg-neutral-200 dark:bg-neutral-700 rounded col-span-2"></div>
                <div class="h-4 bg-neutral-200 dark:bg-neutral-700 rounded col-span-1"></div>
                <div class="h-4 bg-neutral-200 dark:bg-neutral-700 rounded col-span-1"></div>
            </div>
        </div>

        <!-- Rows -->
        <div class="divide-y divide-neutral-200 dark:divide-neutral-700">

            <!-- Row -->
            <div class="px-4 py-4 grid grid-cols-12 gap-4 items-center">
                
                <!-- Invoice # -->
                <div class="h-4 w-24 bg-neutral-200 dark:bg-neutral-700 rounded col-span-2"></div>

                <!-- Project + Client -->
                <div class="col-span-4 space-y-2">
                    <div class="h-4 w-3/4 bg-neutral-200 dark:bg-neutral-700 rounded"></div>
                    <div class="h-3 w-1/3 bg-neutral-200 dark:bg-neutral-700 rounded"></div>
                </div>

                <!-- Status -->
                <div class="col-span-2">
                    <div class="h-6 w-16 bg-neutral-200 dark:bg-neutral-700 rounded-full"></div>
                </div>

                <!-- Due Date -->
                <div class="col-span-2 space-y-2">
                    <div class="h-4 w-24 bg-neutral-200 dark:bg-neutral-700 rounded"></div>
                    <div class="h-3 w-20 bg-neutral-200 dark:bg-neutral-700 rounded"></div>
                </div>

                <!-- Payment Progress -->
                <div class="col-span-1 space-y-2">
                    <div class="h-3 w-12 bg-neutral-200 dark:bg-neutral-700 rounded"></div>
                    <div class="h-2 w-full bg-neutral-200 dark:bg-neutral-700 rounded"></div>
                </div>

                <!-- Actions -->
                <div class="col-span-1 flex gap-2 justify-end">
                    <div class="h-5 w-5 bg-neutral-200 dark:bg-neutral-700 rounded"></div>
                    <div class="h-5 w-5 bg-neutral-200 dark:bg-neutral-700 rounded"></div>
                    <div class="h-5 w-5 bg-neutral-200 dark:bg-neutral-700 rounded"></div>
                </div>
            </div>

            <!-- Duplicate rows (x4 for realism) -->
            <div class="px-4 py-4 grid grid-cols-12 gap-4 items-center">
                <div class="h-4 w-20 bg-neutral-200 dark:bg-neutral-700 rounded col-span-2"></div>
                <div class="col-span-4 space-y-2">
                    <div class="h-4 w-2/3 bg-neutral-200 dark:bg-neutral-700 rounded"></div>
                    <div class="h-3 w-1/4 bg-neutral-200 dark:bg-neutral-700 rounded"></div>
                </div>
                <div class="col-span-2">
                    <div class="h-6 w-14 bg-neutral-200 dark:bg-neutral-700 rounded-full"></div>
                </div>
                <div class="col-span-2 space-y-2">
                    <div class="h-4 w-20 bg-neutral-200 dark:bg-neutral-700 rounded"></div>
                    <div class="h-3 w-16 bg-neutral-200 dark:bg-neutral-700 rounded"></div>
                </div>
                <div class="col-span-1 space-y-2">
                    <div class="h-3 w-10 bg-neutral-200 dark:bg-neutral-700 rounded"></div>
                    <div class="h-2 w-full bg-neutral-200 dark:bg-neutral-700 rounded"></div>
                </div>
                <div class="col-span-1 flex gap-2 justify-end">
                    <div class="h-5 w-5 bg-neutral-200 dark:bg-neutral-700 rounded"></div>
                    <div class="h-5 w-5 bg-neutral-200 dark:bg-neutral-700 rounded"></div>
                    <div class="h-5 w-5 bg-neutral-200 dark:bg-neutral-700 rounded"></div>
                </div>
            </div>

        </div>
    </div>
    HTML;
    }

}
