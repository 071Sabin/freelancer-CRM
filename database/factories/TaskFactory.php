<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->optional()->paragraph(),
            'is_visible_to_client' => $this->faker->boolean(30),
            // 30% chance true
            'is_completed' => $this->faker->boolean(20),
            // usually false
            'position' => $this->faker->numberBetween(0, 10),
        ];
    }
}
