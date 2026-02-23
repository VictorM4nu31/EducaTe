<x-layouts::app title="Detalle de Docente">
    <div class="container mx-auto py-6">
        <!-- Encabezado -->
        <div class="mb-8 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <flux:button href="{{ route('admin.teachers.index') }}" variant="ghost" icon="chevron-left" circular />
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Perfil del Docente</h1>
                    <p class="text-neutral-500 dark:text-neutral-400">Información detallada y estadísticas</p>
                </div>
            </div>
            <div class="flex gap-2">
                <flux:button href="{{ route('admin.teachers.edit', $docente) }}" variant="ghost" icon="pencil">
                    Editar
                </flux:button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Tarjeta Lateral: Perfil -->
            <div class="lg:col-span-1 space-y-6">
                <div
                    class="bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800 p-6 text-center">
                    <div
                        class="mx-auto h-24 w-24 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mb-4">
                        <span class="text-3xl font-bold text-blue-600 dark:text-blue-400">
                            {{ $docente->initials() }}
                        </span>
                    </div>
                    <h2 class="text-xl font-bold text-neutral-900 dark:text-white">{{ $docente->name }}</h2>
                    <p class="text-sm text-neutral-500 mb-4">{{ $docente->email }}</p>
                    <div class="flex justify-center">
                        {!! user_role_badge('docente') !!}
                    </div>

                    <div class="mt-6 pt-6 border-t border-neutral-100 dark:border-neutral-800 grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-neutral-500 uppercase tracking-wider mb-1">Balance</p>
                            <p class="text-lg font-bold text-emerald-600 dark:text-emerald-400">
                                ₳ {{ number_format($docente->wallet->balance ?? 0, 2) }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-neutral-500 uppercase tracking-wider mb-1">Miembro desde</p>
                            <p class="text-sm font-medium text-neutral-900 dark:text-white">
                                {{ $docente->created_at->format('M Y') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800 p-6">
                    <h3 class="font-bold text-neutral-900 dark:text-white mb-4">Datos Fiscales</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-neutral-500 uppercase tracking-wider">RFC</p>
                            <p class="text-sm font-mono text-neutral-900 dark:text-white">{{ $docente->rfc }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenido Principal -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Grupos / Clases -->
                <div
                    class="bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800 overflow-hidden">
                    <div
                        class="px-6 py-4 border-b border-neutral-100 dark:border-neutral-800 flex items-center justify-between">
                        <h3 class="font-bold text-neutral-900 dark:text-white">Clases Asignadas</h3>
                        <span
                            class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                            {{ $docente->taughtGroups->count() }} Grupos
                        </span>
                    </div>
                    <div class="divide-y divide-neutral-100 dark:divide-neutral-800">
                        @forelse($docente->taughtGroups as $group)
                            <div
                                class="px-6 py-4 flex items-center justify-between hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition-colors">
                                <div class="flex items-center gap-4">
                                    <div class="p-2 bg-neutral-100 dark:bg-neutral-800 rounded-lg">
                                        <flux:icon icon="academic-cap" class="size-5 text-neutral-500" />
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-neutral-900 dark:text-white">{{ $group->name }}
                                        </h4>
                                        <p class="text-xs text-neutral-500">{{ $group->subject }} • {{ $group->grade }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-neutral-900 dark:text-white">
                                            {{ $group->students_count }}
                                        </p>
                                        <p class="text-xs text-neutral-500">Estudiantes</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-12 text-center">
                                <flux:icon icon="academic-cap" class="size-12 mx-auto mb-3 opacity-20 text-neutral-500" />
                                <p class="text-neutral-500">Este docente aún no tiene grupos creados.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layouts::app>