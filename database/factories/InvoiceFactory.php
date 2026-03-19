<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceSetting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Invoice::class;

    public function definition(): array
    {
        $issueDate = $this->faker->dateTimeBetween('-1 month', '+1 month');
        $dueDate = Carbon::parse($issueDate)->addDays(14);
        $invoiceSetting = InvoiceSetting::factory()->create();
        return [
            'uuid' => Str::uuid(),
            'user_id' => User::factory(),
            'client_id' => Client::factory(),
            // project_id is nullable, but usually overridden in tests if needed
            'project_id' => null,
            'approved_by' => null,

            // Appending a random string ensures the unique constraint (user_id + invoice_number) doesn't clash in mass inserts
            'invoice_number' => 'INV-' . $this->faker->unique()->numerify('#####'),
            'type' => 'invoice',
            'invoice_status' => $this->faker->randomElement(['draft', 'sent', 'paid', 'overdue']),
            'reference' => $this->faker->optional()->bothify('PO-####'),
            'public_token' => Str::random(64),

            'issue_date' => $issueDate,
            'due_date' => $dueDate,

            'approved_at' => null,
            'viewed_at' => null,
            'canceled_at' => null,
            'voided_at' => null,

            'bill_currency_id' => 1,
            'base_currency' => null,
            'exchange_rate' => null,

            // Financials zeroed out by default so your test logic can dictate the math
            'subtotal' => 0,
            'tax_total' => 0,
            'discount_total' => 0,
            'shipping_total' => 0,
            'adjustment_total' => 0,
            'total' => 0,
            'paid_total' => 0,
            'balance_due' => 0,
            'is_tax_inclusive' => false,

            'notes' => $this->faker->optional()->sentence(),
            'terms' => 'Net 14',
            'payment_terms' => 'Please pay within 14 days.',
            'due_days' => 14,
            'default_footer' => $invoiceSetting->default_footer,

            'sent_at' => null,
            'paid_at' => null,

            'client_snapshot' => null,
            'company_snapshot' => null,
            'billing_address' => null,
            'company_address' => null,
            'shipping_address' => null,
            'metadata' => null,
        ];
    }

    /**
     * STATE: Sent to client
     */
    public function sent(): static
    {
        return $this->state(fn(array $attributes) => [
            'invoice_status' => 'sent',
            'sent_at' => now(),
        ]);
    }
    /**
     * STATE: DRAFT
     */
    public function draft(): static
    {
        return $this->state(fn(array $attributes) => [
            'invoice_status' => 'draft',
        ]);
    }

    public function paid(): static
    {
        return $this->state(fn(array $attributes) => [
            'invoice_status' => 'paid',
            'paid_total' => $attributes['total'], // Pays whatever the total is
            'balance_due' => 0.00,
            'paid_at' => now(),
        ]);
    }

    /**
     * STATE: Overdue
     */
    public function overdue(): static
    {
        return $this->state(fn(array $attributes) => [
            'invoice_status' => 'overdue',
            'issue_date' => now()->subDays(45)->toDateString(),
            'due_date' => now()->subDays(15)->toDateString(), // Due in the past
        ]);
    }

    /**
     * STATE: Partially Paid
     */
    public function partiallyPaid($amount = 50.00): static
    {
        return $this->state(fn(array $attributes) => [
            'invoice_status' => 'partially_paid',
            'paid_total' => $amount,
            'balance_due' => $attributes['total'] - $amount,
        ]);
    }
}
