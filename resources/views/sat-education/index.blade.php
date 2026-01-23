<x-layouts::app title="Educación Fiscal - SAT">
    <div class="container mx-auto py-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Módulo Educativo SAT</h1>
            <p class="text-neutral-500 dark:text-neutral-400">Aprende sobre el Sistema de Administración Tributaria y educación fiscal</p>
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
                                   class="block p-4 rounded-lg border border-neutral-200 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors">
                                    <h3 class="font-bold text-neutral-900 dark:text-white mb-1">{{ $lesson->title }}</h3>
                                    <p class="text-sm text-neutral-500 dark:text-neutral-400 line-clamp-2">
                                        {{ strip_tags(\Illuminate\Support\Str::limit($lesson->content, 150)) }}
                                    </p>
                                </a>
                            @endforeach
                        </div>
                    </flux:card>
                @empty
                    <flux:card>
                        <div class="py-12 text-center text-neutral-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 mx-auto mb-3 opacity-20">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
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
                    <h3 class="font-bold text-neutral-900 dark:text-white mb-4">Mi RFC</h3>
                    <div class="space-y-3">
                        <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg border border-emerald-200 dark:border-emerald-800">
                            <p class="text-xs text-emerald-700 dark:text-emerald-300 mb-1">Tu RFC Simulado</p>
                            <code class="text-lg font-mono font-bold text-emerald-600 dark:text-emerald-400">{{ auth()->user()->rfc }}</code>
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
                        El Servicio de Administración Tributaria (SAT) es el organismo encargado de recaudar impuestos en México. 
                        Aprende sobre tus obligaciones fiscales de forma educativa y práctica.
                    </p>
                    <div class="space-y-2 text-xs text-neutral-500 dark:text-neutral-400">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span>RFC: Identificación fiscal única</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span>Impuestos: Contribución ciudadana</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span>Facturas: Comprobantes fiscales</span>
                        </div>
                    </div>
                </flux:card>
            </div>
        </div>
    </div>
</x-layouts::app>
