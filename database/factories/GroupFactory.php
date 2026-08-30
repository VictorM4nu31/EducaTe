<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    public function definition(): array
    {
        return [
            'teacher_id' => User::factory(),
            'name' => fake()->words(3, true),
            'description' => fake()->sentence(),
            'subject' => fake()->word(),
            'grade' => fake()->randomElement(['8°', '9°', '10°', '11°']),
            'is_active' => true,
        ];
    }
}
