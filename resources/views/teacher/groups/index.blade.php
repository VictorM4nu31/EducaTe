<x-layouts::app title="Mis Clases">
    <div class="container mx-auto py-6">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Mis Clases</h1>
                <p class="text-neutral-500 dark:text-neutral-400">Gestiona las clases que has creado</p>
            </div>
            <flux:button href="{{ route('teacher.groups.create') }}" icon="plus">
                Nueva Clase
            </flux:button>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-lg">
                <p class="text-emerald-800 dark:text-emerald-200">{{ session('success') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($groups as $group)
                <flux:card class="flex flex-col">
                    <div class="flex-1 space-y-4">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-neutral-900 dark:text-white">{{ $group->name }}</h3>
                                @if($group->subject)
                                    <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ $group->subject }}</p>
                                @endif
                            </div>
                            @if($group->is_active)
                                <flux:badge variant="success" size="sm">Activa</flux:badge>
                            @else
                                <flux:badge variant="danger" size="sm">Inactiva</flux:badge>
                            @endif
                        </div>

                        @if($group->description)
                            <p class="text-sm text-neutral-600 dark:text-neutral-300 line-clamp-2">{{ $group->description }}</p>
                        @endif

                        <div class="flex items-center gap-4 text-sm text-neutral-500 dark:text-neutral-400">
                            <div class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>
                                <span>{{ $group->students_count }} estudiantes</span>
                            </div>
                            @if($group->grade)
                                <div class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.905 59.905 0 0 1 12 3.493a59.902 59.902 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443a55.381 55.381 0 0 1 5.25 2.882v3.675M6.75 15H18m-11.25-4.5h.008v.008H6.75V10.5Zm0 0h3.375M18 15v-2.25m0 0h.008v.008H18V12.75Zm-3.75 0v-.008h.008V12.75h-.008Z" />
                                    </svg>
                                    <span>{{ $group->grade }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="p-3 bg-neutral-50 dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700">
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">Código de la clase:</p>
                            <div class="flex items-center justify-between">
                                <code class="text-lg font-mono font-bold text-emerald-600 dark:text-emerald-400">{{ $group->code }}</code>
                                <button 
                                    onclick="navigator.clipboard.writeText('{{ $group->code }}')"
                                    class="p-1 hover:bg-neutral-200 dark:hover:bg-neutral-700 rounded transition-colors"
                                    title="Copiar código">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-neutral-200 dark:border-neutral-700 flex gap-2">
                        <flux:button href="{{ route('teacher.groups.show', $group) }}" variant="primary" size="sm" class="flex-1">
                            Ver Clase
                        </flux:button>
                        <flux:button href="{{ route('teacher.groups.edit', $group) }}" variant="ghost" size="sm" icon="pencil-square" />
                    </div>
                </flux:card>
            @empty
                <div class="col-span-full py-12 text-center text-neutral-500 bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 mx-auto mb-3 opacity-20">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                    <p class="font-medium">No has creado ninguna clase aún</p>
                    <p class="text-xs mt-1">Crea tu primera clase para comenzar a gestionar estudiantes</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layouts::app>
