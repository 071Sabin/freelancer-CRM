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
    public $default_footer='';

    public function mount()
    {
        $this->settings = InvoiceSetting::where('user_id', Auth::id())->firstOrFail();
        $this->fill($this->settings->only(['logo_path', 'default_footer']));
    }

    public function save()
    {
        if ($this->logo && !auth()->user()->canUseCustomBranding()) {
            session()->flash('error', 'Upgrade Required: Custom branding (logo upload) is not available on your current plan. Please upgrade to Pro or Agency.');
            return;
        }

        // dd($this->default_footer);
        $data = [
            'default_footer' => $this->default_footer,
        ];
        if ($this->logo) {

            // delete old logo if exists
            if ($this->settings->logo_path) {
                Storage::delete($this->settings->logo_path);
            }

            // store new logo
            $path = $this->logo->store('invoice-logos');

            $data['logo_path'] = $path;
        }

        $this->settings->update($data);

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
