<x-layouts::app title="Soporte del Sistema">
    <div class="container mx-auto py-6 max-w-4xl">
        <div class="mb-12">
            <h1 class="text-3xl font-bold text-neutral-dark">Soporte del Sistema</h1>
            <p class="text-neutral-medium mt-1">Recursos técnicos y contacto para administradores de la plataforma EducaTe.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <flux:card class="p-6">
                <flux:heading size="lg" class="mb-4">Estado del Sistema</flux:heading>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-neutral-medium">Base de Datos</span>
                        <flux:badge variant="success" size="sm">Operacional</flux:badge>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-neutral-medium">Servidor de Archivos</span>
                        <flux:badge variant="success" size="sm">Operacional</flux:badge>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-neutral-medium">Cache (Redis)</span>
                        <flux:badge variant="success" size="sm">Operacional</flux:badge>
                    </div>
                </div>
            </flux:card>

            <flux:card class="p-6">
                <flux:heading size="lg" class="mb-4">Información de Versión</flux:heading>
                <p class="text-sm text-neutral-medium mb-2"><strong>Versión app:</strong> 1.0.4-stable</p>
                <p class="text-sm text-neutral-medium mb-2"><strong>Versión Laravel:</strong> {{ app()->version() }}</p>
                <p class="text-sm text-neutral-medium mb-4"><strong>PHP:</strong> {{ PHP_VERSION }}</p>
                <flux:button variant="ghost" size="sm" class="w-full">Comprobar actualizaciones</flux:button>
            </flux:card>
        </div>

        <flux:card class="bg-blue-500/5 border-blue-500/20">
            <div class="flex flex-col md:flex-row items-center gap-8 p-4">
                <div class="bg-white dark:bg-neutral-dark p-4 rounded-2xl shadow-sm">
                    <flux:icon icon="lifebuoy" class="size-12 text-blue-500" />
                </div>
                <div class="flex-1 text-center md:text-left">
                    <h3 class="text-xl font-bold text-neutral-dark mb-2">¿Necesitas ayuda técnica avanzada?</h3>
                    <p class="text-neutral-medium">Contacta directamente con el equipo de desarrollo de EducaTe para reportar errores críticos o solicitar cambios en la infraestructura.</p>
                </div>
                <flux:button class="bg-blue-500 hover:bg-blue-600 text-white border-none shadow-lg shadow-blue-500/20">
                    Enviar Ticket
                </flux:button>
            </div>
        </flux:card>
    </div>
</x-layouts::app>
