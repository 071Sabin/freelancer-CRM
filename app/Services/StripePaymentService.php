<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StripePaymentService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function handleCallback(Request $request)
    {
        // 1. Check if Stripe sent us the authorization code
        $code = $request->query('code');

        if (!$code) {
            Log::error('Stripe Connect: No code returned from Stripe.');
            return redirect()->route('settings')->with('error', 'Stripe connection failed or was cancelled.');
        }

        // 2. Exchange the temporary code for the actual Stripe Account ID, the code sent by stripe is temporary
        $response = Http::asForm()->post('https://connect.stripe.com/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => config('services.stripe.client_id'),
            'client_secret' => config('services.stripe.secret'),
            'code' => $code,
        ]);

        if ($response->successful()) {
            // 3. Success! Extract the ID and save it to the logged-in freelancer's profile
            $stripeAccountId = $response->json('stripe_user_id');

            // Assuming the user is logged in
            auth()->user()->update([
                'stripe_account_id' => $stripeAccountId
            ]);

            Log::info("Success: Stripe Account {$stripeAccountId} connected to User ID " . auth()->id());

            // Redirect them back to their dashboard with a success message
            return redirect()->route('settings')->with('success', 'Stripe connected successfully! You can now receive payments.');
        }

        // 4. If the API request failed
        Log::error('Stripe Token Exchange Failed: ' . $response->body());
        return redirect('/dashboard')->with('error', 'Could not verify your Stripe account. Please try again.');
    }
}
