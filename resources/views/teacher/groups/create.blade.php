<x-layouts::app title="Crear Nueva Clase">
    <div class="container mx-auto py-6 max-w-2xl">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Crear Nueva Clase</h1>
            <p class="text-neutral-500 dark:text-neutral-400">Crea una clase y comparte el código con tus estudiantes</p>
        </div>

        <flux:card>
            <form action="{{ route('teacher.groups.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <flux:field>
                        <flux:label>Nombre de la Clase *</flux:label>
                        <flux:input name="name" value="{{ old('name') }}" placeholder="Ej: Matemáticas 2°A" required />
                        <flux:error name="name" />
                    </flux:field>
                </div>

                <div class="space-y-2">
                    <flux:field>
                        <flux:label>Descripción</flux:label>
                        <flux:textarea name="description" rows="3" placeholder="Descripción opcional de la clase...">{{ old('description') }}</flux:textarea>
                        <flux:error name="description" />
                    </flux:field>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <flux:field>
                            <flux:label>Materia/Asignatura</flux:label>
                            <flux:input name="subject" value="{{ old('subject') }}" placeholder="Ej: Matemáticas" />
                            <flux:error name="subject" />
                        </flux:field>
                    </div>

                    <div class="space-y-2">
                        <flux:field>
                            <flux:label>Grado</flux:label>
                            <flux:input name="grade" value="{{ old('grade') }}" placeholder="Ej: 2° Secundaria" />
                            <flux:error name="grade" />
                        </flux:field>
                    </div>
                </div>

                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                    <div class="flex gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-blue-600 dark:text-blue-400 shrink-0 mt-0.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-blue-900 dark:text-blue-200">Código de Clase</p>
                            <p class="text-xs text-blue-700 dark:text-blue-300 mt-1">
                                Se generará automáticamente un código único de 8 caracteres que tus estudiantes usarán para unirse a la clase.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 justify-end">
                    <flux:button href="{{ route('teacher.groups.index') }}" variant="ghost">
                        Cancelar
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        Crear Clase
                    </flux:button>
                </div>
            </form>
        </flux:card>
    </div>
</x-layouts::app>
