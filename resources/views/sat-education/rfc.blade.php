<x-layouts::app title="Mi RFC - Educación Fiscal">
    <div class="container mx-auto py-6 max-w-4xl">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Mi RFC: Explicación Detallada</h1>
            <p class="text-neutral-500 dark:text-neutral-400">Aprende qué es tu RFC y cómo funciona</p>
        </div>

        <!-- RFC Destacado -->
        <flux:card class="mb-6">
            <div class="text-center py-8 bg-gradient-to-r from-emerald-50 to-blue-50 dark:from-emerald-900/20 dark:to-blue-900/20 rounded-xl">
                <p class="text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Tu RFC Simulado</p>
                <code class="text-5xl font-mono font-bold text-emerald-600 dark:text-emerald-400 tracking-wider">{{ $userRfc }}</code>
                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-3">
                    Este es tu RFC educativo generado automáticamente en AulaChain
                </p>
            </div>
        </flux:card>

        <!-- Explicación de Partes -->
        <flux:card class="mb-6">
            <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-6">¿De qué se compone tu RFC?</h2>
            
            <div class="space-y-6">
                @foreach($rfcExplanation['parts'] as $key => $part)
                    <div class="p-4 border-l-4 border-emerald-500 bg-emerald-50/50 dark:bg-emerald-900/10 rounded-r-lg">
                        <div class="flex items-start justify-between mb-2">
                            <div>
                                <h3 class="font-bold text-neutral-900 dark:text-white">{{ $part['label'] }}</h3>
                                <code class="text-2xl font-mono font-bold text-emerald-600 dark:text-emerald-400 mt-1 block">
                                    {{ $part['value'] }}
                                </code>
                            </div>
                            <div class="px-3 py-1 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 rounded text-xs font-bold">
                                {{ strtoupper($key) }}
                            </div>
                        </div>
                        <p class="text-sm text-neutral-600 dark:text-neutral-300 mt-3">
                            {{ $part['explanation'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </flux:card>

        <!-- Información General -->
        <flux:card class="mb-6">
            <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">¿Qué es el RFC?</h2>
            <div class="prose dark:prose-invert max-w-none">
                <p class="text-neutral-700 dark:text-neutral-300 mb-4">
                    {!! $rfcExplanation['full_explanation'] !!}
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <h4 class="font-bold text-blue-900 dark:text-blue-200 mb-2">¿Para qué sirve?</h4>
                        <ul class="text-sm text-blue-800 dark:text-blue-300 space-y-1 list-disc list-inside">
                            <li>Identificarte ante el SAT</li>
                            <li>Realizar actividades económicas</li>
                            <li>Recibir ingresos formales</li>
                            <li>Emitir y recibir facturas</li>
                        </ul>
                    </div>

                    <div class="p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg border border-purple-200 dark:border-purple-800">
                        <h4 class="font-bold text-purple-900 dark:text-purple-200 mb-2">En AulaChain</h4>
                        <ul class="text-sm text-purple-800 dark:text-purple-300 space-y-1 list-disc list-inside">
                            <li>Tu RFC simulado es único</li>
                            <li>Se usa en transferencias P2P</li>
                            <li>Aparece en facturas educativas</li>
                            <li>Te enseña sobre fiscalidad</li>
                        </ul>
                    </div>
                </div>
            </div>
        </flux:card>

        <!-- Comparación Visual -->
        <flux:card>
            <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">Estructura del RFC</h2>
            <div class="overflow-x-auto">
                <div class="inline-flex items-center gap-2 text-2xl font-mono font-bold">
                    @php
                        $initials = substr($userRfc, 0, 4);
                        $date = substr($userRfc, 4, 6);
                        $homoclave = substr($userRfc, 10, 3);
                    @endphp
                    <span class="px-3 py-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 rounded" title="Iniciales">{{ $initials }}</span>
                    <span class="text-neutral-400">+</span>
                    <span class="px-3 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded" title="Fecha">{{ $date }}</span>
                    <span class="text-neutral-400">+</span>
                    <span class="px-3 py-2 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded" title="Homoclave">{{ $homoclave }}</span>
                </div>
            </div>
            <div class="mt-4 flex gap-4 text-xs text-neutral-500 dark:text-neutral-400">
                <div class="flex items-center gap-1">
                    <div class="w-3 h-3 bg-emerald-500 rounded"></div>
                    <span>Iniciales (4 caracteres)</span>
                </div>
                <div class="flex items-center gap-1">
                    <div class="w-3 h-3 bg-blue-500 rounded"></div>
                    <span>Fecha (6 dígitos)</span>
                </div>
                <div class="flex items-center gap-1">
                    <div class="w-3 h-3 bg-purple-500 rounded"></div>
                    <span>Homoclave (3 caracteres)</span>
                </div>
            </div>
        </flux:card>

        <div class="mt-6 flex gap-3">
            <flux:button href="{{ route('sat-education.index') }}" variant="ghost">
                ← Volver a Lecciones
            </flux:button>
        </div>
    </div>
</x-layouts::app>
