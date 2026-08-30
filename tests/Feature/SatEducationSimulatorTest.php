<?php

use App\Enums\TransactionType;
use App\Models\SatLesson;
use App\Models\SatLessonCompletion;
use App\Models\User;

test('presentar la declaracion acredita AC una sola vez al dia', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('sat-education.simulator.submit'))
        ->assertRedirect(route('sat-education.index'))
        ->assertSessionHas('success');

    expect((float) $user->wallet->fresh()->balance)->toBe(10.0);
    expect($user->wallet->transactions()->where('type', TransactionType::Income->value)->count())->toBe(1);

    // Segundo intento el mismo dia no acredita mas AC.
    $this->actingAs($user)
        ->post(route('sat-education.simulator.submit'))
        ->assertSessionHas('error');

    expect((float) $user->wallet->fresh()->balance)->toBe(10.0);
    expect($user->wallet->transactions()->where('type', TransactionType::Income->value)->count())->toBe(1);
});

test('apobar el quiz otorga AC y registra la finalizacion una sola vez', function () {
    $user = User::factory()->create();

    $lesson = SatLesson::create([
        'title' => 'Leccion de prueba',
        'content' => 'Contenido',
        'category' => 'general',
        'difficulty' => 'basic',
        'order' => 1,
        'is_active' => true,
        'quiz_data' => [
            'questions' => [
                ['question' => '¿2+2?', 'correct_answer' => 0, 'options' => ['4', '5', '6', '7']],
            ],
        ],
    ]);

    $this->actingAs($user)
        ->post(route('sat-education.lessons.quiz.submit', $lesson), ['answers' => [0 => 0]])
        ->assertSessionHas('success');

    expect((float) $user->wallet->fresh()->balance)->toBe(5.0);
    expect(SatLessonCompletion::where('user_id', $user->id)->where('sat_lesson_id', $lesson->id)->exists())->toBeTrue();

    // Repetirlo no vuelve a acreditar.
    $this->actingAs($user)
        ->post(route('sat-education.lessons.quiz.submit', $lesson), ['answers' => [0 => 0]])
        ->assertSessionHas('error');

    expect((float) $user->wallet->fresh()->balance)->toBe(5.0);
});
