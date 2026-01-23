<x-layouts::app title="Mis Exámenes">
    <div class="container mx-auto py-6">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Mis Exámenes</h1>
                <p class="text-neutral-500 dark:text-neutral-400">Gestiona los exámenes digitales para tus estudiantes</p>
            </div>
            <flux:button href="{{ route('teacher.exams.create') }}" icon="plus">
                Nuevo Examen
            </flux:button>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-lg">
                <p class="text-emerald-800 dark:text-emerald-200">{{ session('success') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($exams as $exam)
                <flux:card class="flex flex-col">
                    <div class="flex-1 space-y-4">
                        <div class="flex items-start justify-between">
                            <h3 class="text-lg font-bold text-neutral-900 dark:text-white">{{ $exam->title }}</h3>
                            @if($exam->is_active)
                                <flux:badge variant="success" size="sm">Activo</flux:badge>
                            @else
                                <flux:badge variant="danger" size="sm">Inactivo</flux:badge>
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
                                <span>{{ $exam->questions_count }} preguntas</span>
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
                    </div>

                    <div class="mt-6 pt-4 border-t border-neutral-200 dark:border-neutral-700 flex gap-2">
                        <flux:button href="{{ route('teacher.exams.show', $exam) }}" variant="primary" size="sm" class="flex-1">
                            Gestionar
                        </flux:button>
                        <flux:button href="{{ route('teacher.exams.edit', $exam) }}" variant="ghost" size="sm" icon="pencil-square" />
                    </div>
                </flux:card>
            @empty
                <div class="col-span-full py-12 text-center text-neutral-500 bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 mx-auto mb-3 opacity-20">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    <p class="font-medium">No has creado ningún examen aún</p>
                    <p class="text-xs mt-1">Crea tu primer examen para evaluar a tus estudiantes</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layouts::app>
