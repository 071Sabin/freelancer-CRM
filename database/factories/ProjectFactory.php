<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    use RefreshDatabase;

    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'user_id' => User::factory(),
            'name' => $this->faker->catchPhrase(),
            'description' => $this->faker->sentence(),
            'value' => 100.00,
            'currency_id' => null,
            'hourly_rate' => 50.00,
            'client_id' => Client::factory(),
            'status' => 'active',
            'deadline' => now()->addDays(30),
        ];
    }

    /**
     * STATE: In Progress
     */
    public function inProgress(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'in_progress',
        ]);
    }

    /**
     * STATE: Completed
     */
    public function completed(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'completed',
        ]);
    }
}
