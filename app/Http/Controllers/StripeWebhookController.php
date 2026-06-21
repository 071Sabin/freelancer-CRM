<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\InvoiceStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('Stripe Webhook received.');

        $payload = $request->all();
        $type = $payload['type'] ?? '';

        if ($type === 'checkout.session.completed') {
            $session = $payload['data']['object'] ?? [];
            $metadata = $session['metadata'] ?? [];
            $invoiceId = $metadata['invoice_id'] ?? null;

            if ($invoiceId) {
                Log::info("Processing successful payment for Invoice ID: {$invoiceId}");

                try {
                    DB::transaction(function () use ($invoiceId, $session) {
                        $invoice = Invoice::findOrFail($invoiceId);

                        // If already paid, do nothing
                        if ($invoice->invoice_status === 'paid') {
                            return;
                        }

                        $oldStatus = $invoice->invoice_status;
                        $amountPaid = ($session['amount_total'] ?? 0) / 100;

                        // Update Invoice
                        $invoice->update([
                            'invoice_status' => 'paid',
                            'paid_total' => $invoice->total,
                            'balance_due' => 0,
                            'paid_at' => now(),
                        ]);

                        // Create Payment record
                        InvoicePayment::create([
                            'invoice_id' => $invoice->id,
                            'user_id' => $invoice->user_id,
                            'provider' => 'stripe',
                            'method' => 'card',
                            'reference' => $session['payment_intent'] ?? $session['id'] ?? 'stripe_checkout',
                            'amount' => $amountPaid,
                            'currency' => strtoupper($session['currency'] ?? 'usd'),
                            'exchange_rate' => 1.0,
                            'fee_amount' => 0,
                            'status' => 'completed',
                            'paid_at' => now(),
                            'notes' => 'Paid via Stripe Connect checkout session.',
                            'meta' => $session,
                        ]);

                        // Log Status History
                        InvoiceStatusHistory::create([
                            'invoice_id' => $invoice->id,
                            'user_id' => $invoice->user_id,
                            'from_status' => $oldStatus,
                            'to_status' => 'paid',
                            'reason' => 'Client successfully completed Stripe Connect checkout payment.',
                            'meta' => ['session_id' => $session['id']],
                        ]);
                    });

                    return response()->json(['status' => 'success'], 200);
                } catch (\Exception $e) {
                    Log::error("Error processing Stripe Webhook for Invoice ID {$invoiceId}: " . $e->getMessage());
                    return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
                }
            }
        }

        return response()->json(['status' => 'ignored'], 200);
    }
}
