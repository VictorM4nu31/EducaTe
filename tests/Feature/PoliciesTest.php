<?php

use App\Models\Exam;
use App\Models\Group;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

test('solo el docente propietario puede gestionar su clase', function () {
    $teacher = User::factory()->docente()->create();
    $other = User::factory()->docente()->create();
    $group = Group::factory()->create(['teacher_id' => $teacher->id]);

    expect(Gate::forUser($teacher)->allows('update', $group))->toBeTrue();
    expect(Gate::forUser($teacher)->allows('delete', $group))->toBeTrue();
    expect(Gate::forUser($teacher)->allows('regenerateCode', $group))->toBeTrue();
    expect(Gate::forUser($teacher)->allows('removeStudent', $group))->toBeTrue();

    expect(Gate::forUser($other)->allows('update', $group))->toBeFalse();
    expect(Gate::forUser($other)->allows('delete', $group))->toBeFalse();
    expect(Gate::forUser($other)->allows('view', $group))->toBeFalse();
});

test('solo el docente propietario puede gestionar su examen', function () {
    $teacher = User::factory()->docente()->create();
    $other = User::factory()->docente()->create();
    $exam = Exam::factory()->create(['created_by' => $teacher->id]);

    expect(Gate::forUser($teacher)->allows('view', $exam))->toBeTrue();
    expect(Gate::forUser($teacher)->allows('update', $exam))->toBeTrue();
    expect(Gate::forUser($teacher)->allows('delete', $exam))->toBeTrue();

    expect(Gate::forUser($other)->allows('update', $exam))->toBeFalse();
    expect(Gate::forUser($other)->allows('delete', $exam))->toBeFalse();
});

test('solo el docente autor del examen puede modificar sus preguntas', function () {
    $teacher = User::factory()->docente()->create();
    $other = User::factory()->docente()->create();
    $exam = Exam::factory()->create(['created_by' => $teacher->id]);
    $question = Question::factory()->create(['exam_id' => $exam->id]);

    expect(Gate::forUser($teacher)->allows('update', $question))->toBeTrue();
    expect(Gate::forUser($teacher)->allows('delete', $question))->toBeTrue();

    expect(Gate::forUser($other)->allows('update', $question))->toBeFalse();
    expect(Gate::forUser($other)->allows('delete', $question))->toBeFalse();
});
