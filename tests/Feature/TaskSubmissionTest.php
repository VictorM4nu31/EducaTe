<?php

use App\Models\Group;
use App\Models\Task;
use App\Models\TaskAssignment;
use App\Models\TaskSubmission;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

function taskGroupFor(User $teacher): Group
{
    return Group::factory()->create(['teacher_id' => $teacher->id]);
}

test('un alumno puede presentar una tarea de su grupo', function () {
    $teacher = User::factory()->docente()->create();
    $student = User::factory()->alumno()->create();
    $group = taskGroupFor($teacher);
    $group->addStudent($student);
    $task = Task::factory()->create(['created_by' => $teacher->id]);
    TaskAssignment::create(['task_id' => $task->id, 'group_id' => $group->id]);

    UploadedFile::fake()->create('tarea.pdf', 10, 'application/pdf');

    $this->actingAs($student)
        ->post(route('student.tasks.submit.store', $task), [
            'file' => UploadedFile::fake()->create('tarea.pdf', 10, 'application/pdf'),
            'notes' => 'Mi entrega',
        ])
        ->assertRedirect(route('student.tasks'));

    $submission = TaskSubmission::where('task_id', $task->id)->where('user_id', $student->id)->first();
    expect($submission)->not->toBeNull();
    expect($submission->status)->toBe('submitted');
    expect(Storage::disk('public')->exists($submission->file_path))->toBeTrue();
});

test('un alumno sin acceso no puede presentar una tarea', function () {
    $teacher = User::factory()->docente()->create();
    $student = User::factory()->alumno()->create();
    $task = Task::factory()->create(['created_by' => $teacher->id]);

    $this->actingAs($student)
        ->post(route('student.tasks.submit.store', $task), [
            'file' => UploadedFile::fake()->create('x.pdf', 10, 'application/pdf'),
        ])
        ->assertForbidden();
});

test('al re-presentar se reemplaza el archivo y se limpia la nota previa', function () {
    $teacher = User::factory()->docente()->create();
    $student = User::factory()->alumno()->create();
    $task = Task::factory()->create(['created_by' => $teacher->id]);
    TaskAssignment::create(['task_id' => $task->id, 'user_id' => $student->id]);
    $submission = TaskSubmission::factory()->create([
        'task_id' => $task->id,
        'user_id' => $student->id,
        'status' => 'graded',
        'grade' => 9,
        'file_path' => 'task_submissions/old.pdf',
        'file_name' => 'old.pdf',
    ]);
    Storage::disk('public')->put($submission->file_path, 'old');

    $this->actingAs($student)
        ->post(route('student.tasks.submit.store', $task), [
            'file' => UploadedFile::fake()->create('nueva.pdf', 10, 'application/pdf'),
            'notes' => 'Reentrega',
        ]);

    $submission->refresh();
    expect($submission->status)->toBe('submitted');
    expect($submission->grade)->toBeNull();
    expect($submission->file_name)->toBe('nueva.pdf');
    expect(Storage::disk('public')->exists($submission->file_path))->toBeTrue();
    expect(Storage::disk('public')->exists('task_submissions/old.pdf'))->toBeFalse();
});

test('solo el docente autor de la tarea puede calificarla', function () {
    $teacher = User::factory()->docente()->create();
    $other = User::factory()->docente()->create();
    $student = User::factory()->alumno()->create();
    $task = Task::factory()->create(['created_by' => $teacher->id]);
    $submission = TaskSubmission::factory()->create(['task_id' => $task->id, 'user_id' => $student->id]);

    $this->actingAs($other)
        ->post(route('teacher.tasks.submissions.grade', $submission), ['grade' => 8])
        ->assertForbidden();
});

test('calificar con nota aprobatoria acredita AC proporcional', function () {
    $teacher = User::factory()->docente()->create();
    $student = User::factory()->alumno()->create();
    $task = Task::factory()->create(['created_by' => $teacher->id, 'ac_reward' => 40]);
    $submission = TaskSubmission::factory()->create(['task_id' => $task->id, 'user_id' => $student->id]);

    $this->actingAs($teacher)
        ->post(route('teacher.tasks.submissions.grade', $submission), ['grade' => 8])
        ->assertRedirect();

    $submission->refresh();
    expect((float) $submission->grade)->toBe(8.0);
    expect($submission->status)->toBe('graded');
    // 40 * (8/10) = 32 AC, acreditados con retención del 5%.
    expect($student->wallet->transactions()->where('type', 'income')->exists())->toBeTrue();
});
