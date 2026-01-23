<x-layouts::app title="Nuevo Docente">
    <div class="container mx-auto py-6 max-w-2xl">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Registrar Nuevo Docente</h1>
            <p class="text-neutral-500 dark:text-neutral-400">Complete la información para dar de alta un profesor.</p>
        </div>

        <div class="bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800 p-6 shadow-sm">
            <form action="{{ route('admin.docentes.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Nombre -->
                <flux:input label="Nombre Completo" name="name" placeholder="Ej. Prof. Juan Pérez" required :value="old('name')" />

                <!-- Email -->
                <flux:input label="Correo Electrónico" type="email" name="email" placeholder="juan@educate.com" required :value="old('email')" />

                <!-- Password -->
                <flux:input label="Contraseña" type="password" name="password" required />
                <p class="text-xs text-neutral-500 mt-1">Se recomienda usar una contraseña temporal segura.</p>

                <!-- RFC (Opcional) -->
                <flux:input label="RFC (Opcional)" name="rfc" placeholder="ABCD123456XYZ" :value="old('rfc')" />
                <p class="text-xs text-neutral-500 mt-1">Si se deja vacío, se generará uno automáticamente basado en el nombre.</p>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-neutral-100 dark:border-neutral-800">
                    <flux:button href="{{ route('admin.docentes.index') }}" variant="ghost">
                        Cancelar
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        Registrar Docente
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>
