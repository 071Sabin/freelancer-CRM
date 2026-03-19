<?php

namespace App\Services;

use App\Models\Invoice;
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

    public function generateCheckoutUrl(Invoice $invoice)
    {
        // amount always goes in cents (e.g., $50 = 5000)
        $amountInCents = (int) ($invoice->total * 100);
        // dd($invoice->uuid);
        $dodoProductId = 'pdt_0NaqQxanGnYcfkqs3hDHt';
        // dd($amountInCents);

        // sending request to DODO payment
        $response = Http::withToken(env('DODO_PAYMENTS_API_KEY'))
            ->post(env('DODO_BASE_URL') . '/checkouts', [
                'product_cart' => [
                    [
                        'product_id' => $dodoProductId,
                        'quantity' => 1,
                        'amount' => $amountInCents,
                    ]
                ],

                // this will return in webhooks to understand and know which invoice is paid and which invoice number
                'metadata' => [
                    'invoice_id' => (string) $invoice->id,
                    'invoice_number' => $invoice->invoice_number
                ],
                'return_url' => url('/p/view/' . $invoice->project->uuid . '?payment=success'),
            ]);

        if ($response->successful()) {
            // new endpoints URL can be 'data.checkout_url' or 'checkout_url'
            return $response->json('checkout_url') ?? $response->json('data.checkout_url');
        }

        // if something goes wrong then check logs for the error message
        Log::error('Dodo Payment Link Failed: ' . $response->body());
        throw new \Exception('Unable to generate payment link at the moment.');
    }
}
