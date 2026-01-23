<x-layouts::app title="Unirse a una Clase">
    <div class="container mx-auto py-6 max-w-3xl">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Mis Clases</h1>
            <p class="text-neutral-500 dark:text-neutral-400">Únete a clases usando el código que te proporcionó tu profesor</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-lg">
                <p class="text-emerald-800 dark:text-emerald-200">{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                @foreach($errors->all() as $error)
                    <p class="text-red-800 dark:text-red-200">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Formulario para unirse -->
        <flux:card class="mb-6">
            <div class="mb-4">
                <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">Unirse a una Nueva Clase</h2>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">Ingresa el código de 8 caracteres que te proporcionó tu profesor</p>
            </div>

            <form action="{{ route('groups.join.store') }}" method="POST" class="space-y-4">
                @csrf

                <div class="space-y-2">
                    <flux:field>
                        <flux:label>Código de la Clase</flux:label>
                        <flux:input 
                            name="code" 
                            value="{{ old('code') }}" 
                            placeholder="ABCD1234" 
                            maxlength="8"
                            class="text-center text-2xl font-mono tracking-widest uppercase"
                            required 
                        />
                        <flux:error name="code" />
                        <flux:description>El código debe tener exactamente 8 caracteres</flux:description>
                    </flux:field>
                </div>

                <flux:button type="submit" variant="primary" class="w-full">
                    Unirse a la Clase
                </flux:button>
            </form>
        </flux:card>

        <!-- Mis Clases -->
        <div>
            <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">Clases en las que estoy inscrito ({{ $myGroups->count() }})</h2>

            @if($myGroups->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($myGroups as $group)
                        <flux:card class="flex flex-col">
                            <div class="flex-1 space-y-3">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h3 class="text-lg font-bold text-neutral-900 dark:text-white">{{ $group->name }}</h3>
                                        @if($group->subject)
                                            <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ $group->subject }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex items-center gap-4 text-sm text-neutral-500 dark:text-neutral-400">
                                    <div class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                        <span>{{ $group->teacher->name }}</span>
                                    </div>
                                </div>

                                <div class="p-2 bg-neutral-50 dark:bg-neutral-800 rounded border border-neutral-200 dark:border-neutral-700">
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">Código:</p>
                                    <code class="text-sm font-mono font-bold text-emerald-600 dark:text-emerald-400">{{ $group->code }}</code>
                                </div>
                            </div>

                            <div class="mt-4 pt-4 border-t border-neutral-200 dark:border-neutral-700">
                                <form action="{{ route('groups.leave', $group) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <flux:button type="submit" variant="ghost" size="sm" class="w-full" wire:confirm="¿Estás seguro de salir de esta clase?">
                                        Salir de la Clase
                                    </flux:button>
                                </form>
                            </div>
                        </flux:card>
                    @endforeach
                </div>
            @else
                <flux:card>
                    <div class="py-12 text-center text-neutral-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 mx-auto mb-3 opacity-20">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                        <p class="font-medium">Aún no estás inscrito en ninguna clase</p>
                        <p class="text-xs mt-1">Usa el formulario de arriba para unirte a una clase con el código que te proporcionó tu profesor</p>
                    </div>
                </flux:card>
            @endif
        </div>
    </div>
</x-layouts::app>
