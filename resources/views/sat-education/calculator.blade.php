<x-layouts::app title="Calculadora de Impuestos">
    <div class="container mx-auto py-6 max-w-2xl">
        <div class="mb-6">
            <flux:button href="{{ route('sat-education.index') }}" variant="ghost" size="sm">
                ← Volver al Módulo SAT
            </flux:button>
        </div>

        <div
            class="relative overflow-hidden rounded-2xl bg-linear-to-r from-blue-600 to-blue-400 p-8 shadow-lg mb-8 text-white">
            <div class="relative z-10 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-16 mx-auto mb-4 opacity-80">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V13.5Zm0 2.25h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V18Zm2.498-6.75h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V13.5Zm0 2.25h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V18Zm2.504-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5Zm0 2.25h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V18Zm2.498-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5ZM8.25 6h7.5v2.25h-7.5V6ZM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.65 4.5 4.757V19.5a2.25 2.25 0 0 0 2.25 2.25h10.5a2.25 2.25 0 0 0 2.25-2.25V4.757c0-1.108-.806-2.057-1.907-2.185A48.507 48.507 0 0 0 12 2.25Z" />
                </svg>
                <h1 class="text-3xl font-bold uppercase tracking-tight mb-2">Calculadora de Impuestos</h1>
                <p class="text-blue-100 font-medium">Descubre a dónde van tus AulaChains y cuánto aportas a la clase.
                </p>
            </div>
            <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-white/20 blur-2xl"></div>
            <div class="absolute -left-8 -bottom-8 h-32 w-32 rounded-full bg-blue-800/20 blur-2xl"></div>
        </div>

        <flux:card>
            <div class="p-4 bg-neutral-50 dark:bg-neutral-800 rounded-xl mb-6 text-center">
                <p class="text-lg text-neutral-600 dark:text-neutral-300 font-medium">
                    Ingresa el "Sueldo Bruto" (el total) que ganarías en una tarea, y veamos cómo se reparte:
                </p>

                <div class="mt-4 flex items-center justify-center gap-4">
                    <span class="text-2xl font-bold dark:text-neutral-400">🪙</span>
                    <input type="number" id="gross_income" placeholder="Ej. 100" min="1" value="100"
                        class="text-4xl font-bold text-center w-32 bg-transparent border-b-4 border-blue-500 focus:outline-none focus:border-blue-600 text-neutral-800 dark:text-white pb-1">
                    <span class="text-xl font-bold text-neutral-500">AC</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative">
                <!-- Línea conectora visual en pantallas grandes -->
                <div
                    class="hidden md:block absolute left-1/2 top-1/2 w-0.5 h-3/4 bg-neutral-200 dark:bg-neutral-700 -translate-x-1/2 -translate-y-1/2">
                </div>

                <!-- Tu Dinero Neto -->
                <div
                    class="bg-green-50 dark:bg-green-900/20 border-2 border-green-200 dark:border-green-800 p-6 rounded-2xl text-center transform transition duration-300 hover:scale-105">
                    <div
                        class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-green-500/30 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="size-8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 12a2.25 2.25 0 0 0-2.25-2.25H15a3 3 0 1 1-6 0H5.25A2.25 2.25 0 0 0 3 12m18 0v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 9m18 0V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v3" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-green-800 dark:text-green-500 mb-1">Tu Ingreso Neto (95%)</h3>
                    <p class="text-sm text-green-600 dark:text-green-400 mb-4">Lo que llega a tu billetera para gastar o
                        ahorrar.</p>
                    <div class="text-4xl font-extrabold text-green-600 dark:text-green-400">
                        <span id="net_income">95.00</span> AC
                    </div>
                </div>

                <!-- Fondo de la Clase (Impuesto) -->
                <div
                    class="bg-purple-50 dark:bg-purple-900/20 border-2 border-purple-200 dark:border-purple-800 p-6 rounded-2xl text-center transform transition duration-300 hover:scale-105">
                    <div
                        class="w-16 h-16 bg-academic-purple rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-academic-purple/30 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="size-8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-academic-purple mb-1">Fondo de la Clase (5%)</h3>
                    <p class="text-sm text-purple-600 dark:text-purple-400 mb-4">Lo que aportas para premios grupales y
                        fiestas (Impuesto).</p>
                    <div class="text-4xl font-extrabold text-academic-purple">
                        <span id="tax_amount">5.00</span> AC
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                <div class="bg-blue-50 dark:bg-blue-900/30 p-4 rounded-xl flex items-start gap-4">
                    <div class="mt-1 text-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <p class="text-blue-900 dark:text-blue-100 text-sm">
                        <strong>¿Sabías que?</strong> En la vida real, los impuestos que pagas (como el ISR o el IVA)
                        funcionan igual: una parte se va al Gobierno para los gastos públicos (escuelas, hospitales,
                        carreteras) y el resto es tu dinero libre.
                    </p>
                </div>
            </div>
        </flux:card>
    </div>

    <!-- Script de cálculo -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('gross_income');
            const netEl = document.getElementById('net_income');
            const taxEl = document.getElementById('tax_amount');

            function calculate() {
                let gross = parseFloat(input.value);
                if (isNaN(gross) || gross < 0) {
                    gross = 0;
                }

                const tax = gross * 0.05;
                const net = gross - tax;

                netEl.textContent = net.toFixed(2);
                taxEl.textContent = tax.toFixed(2);
            }

            input.addEventListener('input', calculate);
        });
    </script>
</x-layouts::app>