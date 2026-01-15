<?php

namespace App\Livewire\Clients;


use App\Models\Client;
use Livewire\Component;
use Livewire\Attributes\Title;


#[Title('Client Pivot | Clients')]
// #[On('openEditClient')]

class Clients extends Component
{
    public $clientname, $companyname, $companyemail, $website, $companyphone;
    public $billing_address, $hrate, $currency, $status, $privatenote, $clientDetails, $clientCount;
    
    public $editClient = [];
    public $showEditModal = false;
    public $showAddClientForm = false;

    protected function resetAddClientForm()
    {
        $this->reset([
            'clientname',
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

    public function toggleAddClient()
    {
        if ($this->showAddClientForm) {
            $this->showAddClientForm = false;
            return;
        }
        $this->showAddClientForm = true;
    }

    public function addClient()
    {
        $this->validate([
            'clientname' => 'required|string|max:255',
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
        $this->showAddClientForm = false;

        session()->flash('success', 'Client added successfully!');
    }

    public function render()
    {
        $this->clientCount = Client::count();
        $this->clientDetails = Client::all();
        return view('livewire.clients.clients');
    }
}