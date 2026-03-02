<?php

namespace App\Livewire\Integrations;

use Livewire\Component;
use App\Models\Integration;
use Illuminate\Support\Facades\Auth;

class Integrations extends Component
{

    public $ai_provider = 'openai';
    public $ai_api_key;
    public $wa_access_token;
    public $wa_phone_number_id;
    public $wa_business_account_id;

    public function mount()
    {
        // if user's integration is already set, then load that here
        $integration = Auth::user()->integration;

        if ($integration) {
            $this->ai_provider = $integration->ai_provider ?? 'openai';
            $this->ai_api_key = $integration->ai_api_key;
            $this->wa_access_token = $integration->wa_access_token;
            $this->wa_phone_number_id = $integration->wa_phone_number_id;
            $this->wa_business_account_id = $integration->wa_business_account_id;
        }
    }

    public function saveIntegrations()
    {
        // Validation (you can set it stricter as you want/need)
        $this->validate([
            'ai_provider' => 'nullable|string|in:openai,gemini',
            'ai_api_key' => 'nullable|string',
            'wa_access_token' => 'nullable|string',
            'wa_phone_number_id' => 'nullable|string',
            'wa_business_account_id' => 'nullable|string',
        ]);

        // Create or Update
        Integration::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'ai_provider' => $this->ai_provider,
                'ai_api_key' => $this->ai_api_key,
                'wa_access_token' => $this->wa_access_token,
                'wa_phone_number_id' => $this->wa_phone_number_id,
                'wa_business_account_id' => $this->wa_business_account_id,
            ]
        );

        session()->flash('success', 'Integration settings updated successfully.');
        $this->dispatch('settings-saved');
    }

    public function render()
    {
        return view('livewire.integrations.integrations');
    }
}
