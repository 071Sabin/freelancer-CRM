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

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setPerPageAccepted([10, 25, 50, 100]);


        $this->setSearchPlaceholder('Search Clients...');

        $this->setSearchFieldAttributes([
            'class' => 'transition-none',
            'default' => true,
        ]);
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Client name", "client_name")
                ->sortable()->searchable()->format(function($value, $row){
                return '
                        <div class="flex flex-col leading-tight">
                            <span class="font-medium text-stone-800 dark:text-neutral-100">
                                ' . e($value) . '
                            </span>

                            <span class="text-xs text-stone-500 dark:text-neutral-400">
                                ' . e($row->client_email ?? '—') . '
                            </span>
                        </div>';
            })->html(),
            
            Column::make('client Email', 'client_email')->hideIf(true),
            Column::make('Company', 'company_name')
                ->sortable()
                ->searchable()
                ->format(function ($value, $row) {
                    return '
                        <div class="flex flex-col leading-tight">
                            <span class="font-medium text-stone-800 dark:text-neutral-100">
                                ' . e($value) . '
                            </span>

                            <span class="text-xs text-stone-500 dark:text-neutral-400">
                                ' . e($row->company_email ?? '—') . '
                            </span>
                        </div>';
            })->html(),
            Column::make("Company Email", "company_email")
                ->hideIf(true),
            // Column::make("Company phone", "company_phone")
            //     ->sortable(),
            // Column::make("Billing address", "billing_address")
            //     ->sortable(),
            Column::make('Hourly rate', 'hourly_rate')->sortable()->format(function ($value, $row){
                return strtoupper($row->currency).' '.e(strtoupper($value));
            }),

            Column::make("Currency", "currency")
                ->hideIf(true),
            Column::make('Status', 'status')
                ->format(fn($value) => match ($value) {

                        'Active' => '<span class="
                        inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full
                        bg-green-100 text-green-700
                        border border-green-400
                        dark:bg-green-900/30 dark:text-green-300 dark:border-green-500">
                        Active
                    </span>',

                        'Inactive' => '<span class="
                        inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full
                        bg-red-100 text-red-700
                        border border-red-400
                        dark:bg-red-900/30 dark:text-red-300 dark:border-red-500">
                        Inactive
                    </span>',

                        'Lead' => '<span class="
                        inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full
                        bg-amber-100 text-amber-700
                        border border-amber-400
                        dark:bg-amber-900/30 dark:text-amber-300 dark:border-amber-500">
                        Lead
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
            Column::make('Actions', 'id')
                ->format(fn($value, $row, Column $column) => view('components.actions.client-actions', ['row' => $row]))
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
                    'inactive' => 'Inactive',
                    'lead' => 'Lead',
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
