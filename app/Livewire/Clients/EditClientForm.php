<?php

namespace App\Livewire\Clients;


use App\Models\Client;
use Livewire\Attributes\On;
use Livewire\Component;


class EditClientForm extends Component
{
    public bool $open = false;
    public array $editClient = [];

    #[On('edit-client')]
    public function openEdit(int $clientId): void
    {
        // dd($clientId);
        $client = Client::findOrFail($clientId);
        $this->editClient = $client->toArray();
        $this->open = true;
    }

    public function closeEdit(): void
    {
        $this->reset(['open', 'editClient']);
    }

    public function saveClientEdit()
    {
        // $client = Client::find($this->editClient['id']);
        $client = Client::findOrFail($this->editClient['id']);

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
        $this->dispatch('refreshDatatable');
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


        // $this->dispatch('client-updated');
        $this->closeEdit();

        return back()->with('success', 'Client edited successfully!');
    }


    public function render()
    {
        return view('livewire.clients.edit-client-form');
    }
}
