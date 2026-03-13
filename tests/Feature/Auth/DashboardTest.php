<?php

namespace Tests\Feature\Auth;

use App\Livewire\Dashboard;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;
    /**
     * A basic feature test example.
     */
    public function test_dashboard_displays_correct_invoice_clients_projects_totals_and_counts()
    {
        // ARRANGE, set the trap
        $user = User::factory()->create();

        // creating client to assign invoice to this client
        $client = Client::factory()->create(['user_id' => $user->id]);

        Project::factory()->create([
            'user_id' => $user->id,
            'client_id' => $client->id
        ]);

        Project::factory()->count(2)->inProgress()->create(['user_id' => $user->id, 'client_id' => $client->id]);
        Project::factory()->completed()->create(['user_id' => $user->id, 'client_id' => $client->id]);

        // creating 2 paid invoices $200 in revenue
        Invoice::factory()->count(2)->paid()->create(['user_id' => $user->id, 'client_id' => $client->id]);

        // creating 1 overdue invoice
        Invoice::factory()->overdue()->create(['user_id' => $user->id, 'client_id' => $client->id]);

        // creating 1 draft invoice
        Invoice::factory()->draft()->create(['user_id' => $user->id, 'client_id' => $client->id]);

        // ACT load the dashboard, acting like loggedin user
        $component = Livewire::actingAs($user)->test(Dashboard::class);

        // ASSERT the component is loaded, and maths are correct
        $component->assertStatus(200)
            // assertSet says the variables inside the mount calculated has to be this exact number
            // we created 1 client above, so the variable should return 1
            ->assertSet('totalClients', 1)
            ->assertSet('progressProjects', 2)
            ->assertSet('activeProjects', 1)
            ->assertSet('recentProjects', function ($projects) {
                return $projects->count() === 3; // Checks that exactly 3 projects are in the list
            })            

            // total revenue should be 200 because revenue = total of paid status and we have $100*2 invoices paid status above
            ->assertSet('totalRevenue', 200.00)
            ->assertSet('pendingInvoices', 2)
            ->assertSet('overdueInvoices', 1)
            ->assertSee('200.00') // The revenue amount is visible on screen
            ->assertSee('2')      // The pending count is visible on screen

            // 3. Prove the specific UI text/cards are rendered
            ->assertSee('Total Revenue')
            ->assertSee('Pending Invoices');
    }
}
