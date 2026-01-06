<?php

namespace App\Livewire;

use App\Models\Client;

use Livewire\Component;
use Livewire\Attributes\Title;


#[Title('Client Pivot | Clients')]

class Clients extends Component
{
    public $clientname, $companyname, $companyemail, $website, $companyphone;
    public $billing_address, $hrate, $currency, $status, $privatenote;
    public $sortName = 'asc';
    public $editClient = [];
    public $showEditModal = false;
    public $showAddClientForm = false;

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

        session()->flash('success', 'Client added successfully!');
    }


    public function getClientDetailsProperty()
    {
        return Client::orderBy('client_name', $this->sortName)->get();
    }

    public function sortByName()
    {
        $this->sortName = $this->sortName === 'asc' ? 'desc' : 'asc';
    }

    public function openEdit($id)
    {
        $client = Client::find($id);
        $this->editClient = $client->toArray();
        $this->showEditModal = true;
    }

    public function closeEdit()
    {
        $this->showEditModal = false;
    }

    public function toggleAddClient()
    {
        if ($this->showAddClientForm) {
            $this->showAddClientForm = false;
            return;
        }
        $this->showAddClientForm = true;
    }

    public function saveClientEdit()
    {
        // dd($this->editClient['id']);
        $client = Client::find($this->editClient['id']);

        $this->validate([
            'editClient.client_name' => 'required|string|max:255',
            'editClient.company_name' => 'required|string|max:255',
            'editClient.company_email' => 'nullable|email|max:255',
            'editClient.company_website' => 'nullable|string|max:255',
            'editClient.company_phone' => 'required|string|max:50',
            'editClient.billing_address' => 'required|string',
            'editClient.hourly_rate' => 'required|numeric',
            'editClient.currency' => 'required|string|max:10',
            'editClient.status' => 'required|string|max:50',
            'editClient.private_notes' => 'nullable|string',
        ]);

        $client->client_name = strtolower($this->editClient['client_name']);
        $client->company_name = strtolower($this->editClient['company_name']);
        $client->company_email = $this->editClient['company_email']
            ? strtolower($this->editClient['company_email'])
            : null;
        $client->company_website = $this->editClient['company_website']
            ? strtolower($this->editClient['company_website'])
            : null;
        $client->company_phone = $this->editClient['company_phone'] ?? null;
        $client->billing_address = strtolower($this->editClient['billing_address']);
        $client->hourly_rate = (string) $this->editClient['hourly_rate']; // string column
        $client->currency = $this->editClient['currency'];
        $client->status = strtolower($this->editClient['status']);
        $client->private_notes = $this->editClient['private_notes']
            ? strtolower($this->editClient['private_notes'])
            : null;

        $client->save();

        // $client->update([
        //     'client_name' => strtolower($this->editClient['client_name']),
        //     'company_name' => strtolower($this->companyname),
        //     'company_email' => strtolower($this->companyemail),
        //     'company_website' => strtolower($this->companywebsite),
        //     'company_phone' => $this->companyphone,
        //     'billing_address' => strtolower($this->billingaddress),
        //     'hourly_rate' => $this->hourlyrate,
        //     'currency' => $this->currency,
        //     'status' => strtolower($this->status),
        //     'private_notes' => strtolower($this->privatenotes),
        // ]);

        return session()->flash('success', 'Client edited successfully!');
    }


    public function delete($id)
    {
        Client::find($id)->delete();
        session()->flash('success', 'Client deleted successfully!');
    }

    public function render()
    {
        return view('livewire.clients', [
            'clientDetails' => $this->clientDetails,
        ]);
    }
}