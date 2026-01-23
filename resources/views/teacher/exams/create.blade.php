<x-layouts::app title="Crear Examen">
    <div class="container mx-auto py-6 max-w-2xl">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Crear Nuevo Examen</h1>
            <p class="text-neutral-500 dark:text-neutral-400">Crea un examen digital con preguntas y respuestas</p>
        </div>

        <flux:card>
            <form action="{{ route('teacher.exams.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <flux:field>
                        <flux:label>Título del Examen *</flux:label>
                        <flux:input name="title" value="{{ old('title') }}" placeholder="Ej: Examen de Matemáticas - Unidad 3" required />
                        <flux:error name="title" />
                    </flux:field>
                </div>

                <div class="space-y-2">
                    <flux:field>
                        <flux:label>Descripción</flux:label>
                        <flux:textarea name="description" rows="3" placeholder="Descripción del examen...">{{ old('description') }}</flux:textarea>
                        <flux:error name="description" />
                    </flux:field>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <flux:field>
                            <flux:label>Bonificación Base (₳) *</flux:label>
                            <flux:input name="ac_reward_bonus" type="number" step="0.01" min="0" value="{{ old('ac_reward_bonus', 30) }}" required />
                            <flux:description>AC otorgados si no usa pistas</flux:description>
                            <flux:error name="ac_reward_bonus" />
                        </flux:field>
                    </div>

                    <div class="space-y-2">
                        <flux:field>
                            <flux:label>Tiempo Límite (minutos)</flux:label>
                            <flux:input name="time_limit" type="number" min="1" value="{{ old('time_limit') }}" placeholder="Opcional" />
                            <flux:description>Dejar vacío para sin límite</flux:description>
                            <flux:error name="time_limit" />
                        </flux:field>
                    </div>
                </div>

                @if($groups->count() > 0)
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Asignar a Clases</label>
                        <div class="space-y-2">
                            @foreach($groups as $group)
                                <label class="flex items-center gap-2 p-2 rounded-lg hover:bg-neutral-50 dark:hover:bg-neutral-800 cursor-pointer">
                                    <input type="checkbox" name="groups[]" value="{{ $group->id }}" class="rounded border-neutral-300">
                                    <div class="flex-1">
                                        <span class="font-medium text-neutral-900 dark:text-white">{{ $group->name }}</span>
                                        @if($group->subject)
                                            <span class="text-xs text-neutral-500 dark:text-neutral-400 ml-2">{{ $group->subject }}</span>
                                        @endif
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                    <p class="text-sm text-blue-800 dark:text-blue-200">
                        <strong>Nota:</strong> Después de crear el examen, podrás agregar las preguntas desde la página de gestión del examen.
                    </p>
                </div>

                <div class="flex gap-3 justify-end">
                    <flux:button href="{{ route('teacher.exams.index') }}" variant="ghost">
                        Cancelar
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        Crear Examen
                    </flux:button>
                </div>
            </form>
        </flux:card>
    </div>
</x-layouts::app>
