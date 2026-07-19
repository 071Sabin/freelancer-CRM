<?php

namespace App\Livewire\Settings;

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Integration;
use Illuminate\Support\Facades\Auth;

#[Title('Client Pivot | WhatsApp Settings')]
class Whatsapp extends Component
{
    public $wa_access_token;
    public $wa_phone_number_id;
    public $wa_business_account_id;

    public function mount()
    {
        $integration = Auth::user()->integration;

        if ($integration) {
            $this->wa_access_token = $integration->wa_access_token;
            $this->wa_phone_number_id = $integration->wa_phone_number_id;
            $this->wa_business_account_id = $integration->wa_business_account_id;
        }
    }

    public function saveIntegrations()
    {
        $canUseWhatsApp = Auth::user()->canUseWhatsApp();

        $this->validate([
            'wa_access_token' => $canUseWhatsApp ? 'nullable|string' : 'nullable',
            'wa_phone_number_id' => $canUseWhatsApp ? 'nullable|string' : 'nullable',
            'wa_business_account_id' => $canUseWhatsApp ? 'nullable|string' : 'nullable',
        ]);

        Integration::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'wa_access_token' => $canUseWhatsApp ? $this->wa_access_token : null,
                'wa_phone_number_id' => $canUseWhatsApp ? $this->wa_phone_number_id : null,
                'wa_business_account_id' => $canUseWhatsApp ? $this->wa_business_account_id : null,
            ]
        );

        session()->flash('success', 'WhatsApp settings updated successfully.');
    }

    public function render()
    {
        return view('livewire.settings.whatsapp');
    }
}
