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
    public int $default_due_days;
    public bool $allow_partial_payments = false;
    public string $default_late_fee_type = 'percentage';
    public ?float $default_late_fee_rate = null;
    public ?float $default_late_fee_amount = null;

    protected function rules(): array
    {
        return [
            'default_tax_rate' => 'nullable|numeric|min:0|max:100',
            'default_discount_rate' => 'nullable|numeric|min:0|max:100',
            'default_due_days' => 'required|integer|min:0',
            'allow_partial_payments' => 'boolean',

            'default_late_fee_type' => 'nullable|in:percentage,fixed',
            'default_late_fee_rate' => 'nullable|numeric|min:0',
            'default_late_fee_amount' => 'nullable|numeric|min:0',
        ];
    }

    public function mount()
    {
        $this->settings = InvoiceSetting::where('user_id', Auth::id())->firstOrFail();
        $this->default_late_fee_type   = $this->settings->default_late_fee_type ?? $this->default_late_fee_type;
        $this->default_late_fee_rate   = $this->settings->default_late_fee_rate ?? $this->default_late_fee_rate;
        $this->default_late_fee_amount = $this->settings->default_late_fee_amount ?? $this->default_late_fee_amount;
        $this->default_discount_rate = $this->settings->default_discount_rate ?? $this->default_discount_rate;
        $this->default_due_days = $this->settings->default_due_days ?? $this->default_due_days;
        $this->default_tax_rate = $this->settings->default_tax_rate ?? 0.00;
        
        // $this->fill($this->settings->only(['default_tax_rate']));
    }

    public function save()
    {
        $payload = $this->validate();

        // Ensure checkbox/toggle always has a value
        $payload['allow_partial_payments'] = (bool) ($payload['allow_partial_payments'] ?? false);

        $this->settings->update($payload);

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
