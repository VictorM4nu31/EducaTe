<x-layouts::app title="Editar Docente">
    <div class="container mx-auto py-6 max-w-2xl">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Editar Docente</h1>
            <p class="text-neutral-500 dark:text-neutral-400">Actualizar información de {{ $docente->name }}</p>
        </div>

        <div class="bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800 p-6 shadow-sm">
            <form action="{{ route('admin.docentes.update', $docente) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Nombre -->
                <flux:input label="Nombre Completo" name="name" required :value="old('name', $docente->name)" />

                <!-- Email -->
                <flux:input label="Correo Electrónico" type="email" name="email" required :value="old('email', $docente->email)" />

                <!-- RFC -->
                <flux:input label="RFC" name="rfc" :value="old('rfc', $docente->rfc)" />

                <div class="p-4 bg-neutral-50 dark:bg-neutral-800/50 rounded-lg border border-neutral-100 dark:border-neutral-800">
                    <h3 class="text-sm font-bold text-neutral-900 dark:text-white mb-4">Cambiar Contraseña</h3>
                    
                    <flux:input label="Nueva Contraseña (Opcional)" type="password" name="password" placeholder="Dejar en blanco para mantener la actual" />
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-neutral-100 dark:border-neutral-800">
                    <div class="text-sm text-neutral-500">
                        Rol actual: {!! user_role_badge('docente') !!}
                    </div>
                    
                    <div class="flex gap-3">
                        <flux:button href="{{ route('admin.docentes.index') }}" variant="ghost">
                            Cancelar
                        </flux:button>
                        <flux:button type="submit" variant="primary">
                            Guardar Cambios
                        </flux:button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>
