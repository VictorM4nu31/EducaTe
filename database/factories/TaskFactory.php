<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'difficulty' => fake()->randomElement(['basic', 'intermediate', 'advanced']),
            'ac_reward' => fake()->numberBetween(10, 100),
            'due_date' => now()->addDays(7),
            'created_by' => User::factory(),
            'is_active' => true,
            'instructions' => fake()->paragraph(),
        ];
    }
}
