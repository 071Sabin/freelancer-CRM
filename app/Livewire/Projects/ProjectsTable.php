<?php

namespace App\Livewire\Projects;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Project;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
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

    public function query(): Builder
    {
        return Project::query()
            ->with('client'); // ✅ avoid N+1 queries
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Name", "name")
                ->sortable()->searchable()->format(function ($value, $row) {
                    return (ucwords($value));
                }),
            Column::make('Client', 'client.client_name')->searchable()->sortable()->format(function ($value) {
                return (e(ucwords($value)));
            }),
            Column::make("Value", "value")
                ->sortable(),

            Column::make('Status', 'status')->sortable()
                ->format(fn($value) => match ($value) {

                    'active' => '
            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full
                bg-blue-100 text-blue-700 border border-blue-400
                dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-500">
                Active
            </span>
        ',

                    'in-progress' => '
            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full
                bg-amber-100 text-amber-700 border border-amber-400
                dark:bg-amber-900/30 dark:text-amber-300 dark:border-amber-500">
                In Progress
            </span>
        ',

                    'on-hold' => '
            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full
                bg-gray-100 text-gray-700 border border-gray-400
                dark:bg-gray-900/30 dark:text-gray-300 dark:border-gray-500">
                On Hold
            </span>
        ',

                    'completed' => '
            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full
                bg-green-100 text-green-700 border border-green-400
                dark:bg-green-900/30 dark:text-green-300 dark:border-green-500">
                Completed
            </span>
        ',

                    'cancelled' => '
            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full
                bg-rose-100 text-rose-700 border border-rose-400
                dark:bg-rose-900/30 dark:text-rose-300 dark:border-rose-500">
                Cancelled
            </span>
        ',

                    default => '
            <span class="text-xs text-gray-500 dark:text-gray-400">
                Unknown
            </span>
        ',
                })
                ->html(),


            Column::make("Created at", "created_at")->format(fn($value) => $value?->diffForHumans())
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),

            Column::make('Actions', 'id')
                ->format(fn($value, $row, Column $column) => view('components.actions.project-actions', ['row' => $row]))
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
