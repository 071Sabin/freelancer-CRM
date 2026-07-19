<?php

namespace App\Livewire\Settings;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Client Pivot | Payment Settings')]
class Payment extends Component
{
    public function connectStripe()
    {
        $clientId = config('services.stripe.client_id');
        $redirectUri = urlencode(url('/stripe/callback'));
        $stripeUrl = "https://connect.stripe.com/oauth/authorize?response_type=code&client_id={$clientId}&scope=read_write&redirect_uri={$redirectUri}";
        return redirect()->away($stripeUrl);
    }

    public function render()
    {
        return view('livewire.settings.payment');
    }
}
