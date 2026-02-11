<?php

namespace App\Livewire\Invoices;

use App\Models\Invoice;
use Illuminate\Contracts\Database\Eloquent\Builder;
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
        // $this->setSearchIcon('heroicon-m-magnifying-glass');

        $this->setSearchPlaceholder('Search Invoices...');
        $this->setSearchFieldAttributes([
            'class' => 'transition-none',
            'default' => true,
        ]);
    }

    public function query(): Builder
    {
        return Invoice::query()
            ->with(['client' => fn ($query) => $query->withTrashed(), 'project']);
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->hideIf(true),

            // FIX 1: Add Hidden Columns to ensure data is available in $row
            Column::make('Client ID', 'client_id')->hideIf(true),
            Column::make('Issue Date', 'issue_date')->hideIf(true),

            Column::make('Currency', 'currency')->hideIf(true),

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
                    // FIX 2: safely access client name, falling back to 'N/A' if null
                    // Ensure your database column is actually 'client_name' and not just 'name'
                    $clientName = $row->client ? e($row->client->client_name) : 'No Client';

                    // Handle unassigned projects
                    $projectName = $value ? e($value) : 'General / Unassigned';

                    return '<div class="flex flex-col">
                                <span class="font-medium text-neutral-900 dark:text-white truncate" title="'.$projectName.'">'.$projectName.'</span>
                                <div class="text-xs font-thin">
                                    <span class="flex items-center gap-1 text-xs text-neutral-500 mt-0.5 truncate">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                            </svg>
                                        '.$clientName.'
                                    </span>
                                </div>
                            </div>';
                })
                ->html(),

            Column::make('Status', 'invoice_status')
                ->sortable()
                ->format(
                    fn ($value, $row) => view('components.badges.invoice-status', [
                        'invoice_status' => $value,
                    ])
                ),
            Column::make('Paid Total', 'paid_total')->hideIf(true),
            Column::make('Balance Due', 'balance_due')->hideIf(true),
            Column::make('Due Date', 'due_date')
                ->sortable()
                ->format(function ($value, $row) {
                    if (! $value) {
                        return '—';
                    }

                    $dueDate = \Carbon\Carbon::parse($value)->format('M d, Y');

                    // FIX 3: Now that 'issue_date' is defined as a hidden column above,
                    // $row->issue_date will now contain data.
                    $issueDate = $row->issue_date ? \Carbon\Carbon::parse($row->issue_date)->format('M d, Y') : '—';

                    $isOverdue = $value < now() && ! in_array($row->invoice_status, ['paid', 'void', 'canceled']);
                    $colorClass = $isOverdue ? 'text-red-600 font-bold' : 'text-neutral-700 dark:text-neutral-300 font-semibold';

                    return '<div class="flex flex-col">
                                <span class="'.$colorClass.'">'.$dueDate.'</span>
                                <span class="text-xs text-neutral-400">Issued: '.$issueDate.'</span>
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
                    $currency = e($row->currency);

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
                        : '<span class="text-red-600 dark:text-red-400 font-medium">Due: <span class="font-mono text-[10px] opacity-80">'.$currency.' '.'</span>'.$formattedDue.'</span>';

                    return '
                <div class="flex flex-col min-w-[120px]">
                    <div class="flex items-baseline gap-1">
                        <span class="text-[10px] font-medium text-zinc-400 uppercase">'.$currency.'</span>
                        <span class="font-mono font-bold text-zinc-900 dark:text-zinc-100 text-sm tabular-nums">
                            '.$formattedTotal.'
                        </span>
                    </div>

                    <div class="w-full h-1.5 bg-zinc-100 dark:bg-zinc-700 rounded-full mt-1.5 overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full transition-all duration-500" 
                             style="width: '.$percent.'%"></div>
                    </div>

                    <div class="flex justify-between items-center mt-1.5 text-xs">
                        '.$statusText.'
                        <span class="text-zinc-400 text-[10px]">'.round($percent).'%</span>
                    </div>
                </div>';
                })
                ->html(),

            Column::make('Actions', 'id')
                ->format(
                    fn ($value, $row) => view('components.actions.invoice-actions', ['row' => $row])
                )->html(),
        ];
    }

    public function downloadPdf($id)
    {
        $invoice = Invoice::with(['client', 'project', 'items', 'user'])->findOrFail($id);
        $settings = \App\Models\InvoiceSetting::where('user_id', auth()->id())->first(); // Use auth helper directly or import facade

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice,
            'settings' => $settings,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'invoice-'.$invoice->invoice_number.'.pdf');
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
            Invoice::whereIn('id', $ids)->delete();
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
}
