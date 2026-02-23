<?php

namespace App\Livewire\Clients;


use App\Models\Client;
use Livewire\Component;
use Livewire\Attributes\Title;


#[Title('Client Pivot | Clients')]
// #[On('openEditClient')]

class Clients extends Component
{
    public $clientname, $companyname, $companyemail, $website, $companyphone, $thisMonthClients;
    public $billing_address, $hrate, $currency, $clientemail, $status, $privatenote, $clientDetails, $clientCount;

    // public $editingClient;
    // public $viewingClient;

    public array $editingClient = [];
    public array $viewingClient = [];

    protected $listeners = [
        'edit-client' => 'edit',
        'view-client' => 'view',
    ];

    protected function resetAddClientForm()
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
            'currency',
            'status',
            'privatenote',
        ]);

        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function addClient()
    {
        $this->validate([
            'clientname' => 'required|string|max:255',
            'clientemail' => 'nullable|email|max:255',
            'companyname' => 'required|string|max:255',
            'companyemail' => 'nullable|email|max:255',
            'website' => 'nullable|string|max:255',
            'companyphone' => 'required|string|max:50',
            'billing_address' => 'required|string',
            'hrate' => 'required|numeric',
            'currency' => 'required|string|max:10',
            'status' => 'required|string|max:50',
            'privatenote' => 'nullable|string',
        ]);

        $client = new Client();
        $client->client_name = strtolower($this->clientname);
        $client->client_email = strtolower($this->clientemail);
        $client->company_name = strtolower($this->companyname);
        $client->company_email = strtolower($this->companyemail);
        $client->company_website = strtolower($this->website);
        $client->company_phone = $this->companyphone;
        $client->billing_address = $this->billing_address;
        $client->hourly_rate = $this->hrate;
        $client->currency = $this->currency;
        $client->status = $this->status;
        $client->private_notes = strtolower($this->privatenote);
        $client->save();

        $this->dispatch('refreshDatatable');

        $this->resetAddClientForm();

        session()->flash('success', 'Client added successfully!');
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);
        $this->editingClient = $client->toArray();
    }

    public function view($id)
    {
        $client = Client::findOrFail($id);
        $this->viewingClient = $client->toArray();
    }

    public function update()
    {
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
                'editingClient.currency' => 'required|string|max:10',
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
                'editingClient.currency.required' => 'Please select a default billing currency.',
                'editingClient.currency.max'      => 'The currency code is too long.',

                // Status
                'editingClient.status.required' => 'Please select a current status for this client account.',
                'editingClient.status.max'      => 'The status label is too long.',
            ]
        );

        $client = Client::findOrFail($this->editingClient['id']);

        $client->client_name = $this->editingClient['client_name'];
        $client->client_email = $this->editingClient['client_email'];
        $client->company_name = $this->editingClient['company_name'];
        $client->company_email = $this->editingClient['company_email'];
        $client->company_website = $this->editingClient['company_website'];
        $client->company_phone = $this->editingClient['company_phone'];
        $client->billing_address = $this->editingClient['billing_address'];
        $client->hourly_rate = $this->editingClient['hourly_rate'];
        $client->currency = $this->editingClient['currency'];
        $client->status = $this->editingClient['status'];
        $client->private_notes = $this->editingClient['private_notes'];

        $client->save();

        $this->dispatch('close-modal', 'edit-client-modal');
        $this->dispatch('refreshDatatable');
        session()->flash('success', 'Client updated successfully!');
    }

    public function render()
    {
        $this->clientCount = Client::count();
        $this->clientDetails = Client::all();
        // this displays the count of clients this month of this year.
        $this->thisMonthClients = Client::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        return view('livewire.clients.clients');
    }
}
