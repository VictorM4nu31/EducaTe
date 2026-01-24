<x-layouts::app title="Reglamento del Aula">
    <div class="container mx-auto py-6 max-w-5xl">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-academic-purple">Reglamento del Aula</h1>
                <p class="text-neutral-medium mt-1">Normativas oficiales de la secundaria para la convivencia y el aprendizaje.</p>
            </div>
            @role('admin')
                <flux:button href="{{ route('resources.regulations.create') }}" variant="primary" icon="plus" class="bg-academic-purple hover:bg-academic-purple-hover active:bg-academic-purple border-none">
                    Nueva Publicación
                </flux:button>
            @endrole
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-aulachain-green/10 border border-aulachain-green/20 rounded-lg text-aulachain-green-active font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-6">
            @forelse($regulations as $regulation)
                <flux:card class="relative overflow-hidden group">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-neutral-dark">{{ $regulation->title }}</h2>
                            <p class="text-xs text-neutral-medium mt-1">
                                Publicado el {{ $regulation->created_at->format('d/m/Y') }} por {{ $regulation->user->name }}
                            </p>
                        </div>
                        @role('admin')
                            <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <flux:button variant="ghost" size="sm" icon="pencil-square" href="{{ route('resources.regulations.edit', $regulation) }}" />
                            </div>
                        @endrole
                    </div>

                    <div class="prose dark:prose-invert max-w-none text-neutral-medium leading-relaxed">
                        {!! nl2br(e($regulation->content)) !!}
                    </div>
                </flux:card>
            @empty
                <div class="py-20 text-center bg-neutral-very-light dark:bg-neutral-light/5 rounded-3xl border-2 border-dashed border-neutral-light">
                    <flux:icon icon="document-text" class="size-16 mx-auto mb-4 text-neutral-medium opacity-20" />
                    <h3 class="text-xl font-bold text-neutral-dark">No hay reglamentos publicados</h3>
                    <p class="text-neutral-medium mt-2">El administrador aún no ha publicado las normativas del aula.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layouts::app>
