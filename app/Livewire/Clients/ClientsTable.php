<?php

namespace App\Livewire\Clients;


use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class ClientsTable extends DataTableComponent
{
    protected $model = Client::class;

    public $color = 'zinc';
    public $thBg = 'bg-neutral-700/90';
    public $tableOddRowBg = 'bg-zinc-800';
    public $tableEvenRowBg = 'bg-zinc-700';

    public $editClient = [];
    public $showEditModal = false;
    public $showAddClientForm = false;

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setPerPageAccepted([10, 25, 50, 100]);
        // $this->setSearchIcon('bi bi-search');

        $this->setSearchPlaceholder('Search Clients...');

        $this->setSearchFieldAttributes([
            'class' => 'px-2 rounded-lg dark:' . $this->thBg,
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
            Column::make("Client name", "client_name")
                ->sortable()->format(fn($value) => ucfirst($value))->searchable(),
            Column::make("Company name", "company_name")
                ->sortable()->format(fn($value) => ucfirst($value))->searchable(),
            // Column::make("Company email", "company_email")
            //     ->sortable(),
            // Column::make("Company website", "company_website")
            //     ->sortable(),
            // Column::make("Company phone", "company_phone")
            //     ->sortable(),
            // Column::make("Billing address", "billing_address")
            //     ->sortable(),
            Column::make('Hourly rate', 'hourly_rate')->sortable(),

            // Column::make("Currency", "currency")
            //     ->sortable(),
            Column::make('Status', 'status')
                ->format(fn($value) => match ($value) {

                    'active' => '<span class="
                                    inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full
                                    bg-green-100 text-green-700
                                    border border-green-400
                                    dark:bg-green-900/30 dark:text-green-300 dark:border-green-500">
                                    Active
                                </span>',

                    'inactive' => '<span class="
                                    inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full
                                    bg-red-100 text-red-700
                                    border border-red-400
                                    dark:bg-red-900/30 dark:text-red-300 dark:border-red-500">
                                    Inactive
                                </span>',

                    default => '<span class="text-gray-500 dark:text-gray-400 text-xs">
                                    Unknown
                                </span>',
                })->html(),
            // Column::make("Private notes", "private_notes")
            //     ->sortable(),
            Column::make("Created at", "created_at")->format(fn($value) => $value?->diffForHumans())
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
            Column::make('Actions')
                ->label(fn($row) => '
        <button
            wire:click="$dispatch(\'edit-client\', [' . $row->id . ']).window"
            class="px-2 py-1 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700"
        >
            Edit
        </button>
    ')
                ->html(),
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
                    'active' => 'Active',
                    'inactive' => 'Inactive',
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
            Client::whereIn('id', $ids)->delete();
        });

        // Clear selection after delete
        $this->clearSelected();
    }
}
