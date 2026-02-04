<?php

namespace App\Livewire\Invoices;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Invoice;
use App\Models\Project;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class InvoiceTable extends DataTableComponent
{
    protected $model = Invoice::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }


    public function query(): Builder
    {
        return Project::query()
            ->with('client'); // ✅ avoid N+1 queries
    }

    public function columns(): array
    {
        return [

            Column::make("Invoice #", "invoice_number")
                ->sortable()
                ->searchable(),

            Column::make("Client", "client.client_name")
                ->sortable()
                ->searchable(),

            Column::make("Project", "project.name")
                ->sortable()->format(function($value){return(e(ucwords($value)));}),

            Column::make("Status", "status")
                ->sortable()
                ->format(
                    fn($value, $row) =>
                    view('components.badges.invoice-status', [
                        'status' => $value
                    ])
                ),

            Column::make("Issue Date", "issue_date")
                ->sortable(),

            Column::make("Due Date", "due_date")
                ->sortable(),

            Column::make("Currency", "currency")
                ->sortable(),

            Column::make("Total", "total")
                ->sortable(),

            Column::make("Paid", "paid_total")
                ->sortable(),

            Column::make("Balance", "balance_due")
                ->sortable(),

            Column::make("Sent", "sent_at")
                ->sortable(),

            Column::make("Paid At", "paid_at")
                ->sortable(),

            Column::make("Created", "created_at")
                ->sortable()->format(fn($value) => $value?->diffForHumans()),
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
            invoice::whereIn('id', $ids)->delete();
        });

        // Clear selection after delete
        $this->clearSelected();
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Status', 'status')
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
                            ->whereNotIn('status', ['paid', 'void', 'canceled'])
                            ->whereDate('due_date', '<', now());
                        return;
                    }

                    $query->where('status', $value);
                }),
        ];
    }
}
