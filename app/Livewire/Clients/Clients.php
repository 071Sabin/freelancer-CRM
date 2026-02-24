<?php

namespace App\Livewire\Clients;


use App\Models\Client;
use App\Models\Currency;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\Attributes\Title;


#[Title('Client Pivot | Clients')]
// #[On('openEditClient')]

class Clients extends Component
{
    public $clientname, $companyname, $companyemail, $website, $companyphone, $thisMonthClients;
    public $billing_address, $hrate, $currency_id, $currencies, $clientemail, $status='active', $privatenote, $clientDetails, $clientCount;
    // public $editingClient;
    // public $viewingClient;

    public array $editingClient = [];
    public array $viewingClient = [];

    protected $listeners = [
        'edit-client' => 'edit',
        'view-client' => 'view',
    ];

    public function resetAddClientForm()
    {
        $this->reset([
            'clientname',
            'clientemail',
            'companyname',
            'companyemail',
            'website',
            'companyphone',
            'billing_address',
            'hrate',
            'currency_id',
            'status',
            'privatenote',
        ]);

        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function addClient()
    {
        try {
            $this->validate([
                'clientname' => 'required|string|max:255',
                'clientemail' => 'nullable|email|max:255',
                'companyname' => 'required|string|max:255',
                'companyemail' => 'nullable|email|max:255',
                'website' => 'nullable|string|max:255',
                'companyphone' => 'required|string|max:50',
                'billing_address' => 'required|string',
                'hrate' => 'required|numeric',
                'currency_id' => 'required|integer|exists:currencies,id',
                'status' => 'required|string|max:50',
                'privatenote' => 'nullable|string',
            ], [
                // Custom Professional Messages
                'clientname.required' => 'Please provide a primary contact name for this client.',
                'companyname.required' => 'The company name is required to generate invoices.',
                'companyphone.required' => 'A contact phone number is necessary for billing records.',
                'billing_address.required' => 'Please enter the registered billing address.',
                'hrate.required' => 'The default hourly rate must be defined.',
                'hrate.numeric' => 'Please enter a valid numeric value for the hourly rate.',
                'currency_id.required' => 'Please select a default billing currency.',
                'currency_id.exists' => 'The selected currency is invalid or no longer supported.',
                'clientemail.email' => 'Please provide a valid email address.',
                'status.required' => 'A client status must be assigned.',
            ]);
        } catch (ValidationException $e) {
            $this->dispatch('scroll-to-error');
            throw $e;
        }

        $client = new Client();
        $client->client_name = strtolower($this->clientname);
        $client->client_email = strtolower($this->clientemail);
        $client->company_name = strtolower($this->companyname);
        $client->company_email = strtolower($this->companyemail);
        $client->company_website = strtolower($this->website);
        $client->company_phone = $this->companyphone;
        $client->billing_address = $this->billing_address;
        $client->hourly_rate = $this->hrate;
        $client->currency_id = $this->currency_id;
        $client->status = $this->status;
        $client->private_notes = strtolower($this->privatenote);
        $client->save();

        $this->dispatch('refreshDatatable');

        $this->resetAddClientForm();

        session()->flash('success', 'Client added successfully!');
    }

    public function edit($id)
    {
        $client = Client::with('currency')->findOrFail($id);
        $this->editingClient = $client->toArray();
    }

    public function view($id)
    {
        $client = Client::with('currency')->findOrFail($id);
        $this->viewingClient = $client->toArray();
    }

    public function update()
    {
        try {
            $this->validate(
                [
                    'editingClient.client_name' => 'required|string|max:255',
                    'editingClient.client_email' => 'required|email|max:255',
                    'editingClient.company_name' => 'required|string|max:255',
                    'editingClient.company_email' => 'nullable|email|max:255',
                    'editingClient.company_website' => 'nullable|string|max:255',
                    'editingClient.company_phone' => 'required|string|max:50',
                    'editingClient.billing_address' => 'required|string',
                    'editingClient.hourly_rate' => 'required|numeric',
                    'editingClient.currency_id' => 'required|exists:currencies,id',
                    'editingClient.status' => 'required|string|max:50',
                    'editingClient.private_notes' => 'nullable|string',
                ],
                [
                    // Client Name
                    'editingClient.client_name.required' => 'Please provide the client\'s primary contact name.',
                    'editingClient.client_name.max'      => 'The client\'s name cannot exceed 255 characters.',

                    // Client Email
                    'editingClient.client_email'   => 'Please provide a valid email address for the client.',
                    'editingClient.client_email.max'     => 'The client\'s email address cannot exceed 255 characters.',

                    // Company Name
                    'editingClient.company_name.required' => 'Please enter the company or organization name.',
                    'editingClient.company_name.max'      => 'The company name cannot exceed 255 characters.',

                    // Company Email
                    'editingClient.company_email.email'   => 'Please provide a valid company email address.',
                    'editingClient.company_email.max'     => 'The company email address cannot exceed 255 characters.',

                    // Company Website
                    'editingClient.company_website.max'   => 'The website URL cannot exceed 255 characters.',

                    // Company Phone
                    'editingClient.company_phone.required' => 'A contact phone number is required.',
                    'editingClient.company_phone.max'      => 'The phone number cannot exceed 50 characters.',

                    // Billing Address
                    'editingClient.billing_address.required' => 'Please provide a billing address for invoicing purposes.',

                    // Hourly Rate
                    'editingClient.hourly_rate.required' => 'Please set a default hourly billing rate for this client.',
                    'editingClient.hourly_rate.numeric'  => 'The hourly rate must be a valid number.',

                    // Currency
                    'editingClient.currency_id.required' => 'Please select a default billing currency.',

                    // Status
                    'editingClient.status.required' => 'Please select a current status for this client account.',
                    'editingClient.status.max'      => 'The status label is too long.',
                ]
            );
        } catch (ValidationException $e) {
            // Handle validation errors (e.g., log them, display a message, etc.)
            // For this example, we'll just rethrow the exception to be handled by Livewire's default error handling.
            $this->dispatch('scroll-to-error');
            throw $e;
        }

        $client = Client::findOrFail($this->editingClient['id']);

        $client->client_name = $this->editingClient['client_name'];
        $client->client_email = $this->editingClient['client_email'];
        $client->company_name = $this->editingClient['company_name'];
        $client->company_email = $this->editingClient['company_email'];
        $client->company_website = $this->editingClient['company_website'];
        $client->company_phone = $this->editingClient['company_phone'];
        $client->billing_address = $this->editingClient['billing_address'];
        $client->hourly_rate = $this->editingClient['hourly_rate'];
        $client->currency_id = $this->editingClient['currency_id'];
        $client->status = $this->editingClient['status'];
        $client->private_notes = $this->editingClient['private_notes'];

        $client->save();

        $this->dispatch('close-modal', 'edit-client-modal');
        $this->dispatch('refreshDatatable');
        session()->flash('success', 'Client updated successfully!');
    }

    public function mount()
    {
        // $client = Client::with('currency')->findOrFail(1);
        // dd($client->currency->code);
        // These queries now run only once per page load
        $this->clientCount = Client::count();
        $this->clientDetails = Client::with('currency')->get();
        $this->currencies = Currency::orderBy('code', 'asc')->get();
        $this->thisMonthClients = Client::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    }

    public function render()
    {
        return view('livewire.clients.clients');
    }
}
