<x-layouts::app title="Entregar Tarea">
    <div class="container mx-auto py-6 max-w-3xl">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Entregar Tarea</h1>
            <p class="text-neutral-500 dark:text-neutral-400">{{ $task->title }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Información de la Tarea -->
            <div class="lg:col-span-1">
                <flux:card>
                    <h3 class="font-bold text-neutral-900 dark:text-white mb-4">Detalles de la Tarea</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">Dificultad</p>
                            <flux:badge @class([
                                'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' => $task->difficulty === 'basic',
                                'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300' => $task->difficulty === 'intermediate',
                                'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-300' => $task->difficulty === 'advanced',
                                'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300' => $task->difficulty === 'excellence',
                            ]) size="sm">
                                {{ ucfirst($task->difficulty) }}
                            </flux:badge>
                        </div>
                        <div>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">Recompensa Base</p>
                            <p class="font-bold text-emerald-600 dark:text-emerald-400">₳ {{ number_format($task->ac_reward, 2) }}</p>
                        </div>
                        @if($task->due_date)
                            <div>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">Fecha de Entrega</p>
                                <p class="text-sm font-medium text-neutral-900 dark:text-white">
                                    {{ $task->due_date->format('d/m/Y H:i') }}
                                </p>
                                @if(now()->gt($task->due_date))
                                    <p class="text-xs text-red-600 dark:text-red-400 mt-1">⚠️ Entrega tardía (-20% AC)</p>
                                @elseif(now()->lt($task->due_date->subDays(1)))
                                    <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-1">✓ Entrega anticipada (+10% AC)</p>
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
                        <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                            <p class="text-sm text-blue-800 dark:text-blue-200">
                                Ya tienes una entrega para esta tarea. Puedes subir un nuevo archivo para reemplazarla.
                            </p>
                        </div>
                    @endif

                    <form action="{{ route('tasks.submit.store', $task) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="space-y-2">
                            <flux:field>
                                <flux:label>Archivo de la Tarea *</flux:label>
                                <input 
                                    type="file" 
                                    name="file" 
                                    accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png"
                                    class="block w-full text-sm text-neutral-500 dark:text-neutral-400
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-lg file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-emerald-50 file:text-emerald-700
                                    hover:file:bg-emerald-100
                                    dark:file:bg-emerald-900/30 dark:file:text-emerald-300"
                                    required
                                />
                                <flux:description>Formatos permitidos: PDF, DOC, DOCX, TXT, JPG, PNG (máx. 10MB)</flux:description>
                                <flux:error name="file" />
                            </flux:field>
                        </div>

                        <div class="space-y-2">
                            <flux:field>
                                <flux:label>Notas Adicionales (opcional)</flux:label>
                                <flux:textarea name="notes" rows="4" placeholder="Agrega comentarios o notas sobre tu entrega...">{{ old('notes') }}</flux:textarea>
                                <flux:error name="notes" />
                            </flux:field>
                        </div>

                        <div class="p-4 bg-neutral-50 dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700">
                            <h4 class="text-sm font-bold text-neutral-900 dark:text-white mb-2">Recordatorio</h4>
                            <ul class="text-xs text-neutral-600 dark:text-neutral-300 space-y-1 list-disc list-inside">
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
