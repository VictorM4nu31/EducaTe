<?php

use App\Enums\TransactionType;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Group;
use App\Models\Question;
use App\Models\User;

function examGroupFor(User $teacher): Group
{
    return Group::factory()->create(['teacher_id' => $teacher->id]);
}

test('un alumno puede iniciar un examen asignado a su clase', function () {
    $teacher = User::factory()->docente()->create();
    $student = User::factory()->alumno()->create();
    $group = examGroupFor($teacher);
    $group->addStudent($student);
    $exam = Exam::factory()->create(['created_by' => $teacher->id]);
    $exam->groups()->attach($group->id);

    $this->actingAs($student)
        ->get(route('student.exams.start', $exam))
        ->assertOk();

    expect(ExamAttempt::where('user_id', $student->id)->where('exam_id', $exam->id)->exists())->toBeTrue();
});

test('un alumno sin acceso al grupo no puede iniciar el examen', function () {
    $teacher = User::factory()->docente()->create();
    $student = User::factory()->alumno()->create();
    $exam = Exam::factory()->create(['created_by' => $teacher->id]);

    $this->actingAs($student)
        ->get(route('student.exams.start', $exam))
        ->assertForbidden();
});

test('al entregar, se calcula la calificacion y se acredita AC', function () {
    $teacher = User::factory()->docente()->create();
    $student = User::factory()->alumno()->create();
    $group = examGroupFor($teacher);
    $group->addStudent($student);
    $exam = Exam::factory()->create(['created_by' => $teacher->id]);
    $exam->groups()->attach($group->id);

    $question = Question::factory()->create(['exam_id' => $exam->id, 'correct_answer' => 'A', 'points' => 1]);
    $exam->load('questions');

    $attempt = ExamAttempt::create([
        'exam_id' => $exam->id,
        'user_id' => $student->id,
        'started_at' => now(),
        'answers' => [],
        'metadata' => ['hints' => []],
    ]);

    $this->actingAs($student)
        ->post(route('student.exams.submit', [$exam, $attempt]), ['answers' => [$question->id => 'A']])
        ->assertRedirect(route('student.exams'));

    $attempt->refresh();
    expect((float) $attempt->grade)->toBe(100.0);
    expect((float) $attempt->final_grade)->toBe(100.0);
    expect($attempt->is_completed)->toBeTrue();
    expect($student->wallet->transactions()->where('type', TransactionType::Income->value)->exists())->toBeTrue();
});

test('un intento anulado no puede ser entregado', function () {
    $teacher = User::factory()->docente()->create();
    $student = User::factory()->alumno()->create();
    $exam = Exam::factory()->create(['created_by' => $teacher->id]);
    $attempt = ExamAttempt::create([
        'exam_id' => $exam->id,
        'user_id' => $student->id,
        'started_at' => now(),
        'is_annulled' => true,
        'answers' => [],
        'metadata' => ['hints' => []],
    ]);

    $this->actingAs($student)
        ->post(route('student.exams.submit', [$exam, $attempt]), ['answers' => []])
        ->assertSessionHasErrors('error');
});

test('solo puede guardar progreso el dueno del intento', function () {
    $teacher = User::factory()->docente()->create();
    $student = User::factory()->alumno()->create();
    $other = User::factory()->alumno()->create();
    $exam = Exam::factory()->create(['created_by' => $teacher->id]);
    $attempt = ExamAttempt::create([
        'exam_id' => $exam->id,
        'user_id' => $student->id,
        'started_at' => now(),
        'answers' => [],
        'metadata' => ['hints' => []],
    ]);

    $this->actingAs($other)
        ->postJson(route('student.exams.save-progress', [$exam, $attempt]), ['answers' => ['3' => 'X']])
        ->assertStatus(403);

    $this->actingAs($student)
        ->postJson(route('student.exams.save-progress', [$exam, $attempt]), ['answers' => ['3' => 'A']])
        ->assertOk();

    expect($attempt->fresh()->answers)->toHaveKey('3');
});

test('un examen asignado directamente al alumno aparece en su listado', function () {
    $teacher = User::factory()->docente()->create();
    $student = User::factory()->alumno()->create();
    $exam = Exam::factory()->create(['created_by' => $teacher->id, 'title' => 'Examen Directo']);
    $exam->assignedUsers()->attach($student->id);

    $this->actingAs($student)
        ->get(route('student.exams'))
        ->assertOk()
        ->assertSee('Examen Directo')
        ->assertDontSee('No tienes exámenes');
});

test('el modelo sabe si un examen esta disponible para un alumno', function () {
    $teacher = User::factory()->docente()->create();
    $student = User::factory()->alumno()->create();
    $other = User::factory()->alumno()->create();
    $group = examGroupFor($teacher);
    $group->addStudent($student);

    $byGroup = Exam::factory()->create(['created_by' => $teacher->id]);
    $byGroup->groups()->attach($group->id);

    $direct = Exam::factory()->create(['created_by' => $teacher->id]);
    $direct->assignedUsers()->attach($student->id);

    expect($byGroup->isAvailableTo($student))->toBeTrue();
    expect($direct->isAvailableTo($student))->toBeTrue();
    expect($byGroup->isAvailableTo($other))->toBeFalse();
});

test('el docente solo ve sus propios examenes', function () {
    $teacher = User::factory()->docente()->create();
    $other = User::factory()->docente()->create();
    Exam::factory()->create(['created_by' => $teacher->id, 'title' => 'Mio']);
    Exam::factory()->create(['created_by' => $other->id, 'title' => 'De otro']);

    $this->actingAs($teacher)
        ->get(route('teacher.exams.index'))
        ->assertOk()
        ->assertSee('Mio')
        ->assertDontSee('De otro');
});
