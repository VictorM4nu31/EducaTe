<x-layouts::app title="Editar Examen">
    <div class="container mx-auto py-6 max-w-2xl">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Editar Examen</h1>
            <p class="text-neutral-500 dark:text-neutral-400">Modifica la información del examen</p>
        </div>

        <flux:card>
            <form action="{{ route('teacher.exams.update', $exam) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="space-y-2">
                    <flux:field>
                        <flux:label>Título del Examen *</flux:label>
                        <flux:input name="title" value="{{ old('title', $exam->title) }}" placeholder="Ej: Examen de Matemáticas - Unidad 3" required />
                        <flux:error name="title" />
                    </flux:field>
                </div>

                <div class="space-y-2">
                    <flux:field>
                        <flux:label>Descripción</flux:label>
                        <flux:textarea name="description" rows="3" placeholder="Descripción del examen...">{{ old('description', $exam->description) }}</flux:textarea>
                        <flux:error name="description" />
                    </flux:field>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <flux:field>
                            <flux:label>Bonificación Base (₳) *</flux:label>
                            <flux:input name="ac_reward_bonus" type="number" step="0.01" min="0" value="{{ old('ac_reward_bonus', $exam->ac_reward_bonus) }}" required />
                            <flux:description>AC otorgados si no usa pistas</flux:description>
                            <flux:error name="ac_reward_bonus" />
                        </flux:field>
                    </div>

                    <div class="space-y-2">
                        <flux:field>
                            <flux:label>Tiempo Límite (minutos)</flux:label>
                            <flux:input name="time_limit" type="number" min="1" value="{{ old('time_limit', $exam->time_limit) }}" placeholder="Opcional" />
                            <flux:description>Dejar vacío para sin límite</flux:description>
                            <flux:error name="time_limit" />
                        </flux:field>
                    </div>
                </div>

                <div class="space-y-2">
                    <flux:field>
                        <flux:checkbox name="is_active" :checked="old('is_active', $exam->is_active)" />
                        <flux:label>Examen activo</flux:label>
                        <flux:error name="is_active" />
                    </flux:field>
                </div>

                <div class="flex gap-3 justify-end">
                    <flux:button href="{{ route('teacher.exams.show', $exam) }}" variant="ghost">
                        Cancelar
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        Guardar Cambios
                    </flux:button>
                </div>
            </form>
        </flux:card>
    </div>
</x-layouts::app>
