<?php

namespace Tests\Feature\Invoice;

use App\Livewire\Invoices\InvoiceFormModal;
use App\Models\Client;
use App\Models\Currency;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class InvoiceFormModalTest extends TestCase
{
    use refreshDatabase;
    protected $seed = true;
    /**
     * A basic feature test example.
     */
    public function test_it_creates_draft_invoice_and_auto_generates_invoice_number()
    {
        // 1. Arrange: Setup the sterile test environment
        $user = User::factory()->create();
        $client = Client::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->create(['user_id' => $user->id, 'client_id' => $client->id]);

        // CRITICAL: We need a currency in the DB for the mount() method!
        // Currency::factory()->create(['code' => 'USD']);

        // 2. Act: Simulate the user filling the form and hitting create
        Livewire::actingAs($user)
            ->test(\App\Livewire\Invoices\InvoiceFormModal::class)
            ->set('client_id', $client->id)
            ->set('project_id', $project->id)
            ->set('issue_date', now()->format('Y-m-d'))
            ->set('due_date', now()->addDays(14)->format('Y-m-d'))
            ->set('invoice_status', 'draft')
            ->call('create')
            ->assertHasNoErrors()
            ->assertDispatched('invoice-saved') // Proves the UI will refresh!
            ->assertDispatched('refreshDatatable');

        // 3. Assert: Did it actually save perfectly?
        $this->assertDatabaseHas('invoices', [
            'client_id' => $client->id,
            'project_id' => $project->id,
            'invoice_status' => 'draft',
            'invoice_number' => 'INV-00001', // Proves your settings logic worked!
            'total' => 0, // Starts at 0
        ]);

        // Proves the setting was incremented for the NEXT invoice
        $this->assertDatabaseHas('invoice_settings', [
            'user_id' => $user->id,
            'next_number' => 2,
        ]);
    }


    public function test_it_perfectly_calculates_invoice_totals_with_tax_and_discounts()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->create(['user_id' => $user->id, 'client_id' => $client->id]);
        // Currency::factory()->create(['code' => 'USD']);

        // Create an empty draft invoice to edit
        $invoice = Invoice::factory()->create([
            'user_id' => $user->id,
            'client_id' => $client->id,
            'project_id' => $project->id,
            'subtotal' => 0,
            'total' => 0,
        ]);

        Livewire::actingAs($user)
            ->test(InvoiceFormModal::class)
            ->call('edit', $invoice->id) // Boot the edit modal

            // Add Item 1 ($100)
            ->call('addItem')
            ->set('invoiceItems.0.description', 'Web Design')
            ->set('invoiceItems.0.quantity', 2)
            ->set('invoiceItems.0.unit_price', 50)

            // Add Item 2 ($100)
            ->call('addItem')
            ->set('invoiceItems.1.description', 'Hosting')
            ->set('invoiceItems.1.quantity', 1)
            ->set('invoiceItems.1.unit_price', 100)

            // Apply 10% Discount and 10% Tax
            ->set('discount_type', 'percentage')
            ->set('discount_value', 10)
            ->set('tax_rate', 10)

            // Trigger the save
            ->call('update')
            ->assertHasNoErrors();

        // Let's check if the math engine works!
        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'subtotal' => 200,          // 100 + 100
            'discount_total' => 20,     // 10% of 200
            'tax_total' => 18,          // 10% of 180 (Subtotal - Discount)
            'total' => 198,             // 180 + 18
        ]);

        // Did the items physically save to the database?
        $this->assertDatabaseHas('invoice_items', [
            'invoice_id' => $invoice->id,
            'description' => 'Web Design',
            'line_total' => 100,
        ]);
    }

    public function test_users_cannot_edit_invoices_they_do_not_own()
    {
        $hacker = User::factory()->create(); // Logged in user
        $founder = User::factory()->create(); // Actual owner

        $client = Client::factory()->create(['user_id' => $founder->id]);
        $project = Project::factory()->create(['user_id' => $founder->id, 'client_id' => $client->id]);
        // Currency::factory()->create(['code' => 'USD']);

        // This invoice belongs to the Founder
        $invoice = Invoice::factory()->create([
            'user_id' => $founder->id,
            'client_id' => $client->id,
            'project_id' => $project->id,
        ]);

        // Hacker tries to open the founder's invoice modal
        Livewire::actingAs($hacker)
            ->test(\App\Livewire\Invoices\InvoiceFormModal::class)
            ->call('edit', $invoice->id)
            ->assertForbidden(); // Proves Laravel blocks them with a 403!
    }
}
