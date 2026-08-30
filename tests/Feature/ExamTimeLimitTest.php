<?php

use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Group;
use App\Models\Question;
use App\Models\User;

test('un examen con tiempo limite expirado no puede ser entregado', function () {
    $teacher = User::factory()->docente()->create();
    $student = User::factory()->alumno()->create();
    $group = Group::factory()->create(['teacher_id' => $teacher->id]);
    $group->addStudent($student);
    $exam = Exam::factory()->create(['created_by' => $teacher->id, 'time_limit' => 5]);
    $exam->groups()->attach($group->id);
    $question = Question::factory()->create(['exam_id' => $exam->id, 'correct_answer' => 'A']);

    $attempt = ExamAttempt::create([
        'exam_id' => $exam->id,
        'user_id' => $student->id,
        'started_at' => now()->subMinutes(20), // supera el límite
        'answers' => [],
        'metadata' => ['hints' => []],
    ]);

    $this->actingAs($student)
        ->post(route('student.exams.submit', [$exam, $attempt]), ['answers' => [$question->id => 'A']])
        ->assertSessionHasErrors('error');

    expect($attempt->fresh()->grade)->toBeNull();
});
