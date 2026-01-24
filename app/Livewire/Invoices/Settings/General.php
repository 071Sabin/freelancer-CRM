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
    public string $default_currency;
    public string $invoice_language = 'en';
    public string $date_format = 'Y-m-d';
    public string $timezone = 'UTC';

    protected function rules(): array
    {
        return [
            'prefix' => 'required|string|max:10',
            'next_number' => 'required|integer|min:1',
            'default_currency' => 'required|string|size:3',
            'invoice_language' => 'required|string',
            'date_format' => 'required|string',
            'timezone' => 'required|string',
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
            'default_currency',
        ]));
    }

    public function save()
    {
        $this->settings->update(
            $this->validate()
        );
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
