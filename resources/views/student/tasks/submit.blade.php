<x-layouts::app title="Entregar Tarea">
    <div class="container mx-auto py-6 max-w-3xl">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-neutral-dark dark:text-neutral-dark">Entregar Tarea</h1>
            <p class="text-neutral-medium dark:text-neutral-medium">{{ $task->title }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Información de la Tarea -->
            <div class="lg:col-span-1">
                <flux:card>
                    <h3 class="font-bold text-neutral-dark dark:text-neutral-dark mb-4">Detalles de la Tarea</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-neutral-medium dark:text-neutral-medium mb-1">Dificultad</p>
                            <flux:badge @class([
                                'bg-blue-500/10 text-blue-500' => $task->difficulty === 'basic',
                                'bg-emerald-500/10 text-emerald-500' => $task->difficulty === 'intermediate',
                                'bg-orange-500/10 text-orange-500' => $task->difficulty === 'advanced',
                                'bg-purple-500/10 text-purple-500' => $task->difficulty === 'excellence',
                            ]) size="sm">
                                {{ ucfirst($task->difficulty) }}
                            </flux:badge>
                        </div>
                        <div>
                            <p class="text-xs text-neutral-medium dark:text-neutral-medium mb-1">Recompensa Base</p>
                            <p class="font-bold text-emerald-500">₳ {{ number_format($task->ac_reward, 2) }}</p>
                        </div>
                        @if($task->due_date)
                            <div>
                                <p class="text-xs text-neutral-medium dark:text-neutral-medium mb-1">Fecha de Entrega</p>
                                <p class="text-sm font-medium text-neutral-dark dark:text-neutral-dark">
                                    {{ $task->due_date->format('d/m/Y H:i') }}
                                </p>
                                @if(now()->gt($task->due_date))
                                    <p class="text-xs text-orange-500 mt-1">⚠️ Entrega tardía (-20% AC)</p>
                                @elseif(now()->lt($task->due_date->subDays(1)))
                                    <p class="text-xs text-emerald-500 mt-1">✓ Entrega anticipada (+10% AC)</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </flux:card>
            </div>

            <!-- Formulario de Entrega -->
            <div class="lg:col-span-2">
                <flux:card>
                    @if($submission)
                        <div class="mb-6 p-4 bg-blue-500/10 rounded-lg border border-blue-500/20">
                            <p class="text-sm text-blue-500">
                                Ya tienes una entrega para esta tarea. Puedes subir un nuevo archivo para reemplazarla.
                            </p>
                        </div>
                    @endif

                    <form action="{{ route('tasks.submit.store', $task) }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf

                        <div class="space-y-2">
                            <flux:field>
                                <flux:label>Archivo de la Tarea *</flux:label>
                                <input type="file" name="file" accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png" class="block w-full text-sm text-neutral-medium
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-lg file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-emerald-500/10 file:text-emerald-500
                                    hover:file:bg-emerald-500/20" required />
                                <flux:description>Formatos permitidos: PDF, DOC, DOCX, TXT, JPG, PNG (máx. 10MB)
                                </flux:description>
                                <flux:error name="file" />
                            </flux:field>
                        </div>

                        <div class="space-y-2">
                            <flux:field>
                                <flux:label>Notas Adicionales (opcional)</flux:label>
                                <flux:textarea name="notes" rows="4"
                                    placeholder="Agrega comentarios o notas sobre tu entrega...">{{ old('notes') }}
                                </flux:textarea>
                                <flux:error name="notes" />
                            </flux:field>
                        </div>

                        <div
                            class="p-4 bg-white dark:bg-neutral-dark rounded-xl border border-neutral-light dark:border-neutral-light">
                            <h4 class="text-sm font-bold text-neutral-dark dark:text-neutral-dark mb-2">Recordatorio
                            </h4>
                            <ul class="text-xs text-neutral-medium space-y-1 list-disc list-inside">
                                <li>Una vez entregada, tu profesor la revisará y calificará</li>
                                <li>Recibirás AulaChain según tu calificación y la dificultad de la tarea</li>
                                <li>Las entregas anticipadas reciben +10% de bonificación</li>
                                <li>Las entregas tardías reciben -20% de penalización</li>
                            </ul>
                        </div>

                        <div class="flex gap-3 justify-end">
                            <flux:button href="{{ route('tasks') }}" variant="ghost">
                                Cancelar
                            </flux:button>
                            <flux:button type="submit" variant="primary">
                                Entregar Tarea
                            </flux:button>
                        </div>
                    </form>
                </flux:card>
            </div>
        </div>
    </div>
</x-layouts::app>