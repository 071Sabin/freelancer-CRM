<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Relationships
            'user_id' => User::factory(),

            // Client Details
            'client_name' => $this->faker->name(),
            'client_email' => $this->faker->unique()->safeEmail(),

            // Company Details
            'company_name' => $this->faker->company(),
            'company_email' => $this->faker->unique()->safeEmail(),
            'company_website' => $this->faker->url(),
            'company_phone' => $this->faker->phoneNumber(),
            'billing_address' => $this->faker->address(),

            // Financials
            'hourly_rate' => '50.00', // Hardcoded instead of random for predictable testing math
            'currency_id' => null,    // Relies on seeders, so we keep it null by default

            // Status & Notes
            'status' => 'active',
            'private_notes' => $this->faker->sentence(),
        ];
    }

    /**
     * STATE: Inactive Client
     */
    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'inactive',
        ]);
    }


    /**
     * STATE: Soft Deleted Client
     * Great for testing that deleted clients don't show up in active dropdowns.
     */
    public function deleted(): static
    {
        return $this->state(fn(array $attributes) => [
            'deleted_at' => now(),
        ]);
    }
}
