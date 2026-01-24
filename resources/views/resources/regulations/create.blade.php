<x-layouts::app title="Nueva Publicación - Reglamento">
    <div class="container mx-auto py-6 max-w-3xl">
        <flux:button href="{{ route('resources.regulations.index') }}" variant="ghost" icon="arrow-left" class="mb-6">
            Volver al listado
        </flux:button>

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-academic-purple">Nueva Publicación</h1>
            <p class="text-neutral-medium mt-1">Escribe las normativas que se mostrarán para todos los estudiantes y docentes.</p>
        </div>

        <flux:card>
            <form action="{{ route('resources.regulations.store') }}" method="POST" class="space-y-6">
                @csrf
                <flux:input 
                    name="title" 
                    label="Título de la publicación" 
                    placeholder="Ej. Normativa de Convivencia Escolar 2026" 
                    required 
                    autofocus
                />

                <flux:textarea 
                    name="content" 
                    label="Contenido del Reglamento" 
                    placeholder="Escribe aquí el contenido detallado..." 
                    rows="15"
                    required
                />

                <div class="flex justify-end gap-3 pt-4 border-t border-neutral-light dark:border-neutral-light/10">
                    <flux:button href="{{ route('resources.regulations.index') }}" variant="ghost">Cancelar</flux:button>
                    <flux:button type="submit" variant="primary" class="bg-academic-purple hover:bg-academic-purple-hover border-none font-bold">
                        Publicar Reglamento
                    </flux:button>
                </div>
            </form>
        </flux:card>
    </div>
</x-layouts::app>
