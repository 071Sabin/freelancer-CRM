<?php

namespace App\Livewire\Invoices;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class InvoiceTable extends DataTableComponent
{
    protected $model = Invoice::class;

    public function configure(): void
    {

        $this->setPrimaryKey('id');
        $this->setPerPageAccepted([10, 25, 50, 100]);
        // $this->setQueryStringDisabled();
        // $this->setPaginationMethod('simple');
        // $this->setSearchIcon('heroicon-m-magnifying-glass');

        $this->setSearchPlaceholder('Search Invoices...');
        $this->setSearchFieldAttributes([
            'class' => 'transition-none',
            'default' => true,
        ]);
    }

    public function query(): Builder
    {
        return Invoice::query()->where(['user_id' => auth()->id()])
            ->with(['client' => fn($query) => $query->withTrashed(), 'project', 'currency']);
    }


    public function columns(): array
    {
        return [
            // Column::make('ID', 'id')->hideIf(true),

            // FIX 1: Add Hidden Columns to ensure data is available in $row
            // Column::make('Client ID', 'id')->hideIf(false),
            // Column::make('Client ID', 'uuid'),
            Column::make('Issue Date', 'issue_date')->hideIf(true),

            Column::make('Currency', 'currency.code')->hideIf(true),

            Column::make('Invoice #', 'invoice_number')
                ->sortable()
                ->searchable(),

            // This ensures the relationship is eager loaded for searching
            Column::make('Client', 'client.client_name')
                ->hideIf(true),

            Column::make('Project', 'project.name')
                ->sortable()
                ->searchable()
                ->format(function ($value, $row) {
                    // ❌ OLD: Uses raw DB value, bypassing accessor
                    // $projectName = $value ? e($value) : ...;

                    // ✅ NEW: Accesses the model relationship -> triggers Accessor
                    $projectName = $row->project ? $row->project->name : ($value ?? 'General / Unassigned');

                    // Ensure client name is also safe
                    $clientName = $row->client ? $row->client->client_name : 'No Client';

                    return '<div class="flex flex-col">
                    <span class="font-medium text-neutral-900 dark:text-white truncate" title="' . e($projectName) . '">
                        ' . e($projectName) . '
                    </span>
                    <div class="text-xs font-thin">
                        <span class="flex items-center gap-1 text-xs text-neutral-500 dark:text-neutral-400 mt-0.5 truncate">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            ' . e($clientName) . '
                        </span>
                    </div>
                </div>';
                })
                ->html(),
            Column::make('Status', 'invoice_status')
                ->format(
                    fn($value, $row) => view('components.badges.invoice-status', [
                        'invoice_status' => $value,
                    ])
                ),
            Column::make('Paid Total', 'paid_total')->hideIf(true),
            Column::make('Balance Due', 'balance_due')->hideIf(true),
            Column::make('Due Date', 'due_date')
                ->format(function ($value, $row) {
                    if (! $value) {
                        return '—';
                    }

                    $dueDate = Carbon::parse($value)->format('M d, Y');

                    // FIX 3: Now that 'issue_date' is defined as a hidden column above,
                    // $row->issue_date will now contain data.
                    $issueDate = $row->issue_date ? Carbon::parse($row->issue_date)->format('M d, Y') : '—';

                    $isOverdue = $value < now() && ! in_array($row->invoice_status, ['paid', 'void', 'canceled']);
                    $colorClass = $isOverdue ? 'text-red-600 font-bold' : 'text-neutral-700 dark:text-neutral-300 font-semibold';

                    return '<div class="flex flex-col">
                                <span class="' . $colorClass . '">' . $dueDate . '</span>
                                <span class="text-xs text-neutral-400">Issued: ' . $issueDate . '</span>
                            </div>';
                })
                ->html(),

            Column::make('Payment Progress', 'total')
                ->sortable()
                ->format(function ($value, $row) {
                    // 1. Safe Number Handling
                    $total = (float) $value;
                    $paid = (float) ($row->paid_total ?? 0);
                    $due = (float) ($row->balance_due ?? 0);
                    $currency = $row->{'currency.code'};
                    
                    // 2. Calculate Percentage for the Bar (Cap at 100%)
                    $percent = $total > 0 ? ($paid / $total) * 100 : 0;
                    $percent = min(100, max(0, $percent)); // Clamp between 0-100

                    // 3. Determine Status Styling
                    $isFullyPaid = $due <= 0.01; // Float tolerance

                    // Formatted Strings
                    $formattedTotal = number_format($total, 2);
                    $formattedDue = number_format($due, 2);

                    // Dynamic HTML
                    // - If Paid: Show Green "Paid" text
                    // - If Due: Show Red "Due: $XX" text
                    $statusText = $isFullyPaid
                        ? '<span class="text-emerald-600 dark:text-emerald-400 font-medium">Fully Paid</span>'
                        : '<span class="text-red-600 dark:text-red-400 font-medium">Due: <span class="font-mono text-[10px] opacity-80">' . $currency . ' ' . '</span>' . $formattedDue . '</span>';

                    return '
                <div class="flex flex-col min-w-[120px]">
                    <div class="flex items-baseline gap-1">
                        <span class="text-[10px] font-medium text-neutral-400 uppercase">' . $currency . '</span>
                        <span class="font-mono font-bold text-neutral-900 dark:text-neutral-100 text-sm tabular-nums">
                            ' . $formattedTotal . '
                        </span>
                    </div>

                    <div class="w-full h-1.5 bg-neutral-200 dark:bg-neutral-600 rounded-full mt-1.5 overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full transition-all duration-500" 
                             style="width: ' . $percent . '%"></div>
                    </div>

                    <div class="flex justify-between items-center mt-1.5 text-xs">
                        ' . $statusText . '
                        <span class="text-neutral-400 text-[10px]">' . round($percent) . '%</span>
                    </div>
                </div>';
                })
                ->html(),

            Column::make('Actions', 'id')
                ->format(
                    fn($value, $row) => view('components.actions.invoice-actions', ['row' => $row])
                )->html(),
        ];
    }

    // public function bulkActions(): array
    // {
    //     return [
    //         'deleteSelected' => 'Delete Selected',
    //     ];
    // }

    public function deleteSelected(): void
    {
        $ids = $this->getSelected();

        if (empty($ids)) {
            return;
        }

        DB::transaction(function () use ($ids) {
            // Invoice::whereIn('id', $ids)->delete();
            Invoice::where('user_id', auth()->id())->whereIn('id', $ids)->delete();
        });

        // Clear selection after delete
        $this->clearSelected();
    }

    public function filters(): array
    {
        // Existing filters logic... (keeping it concise in replacement if untouched, but need full context)
        return [
            SelectFilter::make('Status', 'invoice_status')
                ->options([
                    '' => 'All',
                    'draft' => 'Draft',
                    'sent' => 'Sent',
                    'partially_paid' => 'Partially Paid',
                    'paid' => 'Paid',
                    'overdue' => 'Overdue',
                    'void' => 'Void',
                    'canceled' => 'Canceled',
                ])
                ->filter(function ($query, $value) {
                    if ($value === '') {
                        return;
                    }
                    // special logic for overdue (enterprise behavior)
                    if ($value === 'overdue') {
                        $query
                            ->whereNotIn('invoice_status', ['paid', 'void', 'canceled'])
                            ->whereDate('due_date', '<', now());

                        return;
                    }

                    $query->where('invoice_status', $value);
                }),
        ];
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
