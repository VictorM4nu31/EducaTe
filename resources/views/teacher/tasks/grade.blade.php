<x-layouts::app title="Calificar Tarea">
    <div class="container mx-auto py-6 max-w-4xl">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-neutral-dark dark:text-neutral-dark">Calificar Tarea</h1>
            <p class="text-neutral-medium dark:text-neutral-medium">{{ $submission->task->title }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Información del Estudiante y Tarea -->
            <div class="lg:col-span-1 space-y-6">
                <flux:card>
                    <h3 class="font-bold text-neutral-dark dark:text-neutral-dark mb-4">Información del Estudiante</h3>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div
                                class="h-12 w-12 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-500 font-bold text-lg">
                                {{ $submission->user->initials() }}
                            </div>
                            <div>
                                <p class="font-bold text-neutral-dark dark:text-neutral-dark">
                                    {{ $submission->user->name }}
                                </p>
                                <p class="text-xs text-neutral-medium dark:text-neutral-medium">
                                    {{ $submission->user->email }}
                                </p>
                            </div>
                        </div>
                    </div>
                </flux:card>

                <flux:card>
                    <h3 class="font-bold text-neutral-dark dark:text-neutral-dark mb-4">Detalles de la Tarea</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-neutral-medium dark:text-neutral-medium mb-1">Dificultad</p>
                            <flux:badge @class([
                                'bg-blue-500/10 text-blue-500' => $submission->task->difficulty === 'basic',
                                'bg-emerald-500/10 text-emerald-500' => $submission->task->difficulty === 'intermediate',
                                'bg-orange-500/10 text-orange-500' => $submission->task->difficulty === 'advanced',
                                'bg-purple-500/10 text-purple-500' => $submission->task->difficulty === 'excellence',
                            ]) size="sm">
                                {{ ucfirst($submission->task->difficulty) }}
                            </flux:badge>
                        </div>
                        <div>
                            <p class="text-xs text-neutral-medium dark:text-neutral-medium mb-1">Recompensa Base</p>
                            <p class="font-bold text-emerald-500">₳ {{ number_format($submission->task->ac_reward, 2) }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-neutral-medium dark:text-neutral-medium mb-1">Fecha de Entrega</p>
                            <p class="text-sm font-medium text-neutral-dark dark:text-neutral-dark">
                                {{ $submission->submitted_at->format('d/m/Y H:i') }}
                            </p>
                            <div class="flex gap-2 mt-1">
                                @if($submission->is_early)
                                    <span class="px-2 py-0.5 bg-emerald-500/10 text-emerald-500 rounded text-xs font-bold">
                                        Anticipada (+10%)
                                    </span>
                                @endif
                                @if($submission->is_late)
                                    <span class="px-2 py-0.5 bg-orange-500/10 text-orange-500 rounded text-xs font-bold">
                                        Tardía (-20%)
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </flux:card>
            </div>

            <!-- Formulario de Calificación -->
            <div class="lg:col-span-2">
                <flux:card>
                    <div class="mb-6">
                        <h3 class="font-bold text-neutral-dark dark:text-neutral-dark mb-2">Archivo Entregado</h3>
                        <a href="{{ route('submissions.download', $submission) }}"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500/10 text-emerald-500 rounded-lg hover:bg-emerald-500/20 transition-colors">
                            <flux:icon icon="arrow-down-tray" class="size-5" />
                            Descargar: {{ $submission->file_name }}
                        </a>
                    </div>

                    @if($submission->notes)
                        <div
                            class="mb-6 p-4 bg-white dark:bg-neutral-dark rounded-lg border border-neutral-light dark:border-neutral-light">
                            <p class="text-xs text-neutral-medium dark:text-neutral-medium mb-1">Notas del Estudiante</p>
                            <p class="text-sm text-neutral-dark dark:text-neutral-dark">{{ $submission->notes }}</p>
                        </div>
                    @endif

                    <form action="{{ route('teacher.tasks.submissions.grade', $submission) }}" method="POST"
                        class="space-y-6">
                        @csrf

                        <div class="space-y-2">
                            <flux:field>
                                <flux:label>Calificación (0-10) *</flux:label>
                                <flux:input name="grade" type="number" step="0.1" min="0" max="10"
                                    value="{{ old('grade') }}" placeholder="8.5" required />
                                <flux:description>Califica el trabajo del estudiante de 0 a 10</flux:description>
                                <flux:error name="grade" />
                            </flux:field>
                        </div>

                        <div class="space-y-2">
                            <flux:field>
                                <flux:label>Comentarios / Feedback</flux:label>
                                <flux:textarea name="feedback" rows="5"
                                    placeholder="Escribe comentarios constructivos para el estudiante...">
                                    {{ old('feedback') }}
                                </flux:textarea>
                                <flux:error name="feedback" />
                            </flux:field>
                        </div>

                        <div class="space-y-2">
                            <flux:field>
                                <flux:checkbox name="is_excellent" :checked="old('is_excellent', false)" />
                                <flux:label>Calidad Excepcional (+25 AC bonus)</flux:label>
                                <flux:description>Marca esta opción si el trabajo es excepcional y merece bonificación
                                    adicional</flux:description>
                                <flux:error name="is_excellent" />
                            </flux:field>
                        </div>

                        <div class="p-4 bg-blue-500/10 rounded-lg border border-blue-500/20">
                            <h4 class="text-sm font-bold text-blue-500 mb-2">Bonificaciones Automáticas</h4>
                            <ul class="text-xs text-blue-500/80 space-y-1 list-disc list-inside">
                                <li>Calificación 10: +50 AC</li>
                                <li>Calificación 9-9.9: +30 AC</li>
                                <li>Calificación 8-8.9: +15 AC</li>
                                <li>Calidad excepcional: +25 AC (si marcas la opción)</li>
                                <li>Entrega anticipada: +10% del total</li>
                                <li>Entrega tardía: -20% del total</li>
                            </ul>
                        </div>

                        <div class="flex gap-3 justify-end">
                            <flux:button href="{{ route('teacher.tasks.submissions') }}" variant="ghost">
                                Cancelar
                            </flux:button>
                            <flux:button type="submit" variant="primary">
                                Calificar y Otorgar AC
                            </flux:button>
                        </div>
                    </form>
                </flux:card>
            </div>
        </div>
    </div>
</x-layouts::app>