<?php

namespace App\Livewire\Projects;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class ProjectsTable extends DataTableComponent
{
    protected $model = Project::class;
    public $color = 'neutral';
    public $thBg = 'bg-neutral-700/90';
    public $tableOddRowBg = 'bg-neutral-800';
    public $tableEvenRowBg = 'bg-neutral-700';
    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setPerPageAccepted([10, 25, 50, 100]);
        // $this->setSearchIcon('heroicon-m-magnifying-glass');


        $this->setSearchPlaceholder('Search Projects...');

        $this->setSearchFieldAttributes([
            'class' => 'px-2 py-2 sm:w-100 lg:w-fit rounded-lg dark:' . $this->thBg,
            'default-styling' => true,
        ]);


        $this->setComponentWrapperAttributes([
            'default' => true,
            'default-colors' => false,
        ]);

        $this->setTableWrapperAttributes([
            'default' => true,
            'default-colors' => false,
            'class' => 'dark:border-stone-500 dark:' . $this->tableOddRowBg,
        ]);

        $this->setTableAttributes([
            'default' => true,
            'default-colors' => false,
            'class' => 'dark:' . $this->tableEvenRowBg,
        ]);

        $this->setThAttributes(function (Column $column) {

            return ['class' => 'py-4 dark:' . $this->thBg, 'default' => true];
        });

        $this->setTbodyAttributes([
            'default' => true,
            'default-colors' => false,
            'class' => 'dark:' . $this->tableEvenRowBg,
        ]);

        $this->setTrAttributes(function ($row, $index) {
            return [
                'default' => true,
                'default-colors' => false,
                'class' => $index % 2 === 0
                    ? 'dark:' . $this->tableOddRowBg
                    : 'dark:' . $this->tableEvenRowBg,
            ];
        });

        $this->setTdAttributes(function (Column $column) {
            if ($column->getTitle() == 'reorder') {
                return [
                    'class' => 'dark:' . $this->tableEvenRowBg,
                    'default' => false,
                    // 'default-colors' => false,
                ];
            }
            return ['default' => true];
        });

        $this->setBulkActionsThAttributes([
            'class' => 'dark:' . $this->thBg,
            'default' => true
        ]);

        $this->setBulkActionsButtonAttributes([
            'class' => 'border dark:' . $this->tableOddRowBg,
            'default-colors' => true,
            'default-styling' => true,
        ]);

        $this->setBulkActionsMenuAttributes([
            'class' => 'dark:' . $this->tableOddRowBg,
            'default-colors' => true,
            'default-styling' => true,
        ]);

        $this->setBulkActionsMenuItemAttributes([
            'class' => 'dark:' . $this->tableOddRowBg . ' dark:hover:text-stone-200 cursor-pointer dark:hover:' . $this->tableOddRowBg,
            'default-colors' => true,
            'default-styling' => true,
        ]);

        $this->setColumnSelectButtonAttributes([
            'class' => 'border dark:' . $this->tableOddRowBg,
            'default-colors' => true,
            'default-styling' => true,
        ]);


        // this is the bg of pop over after clicking filter button
        $this->setFilterPopoverAttributes([
            'class' => 'dark:' . $this->tableOddRowBg,
            'default-colors' => true,
            'default-styling' => true,
        ]);



        // this is the row per page drop down 10, 20, 30 50 etc... beside of clolumns menu
        $this->setPerPageFieldAttributes([
            'class' => 'py-2 border px-1 dark:' . $this->tableOddRowBg, // Add these classes to the dropdown
            'default-styles' => true, // Output the default styling
        ]);

        $this->setBulkActionsThCheckboxAttributes([
            'default-colors' => true,
            'default-styling' => true,
        ]);
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Name", "name")
                ->sortable()->searchable(),
            Column::make("Value", "value")
                ->sortable(),
            Column::make('Status', 'status')
                ->format(fn($value) => match ($value) {

                    'completed' => '<span class="
                        inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full
                        bg-green-100 text-green-700
                        border border-green-400
                        dark:bg-green-900/30 dark:text-green-300 dark:border-green-500">
                        Completed
                    </span>',

                    'pending' => '<span class="
                        inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full
                        bg-red-100 text-red-700
                        border border-red-400
                        dark:bg-red-900/30 dark:text-red-300 dark:border-red-500">
                        Pending
                    </span>',

                    'in-progress' => '<span class="
                        inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full
                        bg-amber-100 text-amber-700
                        border border-amber-400
                        dark:bg-amber-900/30 dark:text-amber-300 dark:border-amber-500">
                        In Progress
                    </span>',

                    default => '<span class="text-gray-500 dark:text-gray-400 text-xs">
                                    Unknown
                                </span>',
                })->html(),
            Column::make("Created at", "created_at")->format(fn($value) => $value?->diffForHumans())
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),

            Column::make('Actions')
                ->label(fn($row) => '
                
                    <div class="flex items-center justify-center gap-1">

                        <button
                            type="button"
                            wire:click="$dispatch(\'edit-project\', [' . $row->id . ']).window"
                            class="inline-flex items-center justify-center w-9 h-9 rounded-md
                                text-blue-600 hover:text-blue-700
                                bg-blue-50 hover:bg-blue-100
                                dark:text-blue-400 dark:bg-blue-900/30 dark:hover:bg-blue-900/50
                                transition focus:outline-none focus:ring-2 focus:ring-blue-400"
                            title="Edit Project">
                            <i class="bi bi-pencil-square text-base"></i>
                        </button>

                        <button
                            type="button"
                            wire:click="$dispatch(\'view-project\', [' . $row->id . ']).window"
                            class="inline-flex items-center justify-center w-9 h-9 rounded-md
                                text-emerald-600 hover:text-emerald-700
                                bg-emerald-50 hover:bg-emerald-100
                                dark:text-emerald-400 dark:bg-emerald-900/30 dark:hover:bg-emerald-900/50
                                transition focus:outline-none focus:ring-2 focus:ring-emerald-400"
                            title="View Project">
                            <i class="bi bi-eye text-base"></i>
                        </button>

                    </div>
                ')->html(),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Status', 'status')
                ->setInputAttributes([
                    'class' => 'px-1 shadow-none py-2 dark:' . $this->tableEvenRowBg . ' dark:text-' . $this->color . '-200',
                    'default-styling' => true,
                ])
                ->options([
                    '' => 'All',
                    'completed' => 'Completed',
                    'in-progress' => 'In Progress',
                    'pending' => 'Pending',
                ])
                ->filter(function ($query, $value) {
                    if ($value === '') {
                        return;
                    }
                    $query->where('status', $value);
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
