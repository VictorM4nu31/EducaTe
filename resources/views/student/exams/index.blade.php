<x-layouts::app title="Mis Exámenes">
    <div class="container mx-auto py-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Exámenes Disponibles</h1>
            <p class="text-neutral-500 dark:text-neutral-400">Completa los exámenes para ganar AulaChain</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-lg">
                <p class="text-emerald-800 dark:text-emerald-200">{{ session('success') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($exams as $exam)
                @php
                    $attempt = $exam->attempts->first();
                @endphp
                <flux:card class="flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-bold text-neutral-900 dark:text-white">{{ $exam->title }}</h3>
                            @if($attempt && $attempt->is_completed)
                                <flux:badge variant="success" size="sm">Completado</flux:badge>
                            @endif
                        </div>

                        @if($exam->description)
                            <p class="text-sm text-neutral-600 dark:text-neutral-300 line-clamp-2">{{ $exam->description }}</p>
                        @endif

                        <div class="flex items-center gap-4 text-sm text-neutral-500 dark:text-neutral-400">
                            <div class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                                </svg>
                                <span>{{ $exam->questions->count() }} preguntas</span>
                            </div>
                            @if($exam->time_limit)
                                <div class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    <span>{{ $exam->time_limit }} min</span>
                                </div>
                            @endif
                        </div>

                        @if($attempt && $attempt->is_completed)
                            <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg border border-emerald-200 dark:border-emerald-800">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs text-emerald-700 dark:text-emerald-300 mb-1">Calificación</p>
                                        <p class="text-lg font-bold text-emerald-900 dark:text-emerald-200">{{ number_format($attempt->final_grade, 1) }}%</p>
                                        @if($attempt->hints_used > 0)
                                            <p class="text-[10px] text-emerald-600 dark:text-emerald-400 mt-1">
                                                {{ $attempt->hints_used }} pista(s) usada(s)
                                            </p>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-xs text-emerald-700 dark:text-emerald-300 mb-1">AC Ganados</p>
                                        <p class="text-lg font-bold text-emerald-900 dark:text-emerald-200">₳ {{ number_format($attempt->ac_earned, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 pt-4 border-t border-neutral-200 dark:border-neutral-700">
                        @if($attempt && $attempt->is_completed)
                            <flux:button href="{{ route('exams.start', $exam) }}" variant="ghost" size="sm" class="w-full">
                                Ver Detalles
                            </flux:button>
                        @else
                            <flux:button href="{{ route('exams.start', $exam) }}" variant="primary" size="sm" class="w-full">
                                {{ $attempt ? 'Continuar Examen' : 'Comenzar Examen' }}
                            </flux:button>
                        @endif
                    </div>
                </flux:card>
            @empty
                <div class="col-span-full py-12 text-center text-neutral-500 bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 mx-auto mb-3 opacity-20">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    <p class="font-medium">No hay exámenes disponibles</p>
                    <p class="text-xs mt-1">Únete a una clase para ver los exámenes asignados</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layouts::app>
