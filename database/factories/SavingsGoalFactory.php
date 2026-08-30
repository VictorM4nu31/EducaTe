<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SavingsGoal>
 */
class SavingsGoalFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->words(3, true),
            'description' => fake()->sentence(),
            'target_amount' => fake()->numberBetween(100, 5000),
            'current_amount' => 0,
            'target_date' => now()->addDays(30)->format('Y-m-d'),
            'is_completed' => false,
        ];
    }
}
