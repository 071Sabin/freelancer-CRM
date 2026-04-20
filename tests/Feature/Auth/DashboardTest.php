<?php

namespace Tests\Feature\Auth;

use App\Livewire\Dashboard\Dashboard;
use App\Models\AggregateStat;
use App\Models\Client;
use App\Models\Currency;
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
    // protected $seed = true;
    /**
     * A basic feature test example.
     */
    public function test_dashboard_displays_correct_invoice_clients_projects_totals_and_counts()
    {
        // ARRANGE: Set the trap with explicit, non-random data
        $user = User::factory()->create();

        // Grab or create a currency explicitly to avoid relying on random seeded data
        $currency = Currency::factory()->create();

        $client = Client::factory()->create([
            'user_id' => $user->id,
            'currency_id' => $currency->id
        ]);

        // -- PROJECTS --
        // Create exactly what the assertions expect: 1 active, 2 in progress, 1 completed
        Project::factory()->create([
            'user_id' => $user->id,
            'client_id' => $client->id,
            'status' => 'active' // Make sure statuses are explicitly set!
        ]);

        Project::factory()->count(2)->inProgress()->create([
            'user_id' => $user->id,
            'client_id' => $client->id
        ]);

        Project::factory()->completed()->create([
            'user_id' => $user->id,
            'client_id' => $client->id
        ]);

        // -- INVOICES --
        // 1. Two Paid Invoices ($200 Revenue)
        Invoice::factory()->count(2)->paid()->create([
            'user_id' => $user->id,
            'client_id' => $client->id,
            'total' => 100.00,
            'paid_total' => 100.00,
        ]);

        // 2. Two Overdue Invoices
        // FIXED: Count changed to 2 to match assertion, and due_date hardcoded to the past
        Invoice::factory()->count(2)->overdue()->create([
            'user_id' => $user->id,
            'client_id' => $client->id,
            'due_date' => now()->subDays(5), // Stop Faker from making this random!
            'total' => 50.00, // Explicit totals so they don't bloat revenue
            'paid_total' => 0.00,
        ]);

        // 3. Two Pending/Draft Invoices
        // FIXED: Count changed to 2, and due_date hardcoded to the future
        Invoice::factory()->count(2)->draft()->create([
            'user_id' => $user->id,
            'client_id' => $client->id,
            'due_date' => now()->addDays(5),
            'total' => 50.00,
            'paid_total' => 0.00,
        ]);

        $this->assertAggregateStat($user->id, 'total_clients', 1);
        $this->assertAggregateStat($user->id, 'active_projects', 1);
        $this->assertAggregateStat($user->id, 'in_progress_projects', 2);
        $this->assertAggregateStat($user->id, 'completed_projects', 1);
        $this->assertAggregateStat($user->id, 'total_invoices', 6);
        $this->assertAggregateStat($user->id, 'paid_invoices', 2);
        $this->assertAggregateStat($user->id, 'pending_invoices', 4);
        $this->assertAggregateStat($user->id, 'overdue_invoices', 2);
        $this->assertAggregateStat($user->id, 'total_revenue', 200.00);

        // ACT: Load the dashboard
        $component = Livewire::actingAs($user)->test(Dashboard::class);

        $component->assertStatus(200)
            ->assertSee('200.00')
            ->assertSee('4 pending')
            ->assertSee('2')
            ->assertSee('Total Revenue')
            ->assertSee('Total Invoices');
    }

    private function assertAggregateStat(int $userId, string $key, float $expected): void
    {
        $actual = AggregateStat::where('user_id', $userId)
            ->where('key', $key)
            ->value('value');

        $this->assertEquals($expected, (float) $actual, "Failed asserting aggregate stat [{$key}].");
    }
}
