<?php

namespace Tests\Feature\Whatsapp;

use Tests\TestCase;
use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use App\Models\Integration;
use App\Services\WhatsAppService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class WhatsAppServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;
    /**
     * we have 3 cases in hwatsapp services
     * 1. client has no phone number = skipped the message sending step
     * 2. client has ph.No. but no integration = skipped the message sending step
     * 3. client has ph.No. and integration = send the message
     */
    public function test_it_skips_sending_if_client_has_no_phone_number()
    {
        // 1. Arrange
        $user = User::factory()->create();
        $client = Client::factory()->create([
            'user_id' => $user->id,
            'company_phone' => null,
        ]);
        $project = Project::factory()->create([
            'user_id' => $user->id,
            'client_id' => $client->id,
        ]);

        // 2. Act
        $service = app(WhatsAppService::class);
        $response = $service->sendProjectPortal($project);

        // 3. Assert
        $this->assertTrue($response['skipped']);
        $this->assertEquals('Client has no phone number, WhatsApp skipped.', $response['message']);
    }

    public function test_it_logs_message_in_simulation_mode_if_no_integration_exists()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create([
            'user_id' => $user->id,
            'company_phone' => '+919876543210',
        ]);
        $project = Project::factory()->create([
            'user_id' => $user->id,
            'client_id' => $client->id,
        ]);

        // not settingup integration for this test

        // logging the message when no integrations but phone No. exists.
        Log::shouldReceive('info')->once()->withArgs(function ($message) {
            return str_contains($message, 'WHATSAPP SIMULATED TO [+919876543210]');
        });

        // 2. Act
        $service = app(WhatsAppService::class);
        $response = $service->sendProjectPortal($project);

        // 3. Assert
        // without integration setup, the service returns these messages so testing those only
        $this->assertTrue($response['success']);
        $this->assertTrue($response['simulated']);
        $this->assertFalse($response['skipped']);
    }

    public function test_it_formats_number_and_sends_correct_payload_to_meta_api()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create([
            'user_id' => $user->id,
            'client_name' => 'Acme Crop',
            'company_phone' => '+919876543210',
        ]);

        $project = Project::factory()->create([
            'user_id' => $user->id,
            'name' => 'Test Project',
            'client_id' => $client->id,
        ]);

        // setting up integration for this test
        $integration = Integration::factory()->create([
            'user_id' => $user->id
        ]);

        // catch any request going to meta API
        Http::fake([
            'https://graph.facebook.com/v19.0/' . $integration->wa_phone_number_id . '/messages' => Http::response(['message_id' => 'wamid_123'], 200),
        ]);

        // 2. Act
        $service = app(WhatsAppService::class);
        $response = $service->sendProjectPortal($project);

        // 3. Assert
        $this->assertFalse($response['skipped']);
        $this->assertTrue($response['success']);
        $this->assertFalse($response['simulated']);


        // 4. check the payload, is it sending the exact message we want?
        Http::assertSent(function (\Illuminate\Http\Client\Request $request) use ($integration, $project) {
            $payload = $request->data();
            return $payload['to'] === '919876543210'
                && str_contains($payload['text']['body'], "Hi Acme Crop")
                && str_contains($payload['text']['body'], "*Test Project*")
                && str_contains($payload['text']['body'], route('client.portal', ['uuid' => $project->uuid]))
                && $request->hasHeader('Authorization', 'Bearer ' . $integration->wa_access_token);
        });
    }
}
