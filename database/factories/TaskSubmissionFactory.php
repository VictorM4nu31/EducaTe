<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskSubmission>
 */
class TaskSubmissionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'task_id' => Task::factory(),
            'user_id' => User::factory(),
            'file_path' => 'task_submissions/test.pdf',
            'file_name' => 'test.pdf',
            'notes' => fake()->sentence(),
            'status' => 'submitted',
            'is_early' => false,
            'is_late' => false,
            'submitted_at' => now(),
        ];
    }
}
