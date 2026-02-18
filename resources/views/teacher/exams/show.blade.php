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
                <div
                    class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-lg">
                    <p class="text-emerald-800 dark:text-emerald-200">{{ session('success') }}</p>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Preguntas -->
            <div class="lg:col-span-2">
                <flux:card>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-neutral-900 dark:text-white">Preguntas
                            ({{ $exam->questions->count() }})</h2>
                        <livewire:teacher.add-question :exam="$exam" />
                    </div>

                    <div class="space-y-4">
                        <livewire:teacher.question-list :exam="$exam" />
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
                            <p class="font-bold text-emerald-600 dark:text-emerald-400">₳
                                {{ number_format($exam->ac_reward_bonus, 2) }}</p>
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
                                        <p class="text-sm font-medium text-neutral-900 dark:text-white">
                                            {{ $assignment->group->name }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-neutral-500 dark:text-neutral-400">No hay clases asignadas</p>
                    @endif
                </flux:card>

                <flux:card>
                    <h3 class="font-bold text-neutral-900 dark:text-white mb-4">Intentos Recientes</h3>
                    @php
                        $attempts = \App\Models\ExamAttempt::where('exam_id', $exam->id)->with('user')->latest()->take(10)->get();
                    @endphp
                    @if($attempts->count() > 0)
                        <div class="space-y-4">
                            @foreach($attempts as $attempt)
                                <div class="flex items-center justify-between p-3 bg-neutral-50 dark:bg-neutral-800 rounded-lg border {{ $attempt->is_annulled ? 'border-red-200 dark:border-red-900' : 'border-neutral-200 dark:border-neutral-700' }}">
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-bold text-neutral-900 dark:text-white truncate">
                                            {{ $attempt->user->name }}
                                        </p>
                                        <div class="flex items-center gap-2 mt-1">
                                            @if($attempt->is_completed)
                                                <span class="text-[10px] px-1.5 py-0.5 bg-green-100 text-green-700 rounded uppercase font-bold">Completado</span>
                                                <span class="text-xs font-mono text-neutral-500">Nota: {{ number_format($attempt->final_grade, 1) }}</span>
                                            @elseif($attempt->is_annulled)
                                                <span class="text-[10px] px-1.5 py-0.5 bg-red-100 text-red-700 rounded uppercase font-bold">Anulado</span>
                                            @else
                                                <span class="text-[10px] px-1.5 py-0.5 bg-blue-100 text-blue-700 rounded uppercase font-bold">En progreso</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    @if($attempt->is_annulled)
                                        <form action="{{ route('teacher.exams.attempts.reenable', [$exam, $attempt]) }}" method="POST">
                                            @csrf
                                            <flux:button type="submit" size="xs" variant="primary" class="bg-emerald-600 hover:bg-emerald-700">
                                                Habilitar
                                            </flux:button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-neutral-500 dark:text-neutral-400">Sin intentos registrados</p>
                    @endif
                </flux:card>
            </div>
        </div>
    </div>
</x-layouts::app>