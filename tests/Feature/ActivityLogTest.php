<?php

use App\Models\ActivityLog;
use App\Models\User;

test('crear una recompensa registra una accion de auditoria', function () {
    $docente = User::factory()->docente()->create();

    $this->actingAs($docente)->post(route('teacher.rewards.store'), [
        'name' => 'Premio Auditado',
        'description' => 'Para el log',
        'cost' => 30,
        'category' => 'Snacks',
        'stock' => 10,
    ]);

    expect(ActivityLog::where('action', 'reward.created')->where('user_id', $docente->id)->exists())->toBeTrue();
});

test('crear un docente registra una accion de auditoria', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)->post(route('admin.teachers.store'), [
        'name' => 'Docente Audit',
        'email' => 'docente.audit@test.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    expect(ActivityLog::where('action', 'user.docente_created')->where('user_id', $admin->id)->exists())->toBeTrue();
});

test('publicar un reglamento registra una accion de auditoria', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)->post(route('resources.regulations.store'), [
        'title' => 'Reglamento auditado',
        'content' => 'Contenido del reglamento.',
    ]);

    expect(ActivityLog::where('action', 'regulation.created')->where('user_id', $admin->id)->exists())->toBeTrue();
});

test('calificar una tarea registra una accion de auditoria', function () {
    $docente = User::factory()->docente()->create();
    $alumno = User::factory()->alumno()->create();
    $task = \App\Models\Task::factory()->create(['created_by' => $docente->id]);
    $submission = \App\Models\TaskSubmission::factory()->create(['task_id' => $task->id, 'user_id' => $alumno->id]);

    $this->actingAs($docente)
        ->post(route('teacher.tasks.submissions.grade', $submission), [
            'grade' => 8,
            'feedback' => 'Buen trabajo',
        ])
        ->assertRedirect();

    expect(ActivityLog::where('action', 'task.graded')->where('user_id', $docente->id)->exists())->toBeTrue();
});
