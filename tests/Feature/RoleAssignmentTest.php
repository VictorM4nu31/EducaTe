<?php

use App\Models\User;

test('un docente creado por el admin solo recibe el rol docente', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.teachers.store'), [
            'name' => 'Docente Nuevo',
            'email' => 'docente@test.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ])
        ->assertRedirect();

    $docente = User::where('email', 'docente@test.com')->first();

    expect($docente)->not->toBeNull();
    expect($docente->hasRole('docente'))->toBeTrue();
    expect($docente->hasRole('alumno'))->toBeFalse();
    expect($docente->hasRole('admin'))->toBeFalse();
});

test('el registro publico asigna unicamente el rol alumno', function () {
    $this->post(route('register'), [
        'name' => 'Estudiante Nuevo',
        'email' => 'estudiante@test.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $estudiante = User::where('email', 'estudiante@test.com')->first();

    expect($estudiante)->not->toBeNull();
    expect($estudiante->hasRole('alumno'))->toBeTrue();
    expect($estudiante->hasRole('docente'))->toBeFalse();
    expect($estudiante->hasRole('admin'))->toBeFalse();
});

test('las factories de rol crean usuarios con un unico rol', function () {
    expect(User::factory()->alumno()->create()->getRoleNames()->all())->toBe(['alumno']);
    expect(User::factory()->docente()->create()->getRoleNames()->all())->toBe(['docente']);
    expect(User::factory()->admin()->create()->getRoleNames()->all())->toBe(['admin']);
});
