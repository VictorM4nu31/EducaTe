<x-layouts::app title="{{ $exam->title }}">
    <div class="container mx-auto py-6">
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">{{ $exam->title }}</h1>
                    @if($exam->description)
                        <p class="text-neutral-500 dark:text-neutral-400 mt-1">{{ $exam->description }}</p>
                    @endif
                </div>
                <div class="flex gap-2">
                    <flux:button href="{{ route('teacher.exams.edit', $exam) }}" variant="ghost" icon="pencil-square">
                        Editar
                    </flux:button>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-lg">
                    <p class="text-emerald-800 dark:text-emerald-200">{{ session('success') }}</p>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Preguntas -->
            <div class="lg:col-span-2">
                <flux:card>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-neutral-900 dark:text-white">Preguntas ({{ $exam->questions->count() }})</h2>
                        <livewire:teacher.add-question :exam="$exam" />
                    </div>

                    <div class="space-y-4">
                        @forelse($exam->questions as $question)
                            <div class="p-4 border border-neutral-200 dark:border-neutral-700 rounded-lg">
                                <div class="flex items-start justify-between mb-2">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded text-xs font-bold">
                                                Pregunta {{ $question->order }}
                                            </span>
                                            <span class="px-2 py-1 bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 rounded text-xs font-bold">
                                                {{ $question->points }} puntos
                                            </span>
                                        </div>
                                        <p class="font-medium text-neutral-900 dark:text-white mb-2">{{ $question->question_text }}</p>
                                        @if($question->type === 'multiple_choice' && $question->options)
                                            <div class="ml-4 space-y-1">
                                                @foreach($question->options as $key => $option)
                                                    <p class="text-sm text-neutral-600 dark:text-neutral-400">
                                                        <span class="font-medium">{{ $key }})</span> {{ $option }}
                                                        @if($key === $question->correct_answer)
                                                            <span class="ml-2 text-emerald-600 dark:text-emerald-400 font-bold">✓ Correcta</span>
                                                        @endif
                                                    </p>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-sm text-neutral-500 dark:text-neutral-400">
                                                Respuesta correcta: <strong>{{ $question->correct_answer }}</strong>
                                            </p>
                                        @endif
                                    </div>
                                    <form action="{{ route('teacher.exams.questions.destroy', [$exam, $question]) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <flux:button type="submit" variant="ghost" size="sm" icon="trash" />
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12 text-neutral-500">
                                <p class="font-medium">No hay preguntas aún</p>
                                <p class="text-xs mt-1">Agrega preguntas para que el examen esté completo</p>
                            </div>
                        @endforelse
                    </div>
                </flux:card>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <flux:card>
                    <h3 class="font-bold text-neutral-900 dark:text-white mb-4">Información del Examen</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">Bonificación Base</p>
                            <p class="font-bold text-emerald-600 dark:text-emerald-400">₳ {{ number_format($exam->ac_reward_bonus, 2) }}</p>
                        </div>
                        @if($exam->time_limit)
                            <div>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">Tiempo Límite</p>
                                <p class="font-medium text-neutral-900 dark:text-white">{{ $exam->time_limit }} minutos</p>
                            </div>
                        @endif
                        <div>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">Total de Puntos</p>
                            <p class="font-bold text-blue-600 dark:text-blue-400">
                                {{ $exam->questions->sum('points') }} puntos
                            </p>
                        </div>
                    </div>
                </flux:card>

                <flux:card>
                    <h3 class="font-bold text-neutral-900 dark:text-white mb-4">Clases Asignadas</h3>
                    @if($exam->assignments->count() > 0)
                        <div class="space-y-2">
                            @foreach($exam->assignments as $assignment)
                                @if($assignment->group)
                                    <div class="p-2 bg-neutral-50 dark:bg-neutral-800 rounded">
                                        <p class="text-sm font-medium text-neutral-900 dark:text-white">{{ $assignment->group->name }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-neutral-500 dark:text-neutral-400">No hay clases asignadas</p>
                    @endif
                </flux:card>
            </div>
        </div>
    </div>
</x-layouts::app>
