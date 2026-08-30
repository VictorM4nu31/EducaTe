<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reward>
 */
class RewardFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'description' => fake()->sentence(),
            'cost' => fake()->numberBetween(5, 500),
            'category' => fake()->randomElement(['Snacks', 'Privilegios', 'Material']),
            'stock' => fake()->numberBetween(1, 100),
        ];
    }
}
