<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\User;
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
        return [
            'uuid' => $this->faker->uuid(),
            'user_id' => User::factory(),
            'client_id' => Client::factory(),
            'invoice_number' => 'INV-' . $this->faker->unique()->numberBetween(10000, 99999),
            'type' => 'invoice',
            'invoice_status' => 'draft',
            'public_token' => Str::random(64),

            // Dates
            'issue_date' => now()->toDateString(),
            'due_date' => now()->addDays(30)->toDateString(),

            // Standardized Money (Avoid random amounts so tests are predictable)
            'currency' => 'USD',
            'subtotal' => 100.00,
            'tax_total' => 0.00,
            'total' => 100.00,
            'paid_total' => 0.00,
            'balance_due' => 100.00,
            'is_tax_inclusive' => false,
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
