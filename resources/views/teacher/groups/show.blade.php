<x-layouts::app title="{{ $group->name }}">
    <div class="container mx-auto py-6">
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">{{ $group->name }}</h1>
                    @if($group->subject)
                        <p class="text-neutral-500 dark:text-neutral-400">{{ $group->subject }} @if($group->grade) •
                        {{ $group->grade }} @endif
                        </p>
                    @endif
                </div>
                <div class="flex gap-2">
                    <flux:button href="{{ route('teacher.groups.edit', $group) }}" variant="ghost" icon="pencil-square">
                        Editar
                    </flux:button>
                </div>
            </div>

            @if(session('success'))
                <div
                    class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-lg">
                    <p class="text-emerald-800 dark:text-emerald-200">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Código de la Clase -->
            <div
                class="mb-6 p-6 bg-linear-to-r from-emerald-50 to-blue-50 dark:from-emerald-900/20 dark:to-blue-900/20 rounded-xl border border-emerald-200 dark:border-emerald-800">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 sm:gap-4">
                    <div class="w-full sm:w-auto text-center sm:text-left">
                        <p class="text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Código de la Clase
                        </p>
                        <code
                            class="text-4xl sm:text-3xl font-mono font-bold text-emerald-600 dark:text-emerald-400 block sm:inline">{{ $group->code }}</code>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-2">Comparte este código con tus
                            estudiantes para que se unan</p>
                    </div>
                    <div class="flex flex-wrap sm:flex-nowrap gap-2 justify-center sm:justify-end w-full sm:w-auto">
                        <flux:button onclick="navigator.clipboard.writeText('{{ $group->code }}')" variant="primary"
                            icon="clipboard-document" size="sm" class="flex-1 sm:flex-none">
                            Copiar
                        </flux:button>
                        <form action="{{ route('teacher.groups.regenerate-code', $group) }}" method="POST"
                            class="flex-1 sm:flex-none">
                            @csrf
                            <flux:button type="submit" variant="ghost" size="sm" class="w-full">
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
                <h2 class="text-xl font-bold text-neutral-900 dark:text-white">Estudiantes
                    ({{ $group->students->count() }})</h2>
            </div>

            @if($group->students->count() > 0)
                <div class="overflow-x-auto -mx-6 px-6 pb-1">
                    <flux:table class="min-w-[500px] sm:min-w-full">
                        <flux:table.columns>
                            <flux:table.column>Estudiante</flux:table.column>
                            <flux:table.column class="hidden sm:table-cell">RFC</flux:table.column>
                            <flux:table.column>Balance</flux:table.column>
                            <flux:table.column class="hidden md:table-cell">Se unió</flux:table.column>
                            <flux:table.column></flux:table.column>
                        </flux:table.columns>

                        <flux:table.rows>
                            @foreach($group->students as $student)
                                <flux:table.row>
                                    <flux:table.cell>
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="h-10 w-10 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 font-bold">
                                                {{ $student->initials() }}
                                            </div>
                                            <span
                                                class="font-medium text-neutral-900 dark:text-white">{{ $student->name }}</span>
                                        </div>
                                    </flux:table.cell>

                                    <flux:table.cell class="hidden sm:table-cell">
                                        <code
                                            class="text-sm font-mono text-neutral-600 dark:text-neutral-400">{{ $student->rfc }}</code>
                                    </flux:table.cell>

                                    <flux:table.cell>
                                        <span class="font-mono font-bold text-emerald-600 dark:text-emerald-400 text-sm">
                                            ₳ {{ number_format($student->wallet->balance ?? 0, 0) }}
                                        </span>
                                    </flux:table.cell>

                                    <flux:table.cell class="hidden md:table-cell">
                                        <span class="text-sm text-neutral-500 dark:text-neutral-400">
                                            {{ \Carbon\Carbon::parse($student->pivot->joined_at)->diffForHumans() }}
                                        </span>
                                    </flux:table.cell>

                                    <flux:table.cell>
                                        <form action="{{ route('teacher.groups.remove-student', [$group, $student]) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <flux:button type="submit" variant="ghost" size="sm" icon="trash"
                                                wire:confirm="¿Remover a {{ $student->name }} de la clase?">
                                                Remover
                                            </flux:button>
                                        </form>
                                    </flux:table.cell>
                                </flux:table.row>
                            @endforeach
                        </flux:table.rows>
                    </flux:table>
                </div>
            @else
                <div class="py-12 text-center text-neutral-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-12 mx-auto mb-3 opacity-20">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                    <p class="font-medium">Aún no hay estudiantes en esta clase</p>
                    <p class="text-xs mt-1">Comparte el código de la clase para que los estudiantes se unan</p>
                </div>
            @endif
        </flux:card>
    </div>
</x-layouts::app>