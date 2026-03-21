<?php

namespace App\Livewire\Settings;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class StripeCallback extends Component
{

    public function mount()
    {
        // If user clicks 'Cancel' button, we redirect user to respective route
        if (request()->has('error')) {
            session()->flash('error', 'Stripe connection cancelled.');
            return redirect()->route('settings'); // can be sent to freelancer's setting page too
        }

        // catch the code sent by stripe
        $code = request()->query('code');

        if ($code) {
            // Send POST request to Stripe OAuth token endpoint to exchange authorization code for access data
            // “Hey Stripe, I received this authorization code from your redirect.
            // Please give me permanent credentials for this connected account.”
            $response = Http::asForm()->post('https://connect.stripe.com/oauth/token', [
                'client_secret' => env('STRIPE_SECRET'), // Your Stripe secret key
                'code' => $code, // Authorization code received from Stripe
                'grant_type' => 'authorization_code', // Required grant type for OAuth
            ]);

            // Check if Stripe API call was successful (status 200)
            if ($response->successful()) {
                // Convert response JSON into PHP array
                $stripeData = $response->json();

                $user = auth()->user();

                // Save Stripe connected account ID into user's record
                $user->stripe_account_id = $stripeData['stripe_user_id'];

                // Persist changes to database
                $user->save();

                // Flash success message to session (for UI notification)
                session()->flash('success', 'Stripe Connected Successfully!');

                // Redirect user back to settings page
                return redirect()->route('settings');
            } else {
                // Handle failed Stripe response (invalid code, expired, etc.)
                session()->flash('error', 'Failed to connect Stripe. Please try again.');
                return redirect()->route('settings');
            }
        }

        session()->flash('error', 'Something went wrong with Stripe.');
        return redirect()->route('settings');
    }


    // public function render()
    // {
    //     return view('livewire.settings.stripe-callback');
    // }


    public function render()
    {
        // this will never be shown because mount will be redirecting automatically
        // but livewire needs a dummy view to render
        return <<<'HTML'
        <div class="flex items-center justify-center h-screen">
            <p>Connecting to Stripe...</p>
        </div>
        HTML;
    }
}
