<x-layouts::app title="Editar Reglamento">
    <div class="container mx-auto py-6 max-w-3xl">
        <flux:button href="{{ route('resources.regulations.index') }}" variant="ghost" icon="arrow-left" class="mb-6">
            Cancelar edición
        </flux:button>

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-academic-purple">Editar Publicación</h1>
            <p class="text-neutral-medium mt-1">Actualiza los términos y condiciones de la convivencia escolar.</p>
        </div>

        <flux:card>
            <form action="{{ route('resources.regulations.update', $regulation) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <flux:input 
                    name="title" 
                    label="Título de la publicación" 
                    :value="$regulation->title"
                    required 
                />

                <flux:textarea 
                    name="content" 
                    label="Contenido del Reglamento" 
                    rows="15"
                    required
                >{{ $regulation->content }}</flux:textarea>

                <flux:checkbox name="is_active" label="Publicación activa (visible para todos)" :checked="$regulation->is_active" />

                <div class="flex justify-between gap-3 pt-4 border-t border-neutral-light dark:border-neutral-light/10">
                    <form action="{{ route('resources.regulations.destroy', $regulation) }}" method="POST" id="delete-form-{{ $regulation->id }}">
                        @csrf
                        @method('DELETE')
                        <flux:button variant="danger" type="submit" outline onclick="return confirm('¿Estás seguro de eliminar este reglamento?')">Eliminar</flux:button>
                    </form>
                    
                    <div class="flex gap-3">
                        <flux:button href="{{ route('resources.regulations.index') }}" variant="ghost">Cancelar</flux:button>
                        <flux:button type="submit" variant="primary" class="bg-academic-purple hover:bg-academic-purple-hover border-none font-bold">
                            Guardar Cambios
                        </flux:button>
                    </div>
                </div>
            </form>
        </flux:card>
    </div>
</x-layouts::app>
