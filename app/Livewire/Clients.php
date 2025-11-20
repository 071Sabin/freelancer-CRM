<?php

namespace App\Livewire;

use App\Models\Client;
use Livewire\Component;

class Clients extends Component
{
    public $clientname, $companyname, $companyemail, $website, $companyphone;
    public $billing_address, $hrate, $currency, $status, $privatenote;

    public $editClient = [];
    public $showEditModal = false;

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
        $client->private_notes = $this->privatenote;
        $client->save();

        session()->flash('success', 'Client added successfully!');
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

    public function saveClientEdit()
    {
        dd($this->editClient['id']);
    }
    public function delete($id)
    {
        Client::find($id)->delete();
        session()->flash('success', 'Client deleted successfully!');
    }

    public function render()
    {
        $clientDetails = Client::all();
        return view('livewire.clients', compact('clientDetails'));
    }
}