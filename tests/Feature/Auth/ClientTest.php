<?php

namespace Tests\Feature\Client;

use App\Livewire\Clients\Clients;
use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;
    public function test_authenticated_user_can_view_clients_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get(route('clients'))
            ->assertStatus(200)
            ->assertSeeLivewire(Clients::class)
            ->assertSee('Clients');
    }

    public function test_guest_is_redirected_to_login()
    {
        $this->get(route('clients'))
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    public function test_clients_table_displays_client_data()
    {

        $user = User::factory()->create();

        $client = Client::create([
            'user_id' => $user->id,
            'client_name' => 'Test Client',
            'client_email' => 'test@example.com',
            'company_name' => 'Test Company',
            'phone' => '1234567890',
            'billing_address' => '123 Main St, Anytown, USA',
        ]);

        $this->actingAs($user)
            ->get(route('clients'))
            ->assertSeeLivewire(Clients::class)
            ->assertSee($client->name)
            ->assertSee($client->email)
            ->assertSee($client->phone)
            ->assertSee($client->address);
    }

    public function test_clicking_edit_opens_client_modal(){
        $user=User::factory()->create();
        $client=Client::create(['user_id'=>$user->id]);
        Livewire::actingAs($user)
        ->test(Clients::class)
        ->call('edit', $client->id)
        ->assertSet('editingClientId', $client->id);
    }
}
