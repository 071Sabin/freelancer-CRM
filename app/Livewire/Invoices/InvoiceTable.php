<?php

namespace App\Livewire\Invoices;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Invoice;

class InvoiceTable extends DataTableComponent
{
    protected $model = Invoice::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("User id", "user_id")
                ->sortable(),
            Column::make("Client id", "client_id")
                ->sortable(),
            Column::make("Project id", "project_id")
                ->sortable(),
            Column::make("Invoice number", "invoice_number")
                ->sortable(),
            Column::make("Status", "status")
                ->sortable(),
            Column::make("Issue date", "issue_date")
                ->sortable(),
            Column::make("Due date", "due_date")
                ->sortable(),
            Column::make("Currency", "currency")
                ->sortable(),
            Column::make("Subtotal", "subtotal")
                ->sortable(),
            Column::make("Tax total", "tax_total")
                ->sortable(),
            Column::make("Discount total", "discount_total")
                ->sortable(),
            Column::make("Total", "total")
                ->sortable(),
            Column::make("Notes", "notes")
                ->sortable(),
            Column::make("Terms", "terms")
                ->sortable(),
            Column::make("Sent at", "sent_at")
                ->sortable(),
            Column::make("Paid at", "paid_at")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
