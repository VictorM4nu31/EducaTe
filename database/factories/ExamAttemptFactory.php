<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExamAttempt>
 */
class ExamAttemptFactory extends Factory
{
    public function definition(): array
    {
        return [
            'exam_id' => Exam::factory(),
            'user_id' => User::factory(),
            'hints_used' => 0,
            'answers' => [],
            'metadata' => ['hints' => []],
            'started_at' => now(),
            'is_completed' => false,
            'is_annulled' => false,
        ];
    }
}
