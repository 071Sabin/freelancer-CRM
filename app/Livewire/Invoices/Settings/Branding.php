<?php

namespace App\Livewire\Invoices\Settings;

use App\Models\InvoiceSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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

            // delete old logo if exists
            if ($this->settings->logo_path) {
                Storage::delete($this->settings->logo_path);
            }

            // store new logo
            $path = $this->logo->store('invoice-logos');

            // update db
            $this->settings->update([
                'logo_path' => $path,
            ]);
        }

        session()->flash(
            'success',
            'Branding invoice settings saved successfully.'
        );
    }


    public function render()
    {
        return view('livewire.invoices.settings.branding');
    }
}
