<x-layouts::app title="Reportes y Analíticas">
    <div class="container mx-auto py-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-neutral-dark dark:text-neutral-dark">Reportes y Analíticas</h1>
            <p class="text-neutral-medium dark:text-neutral-medium">Resumen de rendimiento de la clase</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Stats Placeholder -->
            <div
                class="bg-white dark:bg-neutral-dark p-6 rounded-xl border border-neutral-light dark:border-neutral-light">
                <div class="text-sm font-medium text-neutral-medium mb-1">Total Puntos Otorgados</div>
                <div class="text-2xl font-bold text-neutral-dark dark:text-neutral-dark">12,450 ₳</div>
            </div>

            <div
                class="bg-white dark:bg-neutral-dark p-6 rounded-xl border border-neutral-light dark:border-neutral-light">
                <div class="text-sm font-medium text-neutral-medium mb-1">Promedio de Ahorro</div>
                <div class="text-2xl font-bold text-neutral-dark dark:text-neutral-dark">340 ₳</div>
            </div>

            <div
                class="bg-white dark:bg-neutral-dark p-6 rounded-xl border border-neutral-light dark:border-neutral-light">
                <div class="text-sm font-medium text-neutral-medium mb-1">Tareas Completadas</div>
                <div class="text-2xl font-bold text-neutral-dark dark:text-neutral-dark">85%</div>
            </div>
        </div>

        <div
            class="bg-white dark:bg-neutral-dark rounded-xl border border-neutral-light dark:border-neutral-light p-12 text-center">
            <p class="text-neutral-medium">Gráficos detallados próximamente...</p>
        </div>
    </div>
</x-layouts::app>