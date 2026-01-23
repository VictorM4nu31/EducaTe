<x-layouts::app title="Admin Dashboard">
    <div class="container mx-auto py-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Panel de Administración</h1>
            <p class="text-neutral-500 dark:text-neutral-400">Bienvenido, {{ auth()->user()->name }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Gestión de Docentes -->
            <a href="{{ route('admin.docentes.index') }}" class="group block p-6 bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800 hover:border-blue-500/50 hover:shadow-lg hover:shadow-blue-500/10 transition-all">
                <div class="flex items-center gap-4 mb-4">
                    <div class="p-3 bg-blue-100 text-blue-600 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <flux:icon icon="users" class="size-6" />
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-neutral-900 dark:text-white">Docentes</h3>
                        <p class="text-sm text-neutral-500">Gestionar profesores</p>
                    </div>
                </div>
                <div class="text-sm text-neutral-500 flex justify-between items-center border-t border-neutral-100 dark:border-neutral-800 pt-4 group-hover:text-blue-600">
                    <span>Ver listado</span>
                    <flux:icon icon="arrow-right" class="size-4" />
                </div>
            </a>

            <!-- Gestión de Alumnos -->
            <a href="#" class="group block p-6 bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800 hover:border-emerald-500/50 hover:shadow-lg hover:shadow-emerald-500/10 transition-all">
                <div class="flex items-center gap-4 mb-4">
                    <div class="p-3 bg-emerald-100 text-emerald-600 rounded-lg group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                        <flux:icon icon="user-group" class="size-6" />
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-neutral-900 dark:text-white">Alumnos</h3>
                        <p class="text-sm text-neutral-500">Ver estudiantes</p>
                    </div>
                </div>
                <div class="text-sm text-neutral-500 flex justify-between items-center border-t border-neutral-100 dark:border-neutral-800 pt-4 group-hover:text-emerald-600">
                    <span>Ver listado</span>
                    <flux:icon icon="arrow-right" class="size-4" />
                </div>
            </a>

            <!-- Configuración -->
            <a href="#" class="group block p-6 bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800 hover:border-purple-500/50 hover:shadow-lg hover:shadow-purple-500/10 transition-all">
                <div class="flex items-center gap-4 mb-4">
                    <div class="p-3 bg-purple-100 text-purple-600 rounded-lg group-hover:bg-purple-600 group-hover:text-white transition-colors">
                        <flux:icon icon="cog" class="size-6" />
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-neutral-900 dark:text-white">Configuración</h3>
                        <p class="text-sm text-neutral-500">Ajustes del sistema</p>
                    </div>
                </div>
                <div class="text-sm text-neutral-500 flex justify-between items-center border-t border-neutral-100 dark:border-neutral-800 pt-4 group-hover:text-purple-600">
                    <span>Editar ajustes</span>
                    <flux:icon icon="arrow-right" class="size-4" />
                </div>
            </a>
        </div>
    </div>
</x-layouts::app>

