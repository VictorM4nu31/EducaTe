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
                    <x-flux.confirm-delete-modal
                        :name="'delete-regulation-'.$regulation->id"
                        title="Eliminar reglamento"
                        message="¿Estás seguro de eliminar este reglamento? Esta acción no se puede deshacer."
                    >
                        <x-slot:trigger>
                            <flux:button variant="danger" outline type="button">Eliminar</flux:button>
                        </x-slot:trigger>
                        <form action="{{ route('resources.regulations.destroy', $regulation) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <flux:button variant="danger" type="submit">Eliminar</flux:button>
                        </form>
                    </x-flux.confirm-delete-modal>

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
