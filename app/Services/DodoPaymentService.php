<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Plan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DodoPaymentService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Generates a checkout link for platform subscriptions.
     */
    public function createSubscriptionLink($user, Plan $plan, bool $isYearly)
    {
        // 1. Get the correct Dodo Product ID straight from the Database
        // $dodoProductId = $isYearly ? $plan->dodo_price_id_yearly : $plan->dodo_price_id_monthly;
        $dodoProductId = trim($isYearly ? $plan->dodo_price_id_yearly : $plan->dodo_price_id_monthly);

        if (!$dodoProductId) {
            throw new \Exception("Invalid Dodo Product ID in database for this plan.");
        }

        // 2. Prepare the payload for Dodo API
        $payload = [
            'payment_link' => true,
            'customer' => [
                'email' => $user->email,
                'name'  => $user->name,
            ],
            'billing' => [
                'street'  => 'N/A',
                'city'    => 'N/A',
                'state'   => 'N/A',
                'country' => 'US',
                'zipcode' => '00000'
            ],

            // 🔥 THE FIX: Removed product_cart and changed 'plan_id' to 'product_id'
            'subscription' => [
                'product_id' => $dodoProductId,
                'quantity'   => 1,
            ],
            'product_id' => $dodoProductId,
            'quantity'   => 1,


            'return_url' => route('dashboard'),

            // Metadata remains same, it's correct
            'metadata' => [
                'user_id'         => (string) $user->id,
                'plan_id'         => (string) $plan->id,
                'billing_cycle'   => $isYearly ? 'yearly' : 'monthly',
                'payment_purpose' => 'platform_subscription'
            ]
        ];


        // 3. Make the API Call to Dodo
        $response = Http::withToken(env('DODO_PAYMENTS_API_KEY'))
            ->post(env('DODO_BASE_URL') . '/subscriptions', $payload);

        if ($response->successful()) {
            // dd([
            //     'STATUS' => 'API Call Successful!',
            //     'DODO_RESPONSE' => $response->json()
            // ]);
            return $response->json('payment_link');
        }

        Log::error('Dodo Subscription Setup Failed: ' . $response->body());
        throw new \Exception('Could not generate the subscription checkout link.');
    }

    
}
