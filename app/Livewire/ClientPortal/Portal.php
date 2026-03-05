<?php

namespace App\Livewire\ClientPortal;

use App\Models\Project;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('ClientPivot | Secure Project Status')]
class Portal extends Component
{
    public $project;


    public function downloadInvoice($invoiceId)
    {
        // 1. SECURITY: Ensure the invoice belongs to the current project.
        // Also eager-load related models ('items' and 'user') required for the PDF view.
        $invoice = $this->project->invoices()
            ->with(['client', 'project', 'items', 'user'])
            ->where('id', $invoiceId)
            ->firstOrFail();

        // 2. GUEST PORTAL FIX:
        // Auth::id() is not available in the guest portal context.
        // Therefore, retrieve the invoice settings using the project owner's user ID.
        $settings = \App\Models\InvoiceSetting::where('user_id', $this->project->user_id)->first();

        // 3. Generate the PDF using the invoice view template.
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice,
            'settings' => $settings,
        ]);

        // 4. Stream the generated PDF as a downloadable file.
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'invoice-' . $invoice->invoice_number . '.pdf');
    }

    public function mount($uuid)
    {
        // Retrieve the project using its UUID and eager-load related client and invoices.
        $this->project = Project::with(['client', 'invoices'])
            ->where('uuid', $uuid)
            ->firstOrFail();
    }

    
    public function render()
    {
        
        return view('livewire.client-portal.portal');
    }
}
