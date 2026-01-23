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

        <div class="p-12 text-center text-neutral-500 bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800">
            <flux:icon.shopping-bag class="size-12 mx-auto mb-3 opacity-20" />
            <p class="font-medium">Módulo de recompensas en construcción</p>
            <p class="text-xs mt-1">Aquí aparecerán los productos que los alumnos pueden "comprar" con sus puntos.</p>
        </div>
    </div>
</x-layouts::app>
