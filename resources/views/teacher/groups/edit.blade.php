<x-layouts::app title="Editar Clase">
    <div class="container mx-auto py-6 max-w-2xl">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Editar Clase</h1>
            <p class="text-neutral-500 dark:text-neutral-400">Modifica la información de la clase</p>
        </div>

        <flux:card>
            <form action="{{ route('teacher.groups.update', $group) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="space-y-2">
                    <flux:field>
                        <flux:label>Nombre de la Clase *</flux:label>
                        <flux:input name="name" value="{{ old('name', $group->name) }}" placeholder="Ej: Matemáticas 2°A" required />
                        <flux:error name="name" />
                    </flux:field>
                </div>

                <div class="space-y-2">
                    <flux:field>
                        <flux:label>Descripción</flux:label>
                        <flux:textarea name="description" rows="3" placeholder="Descripción opcional de la clase...">{{ old('description', $group->description) }}</flux:textarea>
                        <flux:error name="description" />
                    </flux:field>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <flux:field>
                            <flux:label>Materia/Asignatura</flux:label>
                            <flux:input name="subject" value="{{ old('subject', $group->subject) }}" placeholder="Ej: Matemáticas" />
                            <flux:error name="subject" />
                        </flux:field>
                    </div>

                    <div class="space-y-2">
                        <flux:field>
                            <flux:label>Grado</flux:label>
                            <flux:input name="grade" value="{{ old('grade', $group->grade) }}" placeholder="Ej: 2° Secundaria" />
                            <flux:error name="grade" />
                        </flux:field>
                    </div>
                </div>

                <div class="space-y-2">
                    <flux:field>
                        <flux:checkbox name="is_active" :checked="old('is_active', $group->is_active)" />
                        <flux:label>Clase activa</flux:label>
                        <flux:error name="is_active" />
                    </flux:field>
                </div>

                <div class="flex gap-3 justify-end">
                    <flux:button href="{{ route('teacher.groups.show', $group) }}" variant="ghost">
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
