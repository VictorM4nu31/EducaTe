<x-layouts::app title="Configuración del Sistema">
    <div class="container mx-auto py-6 max-w-4xl">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-neutral-dark dark:text-neutral-dark">Configuración del Sistema</h1>
            <p class="text-neutral-medium dark:text-neutral-medium">Ajustes generales de EducaTe</p>
        </div>

        <div class="space-y-6">
            <!-- Sección General -->
            <div
                class="bg-white dark:bg-neutral-dark rounded-xl border border-neutral-light dark:border-neutral-light p-6">
                <h3 class="font-bold text-lg mb-4 text-neutral-dark dark:text-neutral-dark">Información de la Escuela
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <flux:input label="Nombre de la Institución" value="Escuela Primaria Benito Juárez" readonly />
                    <flux:input label="Ciclo Escolar" value="2025-2026" readonly />
                </div>
            </div>

            <!-- Sección SAT -->
            <div
                class="bg-white dark:bg-neutral-dark rounded-xl border border-neutral-light dark:border-neutral-light p-6">
                <h3 class="font-bold text-lg mb-4 text-neutral-dark dark:text-neutral-dark">Configuración Fiscal (SAT
                    Educativo)</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="font-medium text-neutral-dark dark:text-neutral-dark">Tasa de Impuesto (IVA
                                Educativo)</div>
                            <div class="text-xs text-neutral-medium">Porcentaje retenido automáticamente en cada
                                transacción</div>
                        </div>
                        <div class="w-24">
                            <flux:input type="number" value="16" readonly suffix="%" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <flux:button variant="primary" disabled>Guardar Cambios</flux:button>
            </div>
        </div>
    </div>
</x-layouts::app>