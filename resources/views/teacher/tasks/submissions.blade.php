<x-layouts::app title="Revisar Entregas">
    <div class="container mx-auto py-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Entregas Pendientes de Revisión</h1>
            <p class="text-neutral-500 dark:text-neutral-400">Califica las tareas entregadas por tus estudiantes</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-lg">
                <p class="text-emerald-800 dark:text-emerald-200">{{ session('success') }}</p>
            </div>
        @endif

        <flux:card>
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>Estudiante</flux:table.column>
                    <flux:table.column>Tarea</flux:table.column>
                    <flux:table.column>Archivo</flux:table.column>
                    <flux:table.column>Fecha de Entrega</flux:table.column>
                    <flux:table.column>Estado</flux:table.column>
                    <flux:table.column></flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @forelse($submissions as $submission)
                        <flux:table.row>
                            <flux:table.cell>
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-500 font-bold">
                                        {{ $submission->user->initials() }}
                                    </div>
                                    <span class="font-medium text-neutral-900 dark:text-white">{{ $submission->user->name }}</span>
                                </div>
                            </flux:table.cell>

                            <flux:table.cell>
                                <div>
                                    <span class="font-bold text-neutral-900 dark:text-white">{{ $submission->task->title }}</span>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                                        {{ ucfirst($submission->task->difficulty) }}
                                    </p>
                                </div>
                            </flux:table.cell>

                            <flux:table.cell>
                                <a href="{{ route('submissions.download', $submission) }}" 
                                   class="text-sm text-green-500 hover:underline flex items-center gap-1 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                    </svg>
                                    {{ $submission->file_name }}
                                </a>
                            </flux:table.cell>

                            <flux:table.cell>
                                <div>
                                    <p class="text-sm text-neutral-900 dark:text-white">{{ $submission->submitted_at->format('d/m/Y H:i') }}</p>
                                    <div class="flex gap-2 mt-1">
                                        @if($submission->is_early)
                                            <span class="px-2 py-0.5 bg-green-500/10 text-green-600 rounded text-xs font-bold ring-1 ring-green-500/20">
                                                Anticipada
                                            </span>
                                        @endif
                                        @if($submission->is_late)
                                            <span class="px-2 py-0.5 bg-alert-red/10 text-alert-red rounded text-xs font-bold ring-1 ring-alert-red/20">
                                                Tardía
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </flux:table.cell>

                            <flux:table.cell>
                                <flux:badge variant="warning" size="sm">Pendiente</flux:badge>
                            </flux:table.cell>

                            <flux:table.cell>
                                <flux:button href="{{ route('teacher.tasks.submissions.show', $submission) }}" variant="primary" size="sm">
                                    Revisar
                                </flux:button>
                            </flux:table.cell>
                        </flux:table.row>
                    @empty
                        <flux:table.row>
                            <flux:table.cell colspan="6" class="text-center py-12 text-neutral-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 mx-auto mb-3 opacity-20">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h11.25c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                                </svg>
                                <p class="font-medium">No hay entregas pendientes de revisión</p>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>

            @if($submissions->hasPages())
                <div class="mt-4">
                    {{ $submissions->links() }}
                </div>
            @endif
        </flux:card>
    </div>
</x-layouts::app>
