<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExamAssignment>
 */
class ExamAssignmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'exam_id' => Exam::factory(),
            'group_id' => Group::factory(),
            'user_id' => null,
            'available_from' => null,
            'available_until' => null,
            'time_limit' => null,
        ];
    }
}
