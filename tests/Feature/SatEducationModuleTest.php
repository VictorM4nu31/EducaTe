<?php

use App\Models\SatLesson;
use App\Models\User;

function satLessonWithQuiz(array $overrides = []): SatLesson
{
    return SatLesson::create(array_merge([
        'title' => 'Lección de prueba',
        'content' => 'Contenido de la lección',
        'category' => 'general',
        'difficulty' => 'basic',
        'order' => 1,
        'is_active' => true,
        'quiz_data' => [
            'questions' => [
                ['question' => '¿Cuál es la respuesta?', 'correct_answer' => 0, 'options' => ['A', 'B', 'C', 'D']],
            ],
        ],
    ], $overrides));
}

test('el indice muestra solo lecciones activas agrupadas por categoria', function () {
    $user = User::factory()->alumno()->create();
    satLessonWithQuiz(['category' => 'general', 'title' => 'Activa']);
    satLessonWithQuiz(['is_active' => false, 'category' => 'general', 'title' => 'Inactiva']);

    $this->actingAs($user)
        ->get(route('sat-education.index'))
        ->assertOk()
        ->assertSee('Activa')
        ->assertDontSee('Inactiva');
});

test('una leccion inactiva devuelve 404', function () {
    $user = User::factory()->alumno()->create();
    $lesson = satLessonWithQuiz(['is_active' => false]);

    $this->actingAs($user)
        ->get(route('sat-education.show', $lesson))
        ->assertNotFound();
});

test('responder mal el quiz no otorga recompensa', function () {
    $user = User::factory()->alumno()->create();
    $lesson = satLessonWithQuiz();

    $this->actingAs($user)
        ->post(route('sat-education.lessons.quiz.submit', $lesson), ['answers' => [0 => 1]])
        ->assertSessionHas('error');

    expect((float) $user->wallet->fresh()->balance)->toBe(0.0);
});

test('la calculadora SAT se muestra correctamente', function () {
    $user = User::factory()->alumno()->create();

    $this->actingAs($user)
        ->get(route('sat-education.calculator'))
        ->assertOk();
});
