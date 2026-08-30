<?php

use App\Models\User;

test('un alumno no puede acceder a rutas de administracion', function () {
    $alumno = User::factory()->alumno()->create();

    $this->actingAs($alumno)
        ->get(route('admin.teachers.index'))
        ->assertForbidden();
});

test('un docente no puede acceder a rutas de administracion', function () {
    $docente = User::factory()->docente()->create();

    $this->actingAs($docente)
        ->get(route('admin.students.index'))
        ->assertForbidden();
});

test('un docente no puede acceder a rutas de estudiante', function () {
    $docente = User::factory()->docente()->create();

    $this->actingAs($docente)
        ->get(route('student.exams'))
        ->assertForbidden();
});

test('ver un recurso docente que no es docente devuelve 404', function () {
    $admin = User::factory()->admin()->create();
    $alumno = User::factory()->alumno()->create();

    $this->actingAs($admin)
        ->get(route('admin.teachers.show', $alumno))
        ->assertNotFound();
});
