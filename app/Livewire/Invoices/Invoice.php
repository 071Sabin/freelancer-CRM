<?php

namespace App\Livewire\Invoices;

use App\Models\Invoice as ModelsInvoice;
use App\Models\InvoiceSetting;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('ClientPivot | Invoices')]
class Invoice extends Component
{
    public $client_id="", $invoices;
    public $project_id="";
    public $issue_date;
    public $due_date;

    protected $rules = [
        'client_id'  => 'required|exists:clients,id',
        'project_id' => 'required|exists:projects,id',
        'issue_date' => 'required|date',
        'due_date'   => 'required|date|after_or_equal:issue_date',
    ];

    public function create()
    {
        $this->validate();

        $user = Auth::user();

        // Load invoice settings (or create defaults)
        $settings = InvoiceSetting::firstOrCreate(
            ['user_id' => $user->id],
            [
                'prefix' => 'INV',
                'next_number' => 1,
                'default_currency' => 'USD',
            ]
        );

        // Generate invoice number
        $invoiceNumber = sprintf(
            '%s-%05d',
            $settings->prefix,
            $settings->next_number
        );

        // Create draft invoice
        $invoice = ModelsInvoice::create([
            'user_id'        => $user->id,
            'client_id'      => $this->client_id,
            'project_id'     => $this->project_id,
            'invoice_number' => $invoiceNumber,
            'status'         => 'draft',
            'issue_date'     => $this->issue_date,
            'due_date'       => $this->due_date,
            'currency'       => $settings->default_currency,
            'subtotal'       => 0,
            'tax_total'      => 0,
            'discount_total' => 0,
            'total'          => 0,
        ]);

        // Increment next invoice number
        $settings->increment('next_number');

        // Redirect to edit screen
        return redirect()->route('invoices');
    }

    public function render()
    {
        $this->invoices=Invoice::all();
        return view('livewire.invoices.invoice');
    }
}
