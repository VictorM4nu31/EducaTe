<x-layouts::app title="Gestión de Recompensas">
    <div class="container mx-auto py-6">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Recompensas del Marketplace</h1>
                <p class="text-neutral-500 dark:text-neutral-400">Administra los artículos disponibles para canje</p>
            </div>
            <flux:button href="{{ route('teacher.rewards.create') }}" icon="plus">
                Nueva Recompensa
            </flux:button>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-lg">
                <p class="text-emerald-800 dark:text-emerald-200">{{ session('success') }}</p>
            </div>
        @endif

        <flux:card>
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>Recompensa</flux:table.column>
                    <flux:table.column>Categoría</flux:table.column>
                    <flux:table.column>Costo</flux:table.column>
                    <flux:table.column>Stock</flux:table.column>
                    <flux:table.column></flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @forelse($rewards as $reward)
                        <flux:table.row>
                            <flux:table.cell>
                                <div>
                                    <span class="font-bold text-neutral-900 dark:text-white">{{ $reward->name }}</span>
                                    @if($reward->description)
                                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1 line-clamp-1">{{ $reward->description }}</p>
                                    @endif
                                </div>
                            </flux:table.cell>

                            <flux:table.cell>
                                <flux:badge variant="info" size="sm">{{ $reward->category }}</flux:badge>
                            </flux:table.cell>

                            <flux:table.cell>
                                <span class="font-mono font-bold text-emerald-600 dark:text-emerald-400">
                                    ₳ {{ number_format($reward->cost, 2) }}
                                </span>
                            </flux:table.cell>

                            <flux:table.cell>
                                @if($reward->stock > 0)
                                    <span class="px-2 py-1 rounded bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300 text-xs font-bold">
                                        {{ $reward->stock }} disponibles
                                    </span>
                                @else
                                    <span class="px-2 py-1 rounded bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300 text-xs font-bold">
                                        Agotado
                                    </span>
                                @endif
                            </flux:table.cell>

                            <flux:table.cell>
                                <div class="flex justify-end gap-2">
                                    <flux:button href="{{ route('teacher.rewards.edit', $reward) }}" variant="ghost" size="sm" icon="pencil-square" />
                                    <x-flux.confirm-delete-modal
                                        :name="'delete-reward-'.$reward->id"
                                        title="Eliminar recompensa"
                                        message="¿Estás seguro de eliminar esta recompensa? Esta acción no se puede deshacer."
                                    >
                                        <x-slot:trigger>
                                            <flux:button variant="ghost" size="sm" icon="trash" />
                                        </x-slot:trigger>
                                        <form action="{{ route('teacher.rewards.destroy', $reward) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <flux:button type="submit" variant="danger">Eliminar</flux:button>
                                        </form>
                                    </x-flux.confirm-delete-modal>
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    @empty
                        <flux:table.row>
                            <flux:table.cell colspan="5" class="text-center py-12 text-neutral-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 mx-auto mb-3 opacity-20">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                                </svg>
                                <p class="font-medium">No hay recompensas creadas aún</p>
                                <p class="text-xs mt-1">Crea tu primera recompensa para el marketplace</p>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>

            @if($rewards->hasPages())
                <div class="mt-4">
                    {{ $rewards->links() }}
                </div>
            @endif
        </flux:card>
    </div>
</x-layouts::app>
