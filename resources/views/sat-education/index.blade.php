<x-layouts::app title="Educación Fiscal - SAT">
    <div class="container mx-auto py-6">
        <div
            class="relative overflow-hidden rounded-2xl bg-linear-to-br from-academic-purple to-academic-purple-hover p-8 shadow-xl mb-8">
            <div class="relative z-10">
                <h1 class="text-3xl font-bold text-black uppercase tracking-tight">Módulo Educativo SAT</h1>
                <p class="text-neutral-800 font-medium italic">Aprende sobre el Sistema de Administración Tributaria y
                    educación fiscal</p>
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
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-12 mx-auto mb-3 opacity-20">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span>RFC: Identificación fiscal única</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span>Impuestos: Contribución ciudadana</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span>Facturas: Comprobantes fiscales</span>
                        </div>
                    </div>
                </flux:card>
            </div>
        </div>
    </div>
</x-layouts::app>