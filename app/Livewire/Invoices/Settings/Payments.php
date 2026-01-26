<?php

namespace App\Livewire\Invoices\Settings;

use App\Models\InvoiceSetting;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;


#[Title('ClientPivot | Invoice Settings')]
#[Layout('layouts.invoices-settings')]
class Payments extends Component
{

    public InvoiceSetting $settings;

    public ?float $default_tax_rate;
    public ?float $default_discount_rate = null;
    public int $payment_terms_days = 14;
    public bool $allow_partial_payments = false;

    protected function rules(): array
    {
        return [
            'default_tax_rate' => 'nullable|numeric|min:0|max:100',
            'default_discount_rate' => 'nullable|numeric|min:0|max:100',
            'payment_terms_days' => 'required|integer|min:0',
            'allow_partial_payments' => 'boolean',
        ];
    }

    public function mount()
    {
        $this->settings = InvoiceSetting::where('user_id', Auth::id())->firstOrFail();

        $this->fill($this->settings->only(['default_tax_rate']));
    }

    public function save()
    {
        $this->settings->update($this->validate());
        session()->flash(
            'success',
            'Payment invoice settings saved successfully.'
        );
    }

    public function render()
    {
        return view('livewire.invoices.settings.payments');
    }
}
