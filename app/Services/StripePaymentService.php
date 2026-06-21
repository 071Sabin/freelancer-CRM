<?php

namespace App\Services;

use App\Models\Invoice;
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

    /**
     * Generate a Stripe Connect Checkout Session URL for client invoices.
     */
    public function generateCheckoutUrl(Invoice $invoice)
    {
        $user = $invoice->user; // The freelancer who owns this invoice
        if (!$user || !$user->stripe_account_id) {
            throw new \Exception("The freelancer does not have a Stripe account connected. Payments cannot be accepted.");
        }

        // Convert amount to cents
        $amountCents = intval(round($invoice->total * 100));
        $currencyCode = strtolower($invoice->currency->code ?? 'usd');

        // Create Checkout Session using destination charges
        $payload = [
            'mode' => 'payment',
            'success_url' => route('client.portal', ['uuid' => $invoice->project->uuid]) . '?payment=success',
            'cancel_url' => route('client.portal', ['uuid' => $invoice->project->uuid]) . '?payment=cancelled',
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => $currencyCode,
                        'unit_amount' => $amountCents,
                        'product_data' => [
                            'name' => 'Invoice #' . $invoice->invoice_number,
                            'description' => 'Project: ' . ($invoice->project->name ?? 'Service Work'),
                        ],
                    ],
                    'quantity' => 1,
                ]
            ],
            'payment_intent_data' => [
                'application_fee_amount' => intval(round($amountCents * 0.01)), // 1% platform transaction fee
                'transfer_data' => [
                    'destination' => $user->stripe_account_id,
                ],
            ],
            'metadata' => [
                'invoice_id' => (string) $invoice->id,
                'user_id' => (string) $user->id,
            ]
        ];

        $stripeSecret = env('STRIPE_SECRET') ?: config('services.stripe.secret');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $stripeSecret,
        ])
        ->asForm()
        ->post('https://api.stripe.com/v1/checkout/sessions', $payload);

        if ($response->successful()) {
            return $response->json('url');
        }

        Log::error('Stripe Checkout Session Creation Failed: ' . $response->body());
        throw new \Exception('Could not generate the Stripe payment link: ' . $response->json('error.message', 'Unknown Stripe API error'));
    }
}
