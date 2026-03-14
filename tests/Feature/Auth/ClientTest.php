<?php

namespace Tests\Feature\Client;

use App\Livewire\Clients\Clients;
use App\Livewire\Clients\ClientsTable;
use App\Models\Client;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_guest_is_redirected_to_login()
    {
        $this->get(route('clients'))
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_clients_page()
    {
        $user = User::factory()->create();

        // create 2 clients for THIS month
        Client::factory()->count(2)->create(['user_id' => $user->id, 'created_at' => now()]);

        // create 1 user with past month
        Client::factory()->create([
            'user_id' => $user->id,
            'created_at' => now()->subMonth(),
        ]);

        // create a client cor a COMPLETELY DIFFERENT user
        $hacker = User::factory()->create();
        Client::factory()->create([
            'user_id' => $hacker->id,
        ]);

        // check if user can view clients page
        $this->actingAs($user)->get(route('clients'))
            ->assertStatus(200)
            ->assertSeeLivewire(Clients::class)
            ->assertSee('Clients');
        // check if user can see the client component variables and amtches exactly as expected
        Livewire::actingAs($user)->test(Clients::class)
            ->assertSet('thisMonthClients', 2)
            // clientDetails is a Collection of objects, so we use the closure
            ->assertSet('clientDetails', function ($clients) {
                // dd('Client count is: ' . $clients->count());    
                return $clients->count() === 3;
            })
            ->assertSet('currencies', function ($currencies) {
                // dd('Currency count is: ' . $currencies->count());
                return $currencies->count() > 0;
            })
            ->assertSet('clientCount', 3);
    }


    // public function test_clients_table_displays_client_data()
    // {

    //     $user = User::factory()->create();

    //     $client = Client::factory()->create(['user_id' => $user->id]);

    //     $this->actingAs($user)
    //         ->get(route('clients'))
    //         ->assertSeeLivewire(Clients::class)
    //         ->assertSee($client->client_name)
    //         ->assertSee($client->client_email)
    //         ->assertSee($client->company_phone)
    //         ->assertSee($client->billing_address);
    // }

    public function test_add_client_successful()
    {
        $user = User::factory()->create();

        $currency = Currency::first();

        Livewire::actingAs($user)->test(Clients::class)
            ->set('form.client_name', 'test')
            ->set('form.client_email', 'test@test.com')
            ->set('form.company_name', 'test')
            ->set('form.company_email', 'test@test.com')
            ->set('form.company_website', 'test.com')
            ->set('form.company_phone', '1234567890')
            ->set('form.billing_address', 'testaddress')
            ->set('form.hourly_rate', '100')
            ->set('form.currency_id', $currency->id)
            ->set('form.status', 'active')
            ->set('form.private_notes', 'testnotes')
            ->call('addClient')
            ->assertHasNoErrors()
            // ->assertSessionHas('success', 'Client added successfully!');
            ->assertDispatched('refreshDatatable');

        // now testing if DB has exact data that we set above
        $this->assertDatabaseHas('clients', [
            'user_id' => $user->id,
            'client_email' => 'test@test.com',
            'client_name' => 'test',
            'company_email' => 'test@test.com',
        ]);
    }

    public function test_clicking_edit_opens_client_modal()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create(['user_id' => $user->id]);
        Livewire::actingAs($user)
            ->test(Clients::class)
            ->call('edit', $client->id)
            ->assertStatus(200)
            ->assertSet('form.client_name', $client->client_name)
            ->assertSet('form.client_email', $client->client_email)
            ->assertSet('form.company_name', $client->company_name)
            ->assertSet('form.company_email', $client->company_email)
            ->assertSet('form.company_website', $client->company_website)
            ->assertSet('form.company_phone', $client->company_phone)
            ->assertSet('form.billing_address', $client->billing_address)
            ->assertSet('form.hourly_rate', $client->hourly_rate)
            ->assertSet('form.currency_id', $client->currency_id)
            ->assertSet('form.status', $client->status)
            ->assertSet('form.private_notes', $client->private_notes)
            ->assertSee('Edit Profile')
            ->assertSee('save changes')
            ->assertSee('Cancel');
    }

    public function test_edit_client_successful()
    {
        $user = User::factory()->create();
        $currency = Currency::first();

        $client = Client::factory()->create([
            'user_id' => $user->id,
            'client_name' => 'old boring name'
        ]);

        Livewire::actingAs($user)->test(Clients::class)
        ->call('edit', $client->id)
            ->set('form.client_name', 'clienttest')
            ->set('form.client_email', 'test@clienttest.com')
            ->set('form.company_name', 'test')
            ->set('form.company_email', 'clienttest@clienttest.com')
            ->set('form.company_website', 'clienttest.com')
            ->set('form.company_phone', '1234567890')
            ->set('form.billing_address', 'clienttestaddress')
            ->set('form.hourly_rate', '100')
            ->set('form.currency_id', $currency->id)
            ->set('form.status', 'active')
            ->set('form.private_notes', 'clienttestnotes')
            ->call('update')
            ->assertHasNoErrors();
        
            $this->assertDatabaseHas('clients',[
                'id'=> $client->id,
                'client_name' => 'clienttest',
                'client_email' => 'test@clienttest.com',
            ]);
    }
}
