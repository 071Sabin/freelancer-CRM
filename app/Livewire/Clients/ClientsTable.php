<?php

namespace App\Livewire\Clients;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Client;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class ClientsTable extends DataTableComponent
{
    protected $model = Client::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setPerPageAccepted([10, 25, 50]);
        // $this->setQueryStringDisabled();

        // $this->setPaginationMethod('simple');

        $this->setSearchPlaceholder('Search Clients...');

        $this->setSearchFieldAttributes([
            'class' => 'transition-none',
            'default' => true,
        ]);
    }

    public function builder(): Builder
    {
        return Client::query()
            ->with('currency')
            ->where('clients.user_id', auth()->id());
    }

    public function columns(): array
    {
        return [
            Column::make("Client name", "client_name")
                ->sortable()
                ->searchable()->format(function($value, $row){
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
                ->format(function ($value, $row) {
                $displayValue = $value ? e($value) : '—';
                    return '
                        <div class="flex flex-col leading-tight">
                            <span class="font-medium text-stone-800 dark:text-neutral-100">
                                ' . $displayValue . '
                            </span>

                            <span class="text-xs text-stone-500 dark:text-neutral-400">
                                ' . e($row->company_email ?? '—') . '
                            </span>
                        </div>';
            })->html(),
            Column::make("Company Email", "company_email")
                ->hideIf(true),
            Column::make('Hourly rate', 'hourly_rate')
            ->sortable()
            ->format(function ($value, $row){
                return strtoupper($row->currency->code ?? 'USD').' '.e(strtoupper($value));
            }),

            Column::make("Currency", "currency_id")
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
            Column::make("Created at", "created_at")->format(fn($value) => $value?->diffForHumans()),
            // Column::make("Updated at", "updated_at")
            //     ->sortable(),
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
                        return $query;
                    }
                    $query->where('status', $value);
                }),
            SelectFilter::make('Deleted','deleted_at')
                ->options([
                    '' => 'All',
                    'deleted' => 'Deleted',
                ])
                ->filter(function ($query, $value) {
                    if ($value === 'deleted') {
                        $query->onlyTrashed();
                    }
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
            Client::where('user_id', auth()->id())->whereIn('id', $ids)->delete();
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

