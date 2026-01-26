<?php

namespace App\Livewire\Invoices;

use App\Models\Invoice; // Model
use App\Models\InvoiceSetting;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Transaction ke liye zaroori hai
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('ClientPivot | Invoices')]
class InvoiceIndex extends Component // Renamed to avoid conflict with Model
{
    // Form Variables
    public $client_id = "";
    public $project_id = "";
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

        // Database Transaction Shuru (Sab kuch hoga ya kuch nahi hoga)
        return DB::transaction(function () use ($user) {

            // 1. Settings Load Karo aur LOCK karo (Race Condition Fix)
            // 'lockForUpdate' ensure karega ki jab tak ye invoice na bane,
            // koi aur process next_number read nahi kar sakta.
            $settings = InvoiceSetting::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'prefix' => 'INV',
                    'next_number' => 1,
                    'default_currency' => 'USD',
                ]
            );

            // Lock the settings row explicitly to handle concurrency safely
            $settings = InvoiceSetting::where('id', $settings->id)->lockForUpdate()->first();

            // 2. Invoice Number Generate
            $invoiceNumber = sprintf(
                '%s-%05d',
                $settings->prefix,
                $settings->next_number
            );

            // 3. Draft Invoice Create
            $invoice = Invoice::create([
                'user_id'        => $user->id,
                'client_id'      => $this->client_id,
                'project_id'     => $this->project_id,
                'invoice_number' => $invoiceNumber,
                'status'         => 'draft',
                'issue_date'     => $this->issue_date,
                'due_date'       => $this->due_date,
                'currency'       => $settings->default_currency,
                // Default values migration me set hain, par explicit rehna safe hai
                'subtotal'       => 0,
                'tax_total'      => 0,
                'discount_total' => 0,
                'total'          => 0,
            ]);

            // 4. Increment Number
            $settings->increment('next_number');

            // 5. Redirect to Edit Screen (Items add karne ke liye)
            // Hum 'invoices' route pe nahi, 'invoices.edit' pe bhejenge
            return redirect()->route('invoices.edit', ['invoice' => $invoice->id]);
        });
    }

    public function render()
    {
        // Sirf Auth User ka data load karo (Security Fix)
        // N+1 Problem fix karne ke liye 'with' use kiya
        $invoices = Invoice::where('user_id', Auth::id())
            ->with(['client', 'project'])
            ->latest()
            ->get();

        // Dropdowns ke liye data yaha se pass karo, Blade me query mat chalao
        $clients = Client::get();
        $projects = Project::get();

        return view('livewire.invoices.invoice', [
            'invoices' => $invoices,
            'clients' => $clients,
            'projects' => $projects
        ]);
    }
}
