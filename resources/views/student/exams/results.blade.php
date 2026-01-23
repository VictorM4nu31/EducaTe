<x-layouts::app title="Resultados: {{ $exam->title }}">
    <div class="container mx-auto py-6 max-w-3xl">
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-2">Resultados del Examen</h1>
            <p class="text-neutral-500 dark:text-neutral-400">{{ $exam->title }}</p>
        </div>

        <!-- Resumen -->
        <flux:card class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                <div>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">Calificación</p>
                    <p class="text-4xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($attempt->final_grade, 1) }}%</p>
                </div>
                <div>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">AulaChain Ganados</p>
                    <p class="text-4xl font-bold text-emerald-600 dark:text-emerald-400">₳ {{ number_format($attempt->ac_earned, 2) }}</p>
                </div>
                <div>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">Pistas Usadas</p>
                    <p class="text-4xl font-bold text-orange-600 dark:text-orange-400">{{ $attempt->hints_used }} / 3</p>
                </div>
            </div>
        </flux:card>

        <!-- Detalle de Respuestas -->
        <flux:card>
            <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-6">Detalle de Respuestas</h2>
            <div class="space-y-6">
                @foreach($exam->questions as $index => $question)
                    @php
                        $userAnswer = $attempt->answers[$question->id] ?? null;
                        $isCorrect = false;
                        if ($userAnswer) {
                            if ($question->type === 'multiple_choice') {
                                $isCorrect = strtoupper(trim($userAnswer)) === strtoupper(trim($question->correct_answer));
                            } else {
                                $isCorrect = strtolower(trim($userAnswer)) === strtolower(trim($question->correct_answer));
                            }
                        }
                    @endphp
                    <div class="p-4 border rounded-lg @if($isCorrect) border-emerald-200 dark:border-emerald-800 bg-emerald-50/50 dark:bg-emerald-900/10 @else border-red-200 dark:border-red-800 bg-red-50/50 dark:bg-red-900/10 @endif">
                        <div class="flex items-start justify-between mb-2">
                            <h3 class="font-bold text-neutral-900 dark:text-white">
                                Pregunta {{ $index + 1 }}: {{ $question->question_text }}
                            </h3>
                            <div class="flex items-center gap-2">
                                @if($isCorrect)
                                    <span class="px-2 py-1 bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300 rounded text-xs font-bold">
                                        ✓ Correcta
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300 rounded text-xs font-bold">
                                        ✗ Incorrecta
                                    </span>
                                @endif
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 rounded text-xs font-bold">
                                    {{ $question->points }} pts
                                </span>
                            </div>
                        </div>

                        <div class="space-y-2 mt-3">
                            <div>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">Tu respuesta:</p>
                                <p class="text-sm font-medium text-neutral-900 dark:text-white">{{ $userAnswer ?? 'Sin responder' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">Respuesta correcta:</p>
                                @if($question->type === 'multiple_choice' && $question->options)
                                    <p class="text-sm font-bold text-emerald-600 dark:text-emerald-400">
                                        {{ $question->correct_answer }}) {{ $question->options[$question->correct_answer] ?? $question->correct_answer }}
                                    </p>
                                @else
                                    <p class="text-sm font-bold text-emerald-600 dark:text-emerald-400">{{ $question->correct_answer }}</p>
                                @endif
                            </div>
                            @if($question->explanation)
                                <div class="mt-2 p-2 bg-neutral-100 dark:bg-neutral-800 rounded">
                                    <p class="text-xs text-neutral-600 dark:text-neutral-300">{{ $question->explanation }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </flux:card>

        <div class="mt-6 flex justify-center">
            <flux:button href="{{ route('exams') }}" variant="primary">
                Volver a Exámenes
            </flux:button>
        </div>
    </div>
</x-layouts::app>
