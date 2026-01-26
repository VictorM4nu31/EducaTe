<x-layouts::app title="Centro de Ayuda">
    <div class="container mx-auto py-6 max-w-4xl">
        <div class="mb-12 text-center">
            <h1 class="text-4xl font-bold text-neutral-dark">Centro de Ayuda</h1>
            <p class="text-neutral-medium mt-2">Encuentra respuestas a las preguntas más frecuentes sobre EducaTe.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
            <flux:card class="p-6 border-l-4 border-aulachain-blue">
                <div class="flex items-center gap-3 mb-4">
                    <flux:icon icon="bolt" class="text-aulachain-blue" />
                    <h3 class="text-lg font-bold text-neutral-dark">Comienzo Rápido</h3>
                </div>
                <p class="text-sm text-neutral-medium">Aprende lo básico para navegar tu tablero y completar tus primeras tareas.</p>
            </flux:card>

            <flux:card class="p-6 border-l-4 border-aulachain-green">
                <div class="flex items-center gap-3 mb-4">
                    <flux:icon icon="currency-dollar" class="text-aulachain-green" />
                    <h3 class="text-lg font-bold text-neutral-dark">AulaChain & Wallet</h3>
                </div>
                <p class="text-sm text-neutral-medium">¿Cómo ganar AulaChain? Entiende el sistema de recompensas y cómo usar tu wallet.</p>
            </flux:card>
        </div>

        <div class="space-y-4">
            <h2 class="text-2xl font-bold text-neutral-dark mb-6">Preguntas Frecuentes</h2>
            
            <div class="space-y-4">
                <details class="group bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-xl overflow-hidden">
                    <summary class="flex items-center justify-between p-4 cursor-pointer hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors list-none select-none">
                        <span class="font-medium text-neutral-900 dark:text-neutral-100">¿Cómo me uno a una clase?</span>
                        <flux:icon icon="chevron-down" class="transform transition-transform group-open:rotate-180 text-neutral-400 group-hover:text-neutral-600" />
                    </summary>
                    <div class="p-4 pt-0 text-neutral-600 dark:text-neutral-400 text-sm leading-relaxed border-t border-transparent group-open:border-neutral-100 dark:group-open:border-neutral-800">
                        Dirígete a "Mis Clases" en el sidebar y haz clic en "Unirse a Clase". Ingresa el código proporcionado por tu profesor.
                    </div>
                </details>

                <details class="group bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-xl overflow-hidden">
                    <summary class="flex items-center justify-between p-4 cursor-pointer hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors list-none select-none">
                        <span class="font-medium text-neutral-900 dark:text-neutral-100">¿Qué pasa si pierdo un examen?</span>
                        <flux:icon icon="chevron-down" class="transform transition-transform group-open:rotate-180 text-neutral-400 group-hover:text-neutral-600" />
                    </summary>
                    <div class="p-4 pt-0 text-neutral-600 dark:text-neutral-400 text-sm leading-relaxed border-t border-transparent group-open:border-neutral-100 dark:group-open:border-neutral-800">
                        Dependiendo de la configuración del docente, podrías tener una oportunidad de recuperación. Contacta a tu profesor directamente si el tiempo expiró.
                    </div>
                </details>

                <details class="group bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-xl overflow-hidden">
                    <summary class="flex items-center justify-between p-4 cursor-pointer hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors list-none select-none">
                        <span class="font-medium text-neutral-900 dark:text-neutral-100">¿Puedo transferir mis AulaChain?</span>
                        <flux:icon icon="chevron-down" class="transform transition-transform group-open:rotate-180 text-neutral-400 group-hover:text-neutral-600" />
                    </summary>
                    <div class="p-4 pt-0 text-neutral-600 dark:text-neutral-400 text-sm leading-relaxed border-t border-transparent group-open:border-neutral-100 dark:group-open:border-neutral-800">
                        Actualmente, los AulaChain son personales e intransferibles, diseñados para ser canjeados únicamente en el Marketplace de tu secundaria.
                    </div>
                </details>
            </div>
        </div>
    </div>
</x-layouts::app>
