<?php

namespace Database\Factories;

use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'wallet_id' => Wallet::factory(),
            'amount' => fake()->randomFloat(2, 1, 100),
            'type' => fake()->randomElement(['income', 'expense', 'tax', 'p2p']),
            'description' => fake()->sentence(),
            'metadata' => [],
        ];
    }
}
