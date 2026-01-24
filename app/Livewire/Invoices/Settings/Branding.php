<?php

namespace App\Livewire\Invoices\Settings;

use App\Models\InvoiceSetting;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;


#[Title('ClientPivot | Invoice Settings')]
#[Layout('layouts.invoices-settings')]

class Branding extends Component
{

    use WithFileUploads;

    public InvoiceSetting $settings;
    public $logo;

    public function mount()
    {
        $this->settings = InvoiceSetting::where('user_id', Auth::id())->firstOrFail();
    }

    public function save()
    {
        if ($this->logo) {
            $this->settings->update([
                'logo_path' => $this->logo->store('invoice-logos', 'public'),
            ]);
        }
    }


    public function render()
    {
        return view('livewire.invoices.settings.branding');
    }
}
