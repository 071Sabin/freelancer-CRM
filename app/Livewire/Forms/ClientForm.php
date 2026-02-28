<?php

namespace App\Livewire\Forms;

use App\Models\Client;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Validate;
use Livewire\Form;

/* 
this form ficlass handles for both edit client + adding a new client. It has a single method for both store and update, and it uses the presence of 
the $client property to determine which action to take. This keeps your code DRY and makes it easier to maintain.
*/

class ClientForm extends Form
{
    use AuthorizesRequests;
    public ?Client $client = null;

    // Unified properties for BOTH Create and Edit
    public $client_name = '';
    public $client_email = '';
    public $company_name = '';
    public $company_email = '';
    public $company_website = '';
    public $company_phone = '';
    public $billing_address = '';
    public $hourly_rate = '';
    public $currency_id = '';
    public $status = 'active';
    public $private_notes = '';

    // Populates the form when a user clicks "Edit"
    public function setClient(Client $client)
    {
        $this->client = $client;
        $this->client_name = $client->client_name;
        $this->client_email = $client->client_email;
        $this->company_name = $client->company_name;
        $this->company_email = $client->company_email;
        $this->company_website = $client->company_website;
        $this->company_phone = $client->company_phone;
        $this->billing_address = $client->billing_address;
        $this->hourly_rate = $client->hourly_rate;
        $this->currency_id = $client->currency_id;
        $this->status = $client->status;
        $this->private_notes = $client->private_notes;
    }

    public function rules()
    {
        return [
            'client_name' => 'required|string|max:255',
            'client_email' => 'nullable|email|max:255',
            'company_name' => 'required|string|max:255',
            'company_email' => 'nullable|email|max:255',
            'company_website' => 'nullable|string|max:255',
            'company_phone' => 'required|string|max:50',
            'billing_address' => 'required|string',
            'hourly_rate' => 'required|numeric',
            'currency_id' => 'required|integer|exists:currencies,id',
            'status' => 'required|string|max:50',
            'private_notes' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'client_name.required' => 'Please provide a primary contact name for this client.',
            'company_name.required' => 'The company name is required to generate invoices.',
            'company_phone.required' => 'A contact phone number is necessary for billing records.',
            'billing_address.required' => 'Please enter the registered billing address.',
            'hourly_rate.required' => 'The default hourly rate must be defined.',
            'hourly_rate.numeric' => 'Please enter a valid numeric value for the hourly rate.',
            'currency_id.required' => 'Please select a default billing currency.',
            'currency_id.exists' => 'The selected currency is invalid or no longer supported.',
            'status.required' => 'A client status must be assigned.',
        ];
    }

    public function storeOrUpdate()
    {
        $this->validate();
        
        // to update existing client, first check if there is passed client to this ClientForm
        // if $client has some value then check if this freelancer can update the client
        if ($this->client) {
            $this->authorize('update', $this->client);
        }

        $data = [
            'client_name' => strtolower($this->client_name),
            'client_email' => strtolower($this->client_email),
            'company_name' => strtolower($this->company_name),
            'company_email' => strtolower($this->company_email),
            'company_website' => strtolower($this->company_website),
            'company_phone' => $this->company_phone,
            'billing_address' => $this->billing_address,
            'hourly_rate' => $this->hourly_rate,
            'currency_id' => $this->currency_id,
            'status' => $this->status,
            'private_notes' => strtolower($this->private_notes),
            'user_id' => auth()->id(), // Ensures it links to the logged-in freelancer
        ];

        if (empty($this->client)) {
            Client::create($data); // Adding new
        } else {
            $this->client->update($data); // Updating existing
        }

        $this->reset(); // Automatically clears the form
    }
}
