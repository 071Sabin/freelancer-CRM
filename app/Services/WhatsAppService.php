<?php

namespace App\Services;

use App\Models\Integration;
use App\Models\Project;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class WhatsAppService
{
    /**
     * Generate Portal Link and Send WhatsApp Update for a Project.
     */
    public function sendProjectPortal(Project $project)
    {
        // 1. Ensure client relation is loaded (loadMissing is safer)
        $project->loadMissing('client');

        // 2. Check if phone exists, phone is required while creating client but it's fail safe
        if (!$project->client || empty($project->client->company_phone)) {
            return [
                'success' => true,
                'skipped' => true,
                'message' => 'Client has no phone number, WhatsApp skipped.'
            ];
        }

        // 3. Generate Link & Message
        $magicLink = route('client.portal', ['uuid' => $project->uuid]);
        $clientName = $project->client->client_name ?? 'Client';

        $message = "Hi {$clientName} 👋\n\n";
        $message .= "We've just updated your project: *{$project->name}*.\n\n";
        $message .= "You can track the live progress, view details, and access invoices anytime on your secure portal right here:\n\n";
        $message .= $magicLink . "\n\n";
        $message .= "Let us know if you have any questions!";

        // 4. Call the core send method
        $response = $this->sendMessage($project->user_id, $project->client->company_phone, $message);

        // Add skipped = false so the frontend knows it actually tried to send
        $response['skipped'] = false;

        return $response;
    }

    /**
     * Send a highly secure WhatsApp Message.
     * Automatically switches between Live API and Local Log based on keys.
     */
    public function sendMessage($userId, $toPhoneNumber, $message)
    {
        try {
            // 1. Fetch user's integration settings.
            // Note: wa_access_token is automatically decrypted by the Integration model!
            $integration = Integration::where('user_id', $userId)->first();

            // 2. SIMULATION MODE (Testing / No Keys)
            if (!$integration || empty($integration->wa_access_token) || empty($integration->wa_phone_number_id)) {

                // we'll print the message in the logs instead of sending it to WhatsApp
                Log::info("🟢 WHATSAPP SIMULATED TO [{$toPhoneNumber}]: \n{$message}");

                return [
                    'success' => true,
                    'simulated' => true,
                    'message' => 'Message logged locally (No API keys configured).'
                ];
            }

            // 3. LIVE MODE (Strictly Secure API Call)

            // Security: Remove any special characters/spaces from the phone number
            // Meta API strictly wants numbers (e.g., 919876543210)
            $cleanPhone = preg_replace('/[^0-9]/', '', $toPhoneNumber);

            $url = "https://graph.facebook.com/v19.0/{$integration->wa_phone_number_id}/messages";

            // Security: Use timeout(10) so if Meta's server is down, your app doesn't crash/hang.
            $response = Http::withToken($integration->wa_access_token)
                ->timeout(10)
                ->post($url, [
                    'messaging_product' => 'whatsapp',
                    'to' => $cleanPhone,
                    'type' => 'text',
                    'text' => [
                        'body' => $message,
                        'preview_url' => true // showing link thumbnail in whatsApp
                    ]
                ]);

            if ($response->successful()) {
                return ['success' => true, 'simulated' => false, 'data' => $response->json()];
            }

            // Security: Log the API error and not log or return the access token
            Log::error("WhatsApp API Error (User: {$userId}): " . $response->body());

            return [
                'success' => false,
                'error' => 'WhatsApp API rejected the request. Please check your integration settings.'
            ];
        } catch (Exception $e) {
            // Security: Catch generic exceptions so stack traces/tokens don't leak to the frontend.
            Log::error("WhatsApp Service Exception: " . $e->getMessage());

            return [
                'success' => false,
                'error' => 'Internal server error while sending message.'
            ];
        }
    }
}
