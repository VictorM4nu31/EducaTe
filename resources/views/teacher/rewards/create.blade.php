<x-layouts::app title="Nueva Recompensa">
    <div class="container mx-auto py-6 max-w-2xl">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Crear Recompensa</h1>
            <p class="text-neutral-500 dark:text-neutral-400">Agregar un nuevo artículo al marketplace</p>
        </div>

        <div class="bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800 p-6 shadow-sm">
            <div class="flex items-center justify-center p-12 text-center">
                <div>
                    <flux:icon.construct class="size-12 mx-auto mb-3 text-yellow-500 opacity-50" />
                    <h3 class="font-bold text-lg">Próximamente</h3>
                    <p class="text-neutral-500">El formulario para crear recompensas estará disponible pronto.</p>
                    <flux:button href="{{ route('teacher.rewards') }}" variant="ghost" class="mt-4">
                        Volver al listado
                    </flux:button>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
