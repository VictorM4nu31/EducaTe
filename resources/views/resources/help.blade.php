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
            
            <flux:accordion transition>
                <flux:accordion.item>
                    <flux:accordion.heading>¿Cómo me uno a una clase?</flux:accordion.heading>
                    <flux:accordion.content>
                        Dirígete a "Mis Clases" en el sidebar y haz clic en "Unirse a Clase". Ingresa el código proporcionado por tu profesor.
                    </flux:accordion.content>
                </flux:accordion.item>

                <flux:accordion.item>
                    <flux:accordion.heading>¿Qué pasa si pierdo un examen?</flux:accordion.heading>
                    <flux:accordion.content>
                        Dependiendo de la configuración del docente, podrías tener una oportunidad de recuperación. Contacta a tu profesor directamente si el tiempo expiró.
                    </flux:accordion.content>
                </flux:accordion.item>

                <flux:accordion.item>
                    <flux:accordion.heading>¿Puedo transferir mis AulaChain?</flux:accordion.heading>
                    <flux:accordion.content>
                        Actualmente, los AulaChain son personales e intransferibles, diseñados para ser canjeados únicamente en el Marketplace de tu secundaria.
                    </flux:accordion.content>
                </flux:accordion.item>
            </flux:accordion>
        </div>
    </div>
</x-layouts::app>
