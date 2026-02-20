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

                <!-- Herramientas Interactivas -->
                <flux:card>
                    <h3 class="font-bold text-neutral-dark dark:text-white mb-4">Herramientas Interactivas</h3>
                    <div class="space-y-3">
                        <flux:button href="{{ route('sat-education.calculator') }}" variant="filled"
                            class="w-full justify-start bg-blue-500 hover:bg-blue-600 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-5 mr-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V13.5Zm0 2.25h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V18Zm2.498-6.75h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V13.5Zm0 2.25h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V18Zm2.504-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5Zm0 2.25h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V18Zm2.498-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5ZM8.25 6h7.5v2.25h-7.5V6ZM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.65 4.5 4.757V19.5a2.25 2.25 0 0 0 2.25 2.25h10.5a2.25 2.25 0 0 0 2.25-2.25V4.757c0-1.108-.806-2.057-1.907-2.185A48.507 48.507 0 0 0 12 2.25Z" />
                            </svg>
                            Calculadora de Impuestos
                        </flux:button>
                        <flux:button href="{{ route('sat-education.simulator') }}" variant="filled"
                            class="w-full justify-start bg-green-500 hover:bg-green-600 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-5 mr-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                            </svg>
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