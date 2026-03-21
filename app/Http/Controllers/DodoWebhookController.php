<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use Illuminate\Support\Facades\Log;

class DodoWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // 1. seeing what dodo sent in the log file
        Log::info('Dodo Webhook Hit!', $request->all());

        // Dodo normally sends the payload in the 'data' array
        $data = $request->input('data') ?? $request->all();
        $metadata = $data['metadata'] ?? null;
        // dd($metadata);

        // 2. if it's metadata, that means it's our system payment. 
        if ($metadata && isset($metadata['user_id'])) {

            // 3. inserting into db
            Subscription::updateOrCreate(
                [
                    'user_id' => $metadata['user_id']
                ],
                [
                    'plan_id' => $metadata['plan_id'],
                    'dodo_subscription_id' => $data['subscription_id'] ?? $data['id'] ?? null,
                    'dodo_customer_id' => $data['customer']['customer_id'] ?? null,
                    'billing_cycle' => $metadata['billing_cycle'],
                    'status' => 'active',
                    'current_period_start' => now(),
                    // Expiry date set kar rahe hain
                    'current_period_end' => $metadata['billing_cycle'] === 'yearly'
                        ? now()->addYear()
                        : now()->addMonth(),
                ]
            );

            return response()->json(['status' => 'success'], 200);
        }


        // if irrelevant events, then say ignore and return 200
        return response()->json(['status' => 'ignored'], 200);
    }
}
