<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class IntegrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),

            // AI BYOK
            'ai_provider' => $this->faker->randomElement(['gemini', 'openai']),
            'ai_api_key' => $this->faker->regexify('[A-Za-z0-9]{40}'),

            // WhatsApp Cloud API
            'wa_access_token' => $this->faker->regexify('[A-Za-z0-9]{60}'),
            'wa_phone_number_id' => $this->faker->numerify('############'),
            'wa_business_account_id' => $this->faker->numerify('############'),

            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
