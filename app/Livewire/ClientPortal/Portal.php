<?php

namespace App\Livewire\ClientPortal;

use App\Models\InvoiceSetting;
use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('ClientPivot | Secure Project Status')]
class Portal extends Component
{
    public $project;
    public $progressPercentage = 0;
    public $clientTasks; // Tasks that clients will see whose visibility is set true
    public $hasPendingInternalTasks=false;


    public function downloadInvoice($invoiceId)
    {
        // 1. SECURITY: Ensure the invoice belongs to the current project.
        // Also eager-load related models ('items' and 'user') required for the PDF view.
        $invoice = $this->project->invoices()
            ->with(['client', 'project', 'items', 'user'])
            ->where('id', $invoiceId)
            ->firstOrFail();

        // Auth::id() is not available in the guest portal context.
        // Therefore, retrieve the invoice settings using the project owner's user ID.
        $settings = InvoiceSetting::where('user_id', $this->project->user_id)->first();

        // 3. Generate the PDF using the invoice view template.
        $pdf = Pdf::loadView('invoices.pdf', [
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
        $this->project = Project::with(['client', 'invoices', 'tasks'])
            ->where('uuid', $uuid)
            ->firstOrFail();

        // 1. Global Math
        $totalTasks = $this->project->tasks->count();
        $completedTasks = $this->project->tasks->where('is_completed', true)->count();
        $this->progressPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

        // 2. Client Tasks
        $this->clientTasks = $this->project->tasks
            ->where('is_visible_to_client', true)
            ->sortBy('position');

        // 3. checking if there is pending tasks? if so the UI will display loading animation that there is few pending tasks
        $this->hasPendingInternalTasks = $this->project->tasks
            ->where('is_visible_to_client', false)
            ->where('is_completed', false)
            ->count() > 0;
    }


    public function render()
    {

        return view('livewire.client-portal.portal');
    }
}
