<x-layouts::app title="{{ $group->name }}">
    <div class="container mx-auto py-6">
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">{{ $group->name }}</h1>
                    @if($group->subject)
                        <p class="text-neutral-500 dark:text-neutral-400">{{ $group->subject }} @if($group->grade) • {{ $group->grade }} @endif</p>
                    @endif
                </div>
                <div class="flex gap-2">
                    <flux:button href="{{ route('teacher.groups.edit', $group) }}" variant="ghost" icon="pencil-square">
                        Editar
                    </flux:button>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-lg">
                    <p class="text-emerald-800 dark:text-emerald-200">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Código de la Clase -->
            <div class="mb-6 p-6 bg-gradient-to-r from-emerald-50 to-blue-50 dark:from-emerald-900/20 dark:to-blue-900/20 rounded-xl border border-emerald-200 dark:border-emerald-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Código de la Clase</p>
                        <code class="text-3xl font-mono font-bold text-emerald-600 dark:text-emerald-400">{{ $group->code }}</code>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-2">Comparte este código con tus estudiantes para que se unan</p>
                    </div>
                    <div class="flex gap-2">
                        <button 
                            onclick="navigator.clipboard.writeText('{{ $group->code }}')"
                            class="px-4 py-2 bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 rounded-lg hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-colors flex items-center gap-2"
                            title="Copiar código">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                            </svg>
                            Copiar
                        </button>
                        <form action="{{ route('teacher.groups.regenerate-code', $group) }}" method="POST" class="inline">
                            @csrf
                            <flux:button type="submit" variant="ghost" size="sm">
                                Regenerar
                            </flux:button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de Estudiantes -->
        <flux:card>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-neutral-900 dark:text-white">Estudiantes ({{ $group->students->count() }})</h2>
            </div>

            @if($group->students->count() > 0)
                <flux:table>
                    <flux:table.columns>
                        <flux:table.column>Estudiante</flux:table.column>
                        <flux:table.column>RFC</flux:table.column>
                        <flux:table.column>Balance AC</flux:table.column>
                        <flux:table.column>Se unió</flux:table.column>
                        <flux:table.column></flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @foreach($group->students as $student)
                            <flux:table.row>
                                <flux:table.cell>
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 font-bold">
                                            {{ $student->initials() }}
                                        </div>
                                        <span class="font-medium text-neutral-900 dark:text-white">{{ $student->name }}</span>
                                    </div>
                                </flux:table.cell>

                                <flux:table.cell>
                                    <code class="text-sm font-mono text-neutral-600 dark:text-neutral-400">{{ $student->rfc }}</code>
                                </flux:table.cell>

                                <flux:table.cell>
                                    <span class="font-mono font-bold text-emerald-600 dark:text-emerald-400">
                                        ₳ {{ number_format($student->wallet->balance ?? 0, 2) }}
                                    </span>
                                </flux:table.cell>

                                <flux:table.cell>
                                    <span class="text-sm text-neutral-500 dark:text-neutral-400">
                                        {{ $student->pivot->joined_at->diffForHumans() }}
                                    </span>
                                </flux:table.cell>

                                <flux:table.cell>
                                    <form action="{{ route('teacher.groups.remove-student', [$group, $student]) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <flux:button type="submit" variant="ghost" size="sm" icon="trash" wire:confirm="¿Remover a {{ $student->name }} de la clase?">
                                            Remover
                                        </flux:button>
                                    </form>
                                </flux:table.cell>
                            </flux:table.row>
                        @endforeach
                    </flux:table.rows>
                </flux:table>
            @else
                <div class="py-12 text-center text-neutral-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 mx-auto mb-3 opacity-20">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                    <p class="font-medium">Aún no hay estudiantes en esta clase</p>
                    <p class="text-xs mt-1">Comparte el código de la clase para que los estudiantes se unan</p>
                </div>
            @endif
        </flux:card>
    </div>
</x-layouts::app>
