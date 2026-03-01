<?php

namespace App\Livewire\Invoices;

use App\Models\Invoice; // Model
use App\Models\InvoiceSetting;
use App\Models\Client;
use App\Models\Currency;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Transaction ke liye zaroori hai
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


#[Title('ClientPivot | Invoices')]
class InvoiceIndex extends Component // Renamed to avoid conflict with Model
{
    // Form Variables
    public $client_id = "";
    public $project_id = "";
    public $invoice_status = 'draft';
    public $currency = 'USD';
    public $issue_date = '';
    public $due_date = '';
    public $due_date_note = '';
    public $total_invoices = '';
    public $invoices = '';
    public $clients = '';
    public $projects = '';
    public $currencies;

    public ?Invoice $editingInvoice = null;
    public ?Invoice $viewingInvoice = null;

    protected $listeners = [
        'edit-invoice' => 'edit',
        'view-invoice' => 'view',
    ];


    protected $rules = [
        'client_id'  => 'required|exists:clients,id',
        'project_id' => 'required|exists:projects,id',
        'invoice_status' => 'required|in:draft,sent,paid,partially_paid,overdue,void,canceled',
        'issue_date' => 'required|date',
        'due_date'   => 'required|date|after_or_equal:issue_date',
    ];

    // updating issue date & due date to issue_date + 14 days = due_date
    public function updatedIssueDate($value)
    {
        if ($this->settings && $this->settings->default_due_days) {
            $days = $this->settings->default_due_days;
            try {
                $this->due_date = \Carbon\Carbon::parse($value)->addDays($days)->format('Y-m-d');
                $this->due_date_note = "Default due days of {$days} is added automatically.";
            } catch (\Exception $e) {
                // Invalid date
            }
        }
    }

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
                'approved_by'    => null,
                'uuid'           => (string) Str::uuid(),
                'invoice_number' => $invoiceNumber,
                'type'           => 'invoice',
                'invoice_status' => 'draft',
                'reference'      => null,
                'public_token'   => Str::random(64),
                'issue_date'     => $this->issue_date,
                'due_date'       => $this->due_date,
                'approved_at'    => null,
                'viewed_at'      => null,
                'canceled_at'    => null,
                'voided_at'      => null,
                'currency'       => $settings->default_currency,
                'base_currency'  => null,
                'exchange_rate'  => null,
                // Default values migration me set hain, par explicit rehna safe hai
                'subtotal'       => 0,
                'tax_total'      => 0,
                'discount_total' => 0,
                'shipping_total' => 0,
                'adjustment_total' => 0,
                'total'          => 0,
                'paid_total'     => 0,
                'balance_due'    => 0,
                'is_tax_inclusive' => (bool) $settings->default_tax_inclusive,
                // 'tax_rate' column removed, will use metadata or just calculation
                'notes'          => $settings->default_notes,
                'terms'          => $settings->default_terms,
                'payment_terms'  => $settings->default_payment_terms,
                'due_days'       => $settings->default_due_days,
                'sent_at'        => null,
                'paid_at'        => null,
                'client_snapshot' => null,
                'company_snapshot' => null,
                'billing_address' => null,
                'shipping_address' => null,
                'metadata'       => [
                    'tax_rate' => $settings->default_tax_rate ?? 0,
                ],
            ]);

            // 4. Increment Number
            $settings->increment('next_number');

            // 5. Open Edit Modal directly
            $this->edit($invoice->id);
            $this->dispatch('refreshDatatable');
            $this->modal('create-invoice-modal')->close();
            return back()->with('success', 'Draft Invoice created successfully!');
        });
    }

    public ?InvoiceSetting $settings = null;

    // Item Management
    public array $invoiceItems = [];
    public $subtotal = 0;
    public $tax_total = 0;
    public $discount_total = 0;
    public $late_fee_total = 0; // Calculated amount, not stored in DB column if not exists
    public $total = 0;

    // Advanced Invoice Settings (Per Invoice)
    public $tax_rate = 0;
    public $discount_value = 0;
    public $discount_type = 'percentage'; // percentage, fixed
    public $late_fee_value = 0;
    public $late_fee_type = 'percentage'; // percentage, fixed

    public function edit($id)
    {
        $this->editingInvoice = Invoice::with(['client', 'project', 'items'])->findOrFail($id);
        $this->authorize('view', $this->editingInvoice); // Ensure user can edit this invoice
        $this->invoiceItems = $this->editingInvoice->items->map(function ($item) {
            return [
                'id' => $item->id,
                'description' => $item->description,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'line_total' => $item->line_total,
            ];
        })->toArray();

        // Load settings from metadata or defaults
        $metadata = $this->editingInvoice->metadata ?? [];
        $settings = InvoiceSetting::where('user_id', Auth::id())->first();

        // Tax Rate (from metadata if exists, else settings)
        $this->tax_rate = $metadata['tax_rate'] ?? ($settings->default_tax_rate ?? 0);

        // Discount
        $this->discount_value = $metadata['discount_value'] ?? ($settings->default_discount_rate ?? 0);
        $this->discount_type = $metadata['discount_type'] ?? 'percentage';

        // Late Fee
        $this->late_fee_value = $metadata['late_fee_value'] ?? ($settings->default_late_fee_rate ?? 0);
        $this->late_fee_type = $metadata['late_fee_type'] ?? ($settings->default_late_fee_type ?? 'percentage');

        // Dates
        $this->issue_date = $this->editingInvoice->issue_date ? \Carbon\Carbon::parse($this->editingInvoice->issue_date)->format('Y-m-d') : now()->format('Y-m-d');

        $this->invoice_status = $this->editingInvoice->invoice_status;
        $this->currency = $this->editingInvoice->currency ?? ($settings->default_currency ?? 'USD');

        if ($this->editingInvoice->due_date) {
            $this->due_date = \Carbon\Carbon::parse($this->editingInvoice->due_date)->format('Y-m-d');
        } else {
            $defaultDays = $settings->default_due_days ?? 14;
            $this->due_date = \Carbon\Carbon::parse($this->issue_date)->addDays($defaultDays)->format('Y-m-d');
        }
        $this->due_date_note = '';

        $this->calculateTotals();
    }

    public function view($id)
    {
        $this->viewingInvoice = Invoice::with(['client', 'project', 'items'])->findOrFail($id);
        $this->authorize('view', $this->viewingInvoice); // Ensure user can view this invoice
        // dd($this->authorize('view', $this->viewingInvoice));
    }

    public function addItem()
    {
        $this->invoiceItems[] = [
            'id' => null,
            'description' => '',
            'quantity' => 1,
            'unit_price' => 0,
            'line_total' => 0,
        ];
    }

    public function removeItem($index)
    {
        unset($this->invoiceItems[$index]);
        $this->invoiceItems = array_values($this->invoiceItems);
        $this->calculateTotals();
    }

    public function updatedInvoiceItems($value, $key)
    {
        $this->calculateTotals();
    }

    // Updated update property hooks to recalculate totals
    public function updatedTaxRate()
    {
        $this->calculateTotals();
    }
    public function updatedDiscountValue()
    {
        $this->calculateTotals();
    }
    public function updatedDiscountType()
    {
        $this->calculateTotals();
    }
    public function updatedLateFeeValue()
    {
        $this->calculateTotals();
    }
    public function updatedLateFeeType()
    {
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->subtotal = 0;

        // 1. Calculate Subtotal
        foreach ($this->invoiceItems as $index => $item) {
            $qty = (float) ($item['quantity'] ?? 0);
            $price = (float) ($item['unit_price'] ?? 0);
            $lineTotal = $qty * $price;

            $this->invoiceItems[$index]['line_total'] = $lineTotal;
            $this->subtotal += $lineTotal;
        }

        // 2. Calculate Discount
        $discountAmount = 0;
        if ($this->discount_value > 0) {
            if ($this->discount_type === 'percentage') {
                $discountAmount = ($this->subtotal * $this->discount_value) / 100;
            } else {
                $discountAmount = $this->discount_value;
            }
        }
        $this->discount_total = $discountAmount;

        // 3. Taxable Amount (Subtotal - Discount)
        $taxableAmount = max(0, $this->subtotal - $this->discount_total);

        // 4. Calculate Tax
        $this->tax_total = ($taxableAmount * $this->tax_rate) / 100;

        $lateFeeAmount = 0;
        if ($this->late_fee_value > 0) {

            $currentTotal = $taxableAmount + $this->tax_total;

            if ($this->late_fee_type === 'percentage') {
                $lateFeeAmount = ($currentTotal * $this->late_fee_value) / 100;
            } else {
                $lateFeeAmount = $this->late_fee_value;
            }
        }
        $this->late_fee_total = $lateFeeAmount;

        // 6. Final Total
        $this->total = $taxableAmount + $this->tax_total + $this->late_fee_total;
    }

    public function downloadPdf($id)
    {
        $invoice = Invoice::with(['client', 'project', 'items', 'user'])->findOrFail($id);
        $settings = InvoiceSetting::where('user_id', Auth::id())->first();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice,
            'settings' => $settings,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'invoice-' . $invoice->invoice_number . '.pdf');
    }

    public function update()
    {
        $this->calculateTotals(); // Ensure totals are fresh
        // dd($this->authorize('update', $this->editingInvoice));
        $this->validate([
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'invoice_status' => 'required|in:draft,sent,paid,partially_paid,overdue,void,canceled',
            'currency' => 'required|string|size:3',
            'invoiceItems.*.description' => 'required|string',
            'invoiceItems.*.quantity' => 'required|numeric|min:0.01',
            'invoiceItems.*.unit_price' => 'required|numeric|min:0',
            'tax_rate' => 'numeric|min:0',
            'discount_value' => 'numeric|min:0',
            'late_fee_value' => 'numeric|min:0',
        ]);

        $this->authorize('update', $this->editingInvoice); // Ensure user can update this invoice

        DB::transaction(function () {
            // Prepare metadata
            $metadata = $this->editingInvoice->metadata ?? [];
            $metadata['tax_rate'] = $this->tax_rate;
            $metadata['discount_value'] = $this->discount_value;
            $metadata['discount_type'] = $this->discount_type;
            $metadata['late_fee_value'] = $this->late_fee_value;
            $metadata['late_fee_type'] = $this->late_fee_type;
            // Store calculated amounts in metadata too if column doesn't exist
            $metadata['late_fee_total'] = $this->late_fee_total;

            // Update Invoice Details
            $this->editingInvoice->issue_date = $this->issue_date;
            $this->editingInvoice->due_date = $this->due_date;
            $this->editingInvoice->invoice_status = $this->invoice_status;
            $this->editingInvoice->currency = $this->currency;
            $this->editingInvoice->subtotal = $this->subtotal;
            $this->editingInvoice->tax_total = $this->tax_total;
            $this->editingInvoice->discount_total = $this->discount_total; // This column usually exists
            $this->editingInvoice->total = $this->total;
            $this->editingInvoice->balance_due = $this->total - $this->editingInvoice->paid_total;
            $this->editingInvoice->metadata = $metadata;

            // $this->editingInvoice->tax_rate = $this->tax_rate; // Column removed reference 

            $this->editingInvoice->save();

            // Sync Items
            // 1. Get existing item IDs to keep
            $existingItemIds = collect($this->invoiceItems)
                ->pluck('id')
                ->filter()
                ->toArray();

            // 2. Delete removed items
            $this->editingInvoice->items()
                ->whereNotIn('id', $existingItemIds)
                ->delete();

            // 3. Update or Create items
            foreach ($this->invoiceItems as $index => $item) {
                $this->editingInvoice->items()->updateOrCreate(
                    ['id' => $item['id'] ?? null],
                    [
                        'position' => $index + 1,
                        'description' => $item['description'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'line_total' => $item['line_total'],
                        'name' => null, // or match description
                        'invoice_id' => $this->editingInvoice->id,
                    ]
                );
            }
        });

        $this->modal('edit-invoice-modal')->close();
        $this->dispatch('refreshDatatable');
        $this->dispatch('notify', 'Invoice updated successfully.');
    }

    public function resetForm()
    {
        $this->reset(['issue_date','due_date']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function mount()
    {
        $currentUser = Auth()->id();
        $this->total_invoices = Invoice::where('user_id', $currentUser)->count();
        $this->settings = InvoiceSetting::where('user_id', $currentUser)->first();
        $this->invoices = Invoice::where('user_id', $currentUser)
            ->with(['client', 'project'])
            ->latest()
            ->get();

            $this->currencies=Currency::all();

        $this->clients = Client::where('user_id', $currentUser)->get();
        $this->projects = Project::where('user_id', $currentUser)->get();
    }

    public function render()
    {
        return view('livewire.invoices.invoice');
    }
}
