<x-layouts::app title="Gestión de Docentes">
    <div class="container mx-auto py-6">
        <div class="mb-8 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                    <flux:icon icon="users" class="size-8 text-blue-600 dark:text-blue-400" />
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Gestión de Docentes</h1>
                    <p class="text-neutral-500 dark:text-neutral-400">Administra los profesores del sistema</p>
                </div>
            </div>
            <flux:button href="{{ route('admin.docentes.create') }}" icon="plus">
                Crear Docente
            </flux:button>
        </div>

        @if(session('success'))
            <div
                class="mb-6 p-4 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div
            class="bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800 overflow-hidden">
            <table class="w-full">
                <thead class="bg-neutral-50 dark:bg-neutral-800/50">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            <div class="flex items-center gap-2">
                                <flux:icon icon="user" class="size-3" />
                                Nombre
                            </div>
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            <div class="flex items-center gap-2">
                                <flux:icon icon="envelope" class="size-3" />
                                Email
                            </div>
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            <div class="flex items-center gap-2">
                                <flux:icon icon="identification" class="size-3" />
                                RFC
                            </div>
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            <div class="flex items-center gap-2">
                                <flux:icon icon="banknotes" class="size-3" />
                                Balance AC
                            </div>
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            <div class="flex items-center gap-2">
                                <flux:icon icon="calendar" class="size-3" />
                                Fecha Registro
                            </div>
                        </th>
                        <th
                            class="px-6 py-3 text-right text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200 dark:divide-neutral-800">
                    @forelse($docentes as $docente)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="h-10 w-10 shrink-0 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                        <span class="text-sm font-bold text-blue-600 dark:text-blue-400">
                                            {{ $docente->initials() }}
                                        </span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-neutral-900 dark:text-white">
                                            {{ $docente->name }}
                                        </div>
                                        <div class="text-xs text-neutral-500">
                                            {!! user_role_badge('docente') !!}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                                {{ $docente->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 py-1 text-xs font-mono rounded bg-neutral-100 text-neutral-700 dark:bg-neutral-800 dark:text-neutral-300">
                                    {{ $docente->rfc }}
                                </span>
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-emerald-600 dark:text-emerald-400">
                                ₳ {{ number_format($docente->wallet->balance ?? 0, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                                {{ $docente->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <flux:button href="{{ route('admin.docentes.edit', $docente) }}" variant="ghost" size="sm"
                                    icon="pencil">
                                    Editar
                                </flux:button>
                                <x-flux.confirm-delete-modal :name="'delete-docente-' . $docente->id"
                                    title="Eliminar docente"
                                    message="¿Estás seguro de eliminar este docente? Esta acción no se puede deshacer.">
                                    <x-slot:trigger>
                                        <flux:button type="button" variant="danger" size="sm" icon="trash">Eliminar
                                        </flux:button>
                                    </x-slot:trigger>
                                    <form action="{{ route('admin.docentes.destroy', $docente) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <flux:button type="submit" variant="danger" size="sm">Eliminar</flux:button>
                                    </form>
                                </x-flux.confirm-delete-modal>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-neutral-500">
                                <flux:icon icon="users" class="size-12 mx-auto mb-3 opacity-20" />
                                <p>No hay docentes registrados aún.</p>
                                <flux:button href="{{ route('admin.docentes.create') }}" variant="ghost" size="sm"
                                    class="mt-4">
                                    Crear el primer docente
                                </flux:button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($docentes->hasPages())
            <div class="mt-6">
                {{ $docentes->links() }}
            </div>
        @endif
    </div>
</x-layouts::app>