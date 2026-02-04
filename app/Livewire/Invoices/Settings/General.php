<?php

namespace App\Livewire\Invoices\Settings;

use App\Models\InvoiceSetting;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;


#[Title('ClientPivot | Invoice Settings')]
#[Layout('layouts.invoices-settings')]
class General extends Component
{

    public InvoiceSetting $settings;

    public string $prefix;
    public int $next_number;
    public string $number_format = '{PREFIX}{NUMBER}';
    public string $default_currency;
    public string $invoice_language = 'en';
    public string $date_format = 'Y-m-d';
    public string $timezone = 'UTC';
    public ?string $company_name = null;
    public ?string $company_email = null;
    public ?string $company_phone = null;
    public ?string $company_website = null;
    public ?string $tax_id = null;
    public array $company_address = [
        'line1' => '',
        'line2' => '',
        'city' => '',
        'state' => '',
        'postal_code' => '',
        'country' => '',
    ];

    protected function rules(): array
    {
        return [
            'prefix' => 'required|string|max:10',
            'next_number' => 'required|integer|min:1',
            'number_format' => 'required|string|max:30',
            'default_currency' => 'required|string|size:3',
            'invoice_language' => 'required|string',
            'date_format' => 'required|string',
            'timezone' => 'required|string',
            'company_name' => 'nullable|string|max:150',
            'company_email' => 'nullable|email|max:150',
            'company_phone' => 'nullable|string|max:50',
            'company_website' => 'nullable|string|max:150',
            'tax_id' => 'nullable|string|max:80',
            'company_address.line1' => 'nullable|string|max:150',
            'company_address.line2' => 'nullable|string|max:150',
            'company_address.city' => 'nullable|string|max:100',
            'company_address.state' => 'nullable|string|max:100',
            'company_address.postal_code' => 'nullable|string|max:30',
            'company_address.country' => 'nullable|string|max:100',
        ];
    }

    public function mount()
    {
        $this->settings = InvoiceSetting::firstOrCreate(
            ['user_id' => Auth::id()],
            ['prefix' => 'INV', 'next_number' => 1, 'default_currency' => 'USD']
        );

        $this->fill($this->settings->only([
            'prefix',
            'next_number',
            'number_format',
            'default_currency',
            'locale',
            'timezone',
            'company_name',
            'company_email',
            'company_phone',
            'company_website',
            'tax_id',
        ]));

        $this->invoice_language = $this->settings->locale ?? $this->invoice_language;
        $this->timezone = $this->settings->timezone ?? $this->timezone;
        $this->company_address = array_merge($this->company_address, $this->settings->company_address ?? []);
    }

    public function save()
    {
        $payload = $this->validate();
        $payload['locale'] = $payload['invoice_language'] ?? $this->invoice_language;
        unset($payload['invoice_language']);

        $this->settings->update($payload);
        session()->flash(
            'success',
            'General invoice settings saved successfully.'
        );
    }


    public function render()
    {
        return view('livewire.invoices.settings.general');
    }
}
