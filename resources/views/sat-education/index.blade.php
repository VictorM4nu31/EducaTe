<x-layouts::app title="Educación Fiscal - SAT">
    <div class="container mx-auto py-6">
        <div
            class="relative overflow-hidden rounded-2xl bg-linear-to-br from-academic-purple to-academic-purple-hover p-8 shadow-xl mb-8">
            <div class="relative z-10 flex items-center gap-6">
                <div class="p-4 bg-white/20 rounded-2xl backdrop-blur-md">
                    <flux:icon icon="academic-cap" class="size-12 text-black" />
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-black uppercase tracking-tight">Módulo Educativo SAT</h1>
                    <p class="text-neutral-800 font-medium italic">Aprende sobre el Sistema de Administración Tributaria
                        y educación fiscal</p>
                </div>
            </div>
            <div class="absolute -right-12 -top-12 h-40 w-40 rounded-full bg-white/10 blur-3xl"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Contenido Principal -->
            <div class="lg:col-span-2 space-y-6">
                @forelse($lessons as $category => $categoryLessons)
                    <flux:card>
                        <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">
                            {{ ucfirst($category === 'rfc' ? 'RFC' : ($category === 'taxes' ? 'Impuestos' : ($category === 'invoices' ? 'Facturas' : 'General'))) }}
                        </h2>

                        <div class="space-y-3">
                            @foreach($categoryLessons as $lesson)
                                <a href="{{ route('sat-education.show', $lesson) }}"
                                    class="block p-4 rounded-lg border border-neutral-light bg-neutral-very-light dark:border-neutral-light dark:bg-neutral-light/10 hover:border-academic-purple/50 transition-colors group">
                                    <h3
                                        class="font-bold text-neutral-dark dark:text-white mb-1 group-hover:text-academic-purple transition-colors">
                                        {{ $lesson->title }}
                                    </h3>
                                    <p class="text-sm text-neutral-medium dark:text-neutral-medium line-clamp-2">
                                        {{ strip_tags(\Illuminate\Support\Str::limit($lesson->content, 150)) }}
                                    </p>
                                </a>
                            @endforeach
                        </div>
                    </flux:card>
                @empty
                    <flux:card>
                        <div class="py-12 text-center text-neutral-500">
                            <flux:icon icon="book-open" class="size-12 mx-auto mb-3 opacity-20" />
                            <p class="font-medium">No hay lecciones disponibles aún</p>
                        </div>
                    </flux:card>
                @endforelse
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Mi RFC -->
                <flux:card>
                    <h3 class="font-bold text-neutral-dark dark:text-white mb-4">Mi RFC</h3>
                    <div class="space-y-3">
                        <div class="p-3 bg-aulachain-green/10 rounded-lg border border-aulachain-green/20">
                            <p class="text-xs text-aulachain-green mb-1 font-medium">Tu RFC Simulado</p>
                            <code
                                class="text-lg font-mono font-bold text-aulachain-green-active">{{ auth()->user()->rfc }}</code>
                        </div>
                        <flux:button href="{{ route('sat-education.rfc') }}" variant="primary" class="w-full">
                            Conocer mi RFC
                        </flux:button>
                    </div>
                </flux:card>

                <!-- Herramientas Interactivas -->
                <flux:card>
                    <h3 class="font-bold text-neutral-dark dark:text-white mb-4">Herramientas Interactivas</h3>
                    <div class="space-y-3">
                        <flux:button href="{{ route('sat-education.calculator') }}" variant="filled"
                            class="w-full justify-start bg-blue-500 hover:bg-blue-600 text-white" icon="calculator">
                            Calculadora de Impuestos
                        </flux:button>
                        <flux:button href="{{ route('sat-education.simulator') }}" variant="filled"
                            class="w-full justify-start bg-green-500 hover:bg-green-600 text-white"
                            icon="clipboard-document-check">
                            Simulador de Declaración
                        </flux:button>
                    </div>
                </flux:card>

                <!-- Información Rápida -->
                <flux:card>
                    <h3 class="font-bold text-neutral-900 dark:text-white mb-4">¿Qué es el SAT?</h3>
                    <p class="text-sm text-neutral-600 dark:text-neutral-300 mb-4">
                        El Servicio de Administración Tributaria (SAT) es el organismo encargado de recaudar impuestos
                        en México.
                        Aprende sobre tus obligaciones fiscales de forma educativa y práctica.
                    </p>
                    <div class="space-y-2 text-xs text-neutral-500 dark:text-neutral-400">
                        <div class="flex items-center gap-2">
                            <flux:icon icon="check-circle" class="size-4" />
                            <span>RFC: Identificación fiscal única</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <flux:icon icon="check-circle" class="size-4" />
                            <span>Impuestos: Contribución ciudadana</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <flux:icon icon="check-circle" class="size-4" />
                            <span>Facturas: Comprobantes fiscales</span>
                        </div>
                    </div>
                </flux:card>
            </div>
        </div>
    </div>
</x-layouts::app>