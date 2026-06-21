<?php

namespace App\Livewire\Invoices;

use App\Models\Client;
use App\Models\Currency;
use App\Models\Invoice;
use App\Models\InvoiceSetting;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

// handles view, edit, download, create invoices, 
// receives request from workspace.blade.php, invoice-actions.blade.php, invoice.blade.php -> creation of invoice

class InvoiceFormModal extends Component
{
    // Form Variables
    public $client_id = "";
    public $project_id = "";
    public $invoice_status = 'draft';
    public $currency;
    public $issue_date = '';
    public $due_date = '';
    public $due_date_note = '';
    public $clients = '';
    public $projects = '';
    public $clientSearch = '';  // Added for Flux search input
    public $projectSearch = ''; // Added for Flux search input
    public $currencies;
    public ?InvoiceSetting $settings = null;
    public ?Invoice $editingInvoice = null;
    public ?Invoice $viewingInvoice = null;

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
    public $late_fee_type;

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

    /**
     * Triggers:
     * 1. invoice-actions.blade.php, this file is in invoiceTable.php -> eye view -> download button
     * 2.  data table-> actions column -> "download" icon
     */
    #[On('download-invoice')]
    public function downloadPdf($id)
    {
        $invoice = Invoice::with(['client', 'project', 'items', 'user'])->findOrFail($id);
        $settings = InvoiceSetting::where('user_id', Auth::id())->first();

        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice,
            'settings' => $settings,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'invoice-' . $invoice->invoice_number . '.pdf');
    }

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


    /**
     * Triggers:
     * 1. project specific Workspace Dashboard -> "+ Create" button
     */
    #[On('open-create-invoice')]
    public function initDraft($projectId, $clientId)
    {
        // Auto-fill important fields so the user doesn't need to enter them manually
        $this->project_id = $projectId;
        $this->client_id = $clientId;
        $dueDays = InvoiceSetting::where('user_id', auth()->id())->value('default_due_days');
        // dd($dueDays);

        // Set today's date as the default invoice issue date
        $this->issue_date = now()->format('Y-m-d');

        // Set default due date from the invoice settings fro this authenticated user
        $this->due_date = now()->addDays($dueDays)->format('Y-m-d');

        // Open the invoice creation modal so the user can review or edit the dates
        $this->modal('create-invoice-modal')->show();
    }

    // this creates draft invoice and saves as draft. then opens the edit modal
    public function create()
    {
        if (auth()->user()->hasReachedInvoiceLimit()) {
            session()->flash('error', 'Limit Reached: You have reached the invoice creation limit for your current plan this month. Please upgrade to create more invoices.');
            $this->modal('create-invoice-modal')->close();
            return;
        }

        $this->validate();

        $user = Auth::user();

        try {
            DB::transaction(function () use ($user) {

                // 1. Load + lock settings
                $settings = InvoiceSetting::where('user_id', $user->id)->firstOrFail();

                $settings = InvoiceSetting::where('id', $settings->id)
                    ->lockForUpdate()
                    ->first();

                $client = Client::findOrFail($this->client_id);
                $billCurrencyId = null;

                if ($this->project_id) {
                    $project = Project::findOrFail($this->project_id);
                    $billCurrencyId = $project->currency_id; // Project's currency
                } else {
                    $billCurrencyId = $client->currency_id; // Client's default currency
                }

                if (!$billCurrencyId) {
                    session()->flash('error', 'Currency is missing for this client/project');
                    return;
                }

                // 2. Generate invoice number
                $invoiceNumber = sprintf(
                    '%s-%05d',
                    $settings->prefix,
                    $settings->next_number
                );
                
                // this is freelancer company details as snapshot
                $companySnapshot = [
                    'company_name' => $settings->company_name,
                    'company_email' => $settings->company_email,
                    'company_phone' => $settings->company_phone,
                    'company_website' => $settings->company_website,
                    'tax_id' => $settings->tax_id,
                    'payment_methods' => $settings->payment_methods,
                    'bank_details' => $settings->bank_details,
                    'company_address' => $settings->company_address,
                ];


                // 3. Create invoice
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
                    'bill_currency_id' => $billCurrencyId,
                    'subtotal'       => 0,
                    'tax_total'      => 0,
                    'discount_total' => 0,
                    'shipping_total' => 0,
                    'adjustment_total' => 0,
                    'total'          => 0,
                    'paid_total'     => 0,
                    'balance_due'    => 0,
                    'is_tax_inclusive' => (bool) $settings->default_tax_inclusive,
                    'notes'          => $settings->default_notes,
                    'terms'          => $settings->default_terms,
                    'payment_terms'  => $settings->default_payment_terms,
                    'due_days'       => $settings->default_due_days,
                    'billing_address' => $client->billing_address,
                    'company_snapshot' => $companySnapshot,
                    'client_snapshot' => [
                        'client_name' => $client->client_name,
                        'client_email' => $client->client_email,
                        'company_name' => $client->company_name,
                        'company_email'   => $client->company_email,
                        'company_phone'   => $client->company_phone,
                        'company_website' => $client->company_website,
                    ],
                    // for keeping it filled, edit it whenever required
                    'base_currency' => $settings->default_currency_id ?? null,
                    'metadata'       => [
                        'tax_rate' => $settings->default_tax_rate ?? 0,
                    ],
                    'default_footer' => $settings->default_footer,
                ]);

                // 4. Increment number
                $settings->increment('next_number');

                // 5. UI actions
                $this->edit($invoice->id);
                $this->dispatch('invoice-saved');
                $this->dispatch('refreshDatatable');
                $this->modal('create-invoice-modal')->close();
            });
        } catch (\Throwable $e) {

            // Uncomment this while debugging (real error)
            // dd($e->getMessage(), $e->getTrace());

            // Or better:
            // logger($e);

            session()->flash('error', 'Something went wrong while creating invoice.');
            return;
        }
    }

    // after creation of draft invoice, what things to be edited is done here
    public function edit($id)
    {
        $this->editingInvoice = Invoice::with(['client', 'project', 'items', 'currency'])->findOrFail($id);
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
        $this->tax_rate = $metadata['tax_rate'] ?? $settings->default_tax_rate ?? 0;

        // Discount
        $this->discount_value = $metadata['discount_value'] ?? ($settings->default_discount_rate ?? 0);
        $this->discount_type = $metadata['discount_type'] ?? 'percentage';

        // Late Fee
        $this->late_fee_value = $metadata['late_fee_value'] ?? ($settings->default_late_fee_rate ?? 0);
        $lateFeeTypeFromSettings = $settings->default_late_fee_type instanceof \App\Enums\LateFeeType ? $settings->default_late_fee_type->value : $settings->default_late_fee_type;
        $this->late_fee_type = $metadata['late_fee_type'] ?? ($lateFeeTypeFromSettings ?? 'percent');

        // Dates
        $this->issue_date = $this->editingInvoice->issue_date ? \Carbon\Carbon::parse($this->editingInvoice->issue_date)->format('Y-m-d') : now()->format('Y-m-d');

        $this->invoice_status = $this->editingInvoice->invoice_status;
        $this->currency = $this->editingInvoice->currency->id;

        if ($this->editingInvoice->due_date) {
            $this->due_date = \Carbon\Carbon::parse($this->editingInvoice->due_date)->format('Y-m-d');
        } else {
            $defaultDays = $settings->default_due_days ?? 14;
            $this->due_date = \Carbon\Carbon::parse($this->issue_date)->addDays($defaultDays)->format('Y-m-d');
        }
        $this->due_date_note = '';

        $this->calculateTotals();
        $this->modal('edit-invoice-modal')->show();
    }

    public function view($id)
    {
        $this->viewingInvoice = Invoice::with(['client', 'project', 'items', 'currency'])->findOrFail($id);
        $this->authorize('view', $this->viewingInvoice); // Ensure user can view this invoice

        $this->modal('view-invoice-modal')->show();
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

            if ($this->late_fee_type === 'percent') {
                $lateFeeAmount = ($currentTotal * $this->late_fee_value) / 100;
            } else {
                $lateFeeAmount = $this->late_fee_value;
            }
        }
        $this->late_fee_total = $lateFeeAmount;

        // 6. Final Total
        $this->total = $taxableAmount + $this->tax_total + $this->late_fee_total;
    }

    public function update()
    {
        $this->calculateTotals(); // Ensure totals are fresh
        // dd($this->authorize('update', $this->editingInvoice));
        $this->validate([
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'invoice_status' => 'required|in:draft,sent,paid,partially_paid,overdue,void,canceled',
            'currency' => 'required|integer',
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
            $this->editingInvoice->bill_currency_id = $this->currency;
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
        $this->dispatch('invoice-saved');
        $this->dispatch('refreshDatatable');
        session()->flash('success', 'Invoice updated successfully.');
    }

    /**
     * Triggers:
     * 1. triggers from invoice.blade.php -> "create invoice" button
     * 2. not triggered from project specific workspace
     */
    #[On('reset-form')]
    public function resetForm()
    {
        $this->reset(['issue_date', 'due_date']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function updatedProjectId($value)
    {
        $project = Project::find($value);
        $this->currency = $project?->currency
            ? $project->currency->code . ' - ' . $project->currency->symbol
            : null;
    }


    public function mount()
    {
        $currentUser = Auth::id();
        $this->settings = InvoiceSetting::where('user_id', $currentUser)->first();
        $this->currencies = Currency::all()->sortBy('code');
        $this->late_fee_type = \App\Enums\LateFeeType::PERCENT->value;
    }


    #[Computed]
    public function searchedClients()
    {
        $query = Client::where('user_id', Auth::id())
            ->when($this->clientSearch, function ($query) {
                $query->where('client_name', 'like', '%' . $this->clientSearch . '%');
            });

        $clients = $query->limit(15)->get();

        // Prevent Flux from losing the selected label if the chosen client isn't in the top 15 search results
        if ($this->client_id && !$clients->contains('id', $this->client_id)) {
            $selected = Client::find($this->client_id);
            if ($selected) $clients->push($selected);
        }

        return $clients;
    }

    #[Computed]
    public function searchedProjects()
    {
        $projectSearch = trim($this->projectSearch);

        $query = Project::where('user_id', Auth::id())
            ->when($projectSearch, function ($query) use ($projectSearch) {
                $query->where('name', 'like', $this->toPrefixSearch($projectSearch) . '%');
            })
            ->orderBy('id');

        $projects = $query->limit(15)->get();

        if ($this->project_id && !$projects->contains('id', $this->project_id)) {
            $selected = Project::find($this->project_id);
            if ($selected) $projects->push($selected);
        }

        return $projects;
    }

    private function toPrefixSearch(string $search): string
    {
        return addcslashes($search, '\%_');
    }

    public function render()
    {
        return view('livewire.invoices.invoice-form-modal');
    }
}
