<?php

namespace App\Livewire\Projects;

use App\Models\Invoice;
use Livewire\Attributes\On;
use Livewire\Component;

class WorkspaceInvoices extends Component
{
    public $invoices;
    public $project;

    public function mount()
    {
        $this->invoices = Invoice::where('project_id', $this->project->id)->get();
    }

    // triggers from: invoiceFormModal after creating invoice and before the add items modal opens.
    #[On('invoice-saved')]
    public function refreshInvoiceList()
    {
        $this->invoices = Invoice::where('project_id', $this->project->id)->get();
    }
    public function render()
    {
        // return view('livewire.projects.workspace-invoices');
        return view('livewire.projects.workspace-invoices', [
            'invoices' => Invoice::where('project_id', $this->project->id)->get()
        ]);
    }
}
