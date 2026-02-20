<x-layouts::app title="Simulador de Declaración">
    <div class="container mx-auto py-6 max-w-2xl">
        <div class="mb-6">
            <flux:button href="{{ route('sat-education.index') }}" variant="ghost" size="sm">
                ← Volver al Módulo SAT
            </flux:button>
        </div>

        <div
            class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-green-600 to-green-400 p-8 shadow-lg mb-8 text-white">
            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-10">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    <h1 class="text-3xl font-bold uppercase tracking-tight">Declaración Escolar Mensual</h1>
                </div>
                <p class="text-green-100 font-medium">Revisa tus ingresos y envía tu declaración a tiempo para ganar
                    Saldo a Favor.</p>
            </div>
            <div class="absolute -right-12 -bottom-12 h-40 w-40 rounded-full bg-white/20 blur-3xl"></div>
        </div>

        <flux:card>
            <form action="{{ route('sat-education.simulator.submit') }}" method="POST">
                @csrf

                <div class="mb-6 flex justify-between items-end border-b pb-4 dark:border-neutral-700">
                    <div>
                        <p class="text-sm font-bold text-neutral-500 uppercase tracking-widest">Contribuyente</p>
                        <h2 class="text-2xl font-bold dark:text-white">{{ $user->name }}</h2>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-neutral-500 uppercase tracking-widest mb-1">RFC Simulado</p>
                        <span
                            class="bg-neutral-100 dark:bg-neutral-800 px-3 py-1 rounded font-mono font-bold">{{ $user->rfc }}</span>
                    </div>
                </div>

                <div class="bg-neutral-50 dark:bg-neutral-800/50 rounded-xl p-6 mb-8 space-y-6">
                    <h3 class="font-bold text-lg dark:text-white text-center border-b pb-2 dark:border-neutral-700">
                        Resumen del Mes ({{ now()->locale('es')->monthName }})</h3>

                    <div class="flex justify-between items-center text-lg">
                        <span class="text-neutral-600 dark:text-neutral-400">Total Ingresos Recibidos:</span>
                        <span class="font-bold text-green-600">+ {{ number_format($ingresosMes, 2) }} AC</span>
                    </div>

                    <div class="flex justify-between items-center text-lg">
                        <span class="text-neutral-600 dark:text-neutral-400">Deducciones Permitidas (Gastos):</span>
                        <span class="font-bold text-red-500">- {{ number_format($gastosMes, 2) }} AC</span>
                    </div>

                    <div
                        class="bg-white dark:bg-neutral-900 p-4 border rounded-lg dark:border-neutral-700 text-center shadow-sm">
                        <p class="text-sm text-neutral-500 mb-1 font-bold uppercase">Resultado y Beneficio</p>
                        <span class="text-2xl font-black text-blue-600 dark:text-blue-400">¡Tienes SALDO A FAVOR!</span>
                        <p class="text-sm mt-2">Por enviar tu declaración, recibirás de recompensa <strong
                                class="bg-yellow-200 text-yellow-800 px-2 py-0.5 rounded">10 AulaChains</strong>.</p>
                    </div>
                </div>

                <div class="pt-4 border-t dark:border-neutral-700">
                    <p class="text-xs text-neutral-500 mb-4 italic text-center">
                        Declaro bajo protesta de decir verdad que los datos de esta simulación educativa reflejan mis
                        ingresos.
                    </p>
                    <flux:button type="submit" variant="primary" size="lg"
                        class="w-full bg-green-500 hover:bg-green-600 text-white font-bold text-lg border-none shadow-lg">
                        Firmar y Enviar Declaración
                    </flux:button>
                </div>
            </form>
        </flux:card>
    </div>
</x-layouts::app>