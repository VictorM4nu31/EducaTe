<div>
    <!-- Botón para abrir modal -->
    <flux:button 
        variant="ghost" 
        class="text-sm border-neutral-light"
        wire:click="open"
    >
        <flux:icon icon="play" variant="outline" class="size-4" />
        <span>Demo</span>
    </flux:button>

    <!-- Modal -->
    <flux:modal name="demo-users" wire:model="isOpen" class="md:w-full max-w-4xl">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg" class="mb-2">
                    <flux:icon icon="play-circle" variant="outline" class="size-6 inline mr-2" />
                    Prueba EducaTe - Credenciales de Demo
                </flux:heading>
                <p class="text-neutral-medium text-sm">
                    Haz clic en cualquier credencial para copiarla al portapapeles. Luego pégala en el formulario de login.
                </p>
            </div>

            <!-- Tabla de Credenciales Copiables -->
            <div class="space-y-3">
                @foreach ($demoUsers as $user)
                    <div class="border border-neutral-light dark:border-neutral-light/20 rounded-xl p-4 hover:shadow-md transition-all bg-white dark:bg-neutral-dark/50">
                        <!-- Encabezado del Usuario -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="size-10 rounded-lg bg-{{ $user['color'] }}-500/20 flex items-center justify-center">
                                    <flux:icon icon="{{ $user['icon'] }}" variant="solid" class="size-5 text-{{ $user['color'] }}-600 dark:text-{{ $user['color'] }}-400" />
                                </div>
                                <div>
                                    <flux:heading size="sm" class="font-bold mb-0">{{ $user['roleLabel'] }}</flux:heading>
                                    <p class="text-xs text-neutral-medium">{{ $user['name'] }}</p>
                                </div>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full bg-{{ $user['color'] }}-500/10 text-{{ $user['color'] }}-600 dark:text-{{ $user['color'] }}-400 font-semibold">
                                {{ strtoupper($user['role']) }}
                            </span>
                        </div>

                        <!-- Descripción -->
                        <p class="text-xs text-neutral-medium mb-4 leading-relaxed mb-4">
                            {{ $user['description'] }}
                        </p>

                        <!-- Credenciales Copiables -->
                        <div class="bg-neutral-light dark:bg-white/5 rounded-lg p-4 space-y-2 mb-4 font-mono text-sm">
                            <!-- Email -->
                            <div>
                                <p class="text-[10px] text-neutral-medium uppercase tracking-wider mb-1.5 font-sans font-semibold">📧 Email</p>
                                <button 
                                    type="button"
                                    onclick="navigator.clipboard.writeText('{{ $user['email'] }}'); this.classList.add('!text-{{ $user['color'] }}-500'); setTimeout(() => this.classList.remove('!text-{{ $user['color'] }}-500'), 1500);"
                                    class="w-full text-left p-2.5 bg-white dark:bg-white/10 border border-neutral-light dark:border-white/10 rounded text-neutral-dark dark:text-white break-all hover:border-{{ $user['color'] }}-500/50 hover:shadow-sm transition-all cursor-pointer group relative"
                                >
                                    <span class="flex items-center justify-between">
                                        <span>{{ $user['email'] }}</span>
                                        <flux:icon icon="clipboard-document" variant="outline" class="size-4 text-neutral-medium group-hover:text-{{ $user['color'] }}-500 ml-2 shrink-0" />
                                    </span>
                                </button>
                            </div>

                            <!-- Contraseña -->
                            <div>
                                <p class="text-[10px] text-neutral-medium uppercase tracking-wider mb-1.5 font-sans font-semibold">🔐 Contraseña</p>
                                <button 
                                    type="button"
                                    onclick="navigator.clipboard.writeText('{{ $user['password'] }}'); this.classList.add('!text-{{ $user['color'] }}-500'); setTimeout(() => this.classList.remove('!text-{{ $user['color'] }}-500'), 1500);"
                                    class="w-full text-left p-2.5 bg-white dark:bg-white/10 border border-neutral-light dark:border-white/10 rounded text-neutral-dark dark:text-white break-all hover:border-{{ $user['color'] }}-500/50 hover:shadow-sm transition-all cursor-pointer group relative"
                                >
                                    <span class="flex items-center justify-between">
                                        <span class="font-bold tracking-wide">{{ $user['password'] }}</span>
                                        <flux:icon icon="clipboard-document" variant="outline" class="size-4 text-neutral-medium group-hover:text-{{ $user['color'] }}-500 ml-2 shrink-0" />
                                    </span>
                                </button>
                            </div>

                            <!-- Ambos juntos (Email + Contraseña) -->
                            <div>
                                <p class="text-[10px] text-neutral-medium uppercase tracking-wider mb-1.5 font-sans font-semibold">📋 Copiar Todo</p>
                                <button 
                                    type="button"
                                    onclick="navigator.clipboard.writeText('Email: {{ $user['email'] }}\nContraseña: {{ $user['password'] }}'); this.classList.add('!text-{{ $user['color'] }}-500'); setTimeout(() => this.classList.remove('!text-{{ $user['color'] }}-500'), 1500);"
                                    class="w-full p-2.5 bg-{{ $user['color'] }}-500/10 border border-{{ $user['color'] }}-500/30 rounded text-{{ $user['color'] }}-600 dark:text-{{ $user['color'] }}-400 hover:bg-{{ $user['color'] }}-500/20 transition-all cursor-pointer group font-sans text-xs font-semibold flex items-center justify-center gap-2"
                                >
                                    <flux:icon icon="clipboard-document-check" variant="solid" class="size-4" />
                                    Copiar Email y Contraseña
                                </button>
                            </div>
                        </div>

                        <!-- Botón de Login -->
                        <flux:button 
                            class="w-full"
                            href="{{ route('login') }}"
                            wire:navigate
                        >
                            <flux:icon icon="arrow-right" variant="outline" class="size-4" />
                            Ir a Login
                        </flux:button>
                    </div>
                @endforeach
            </div>

            <!-- Footer con información -->
            <div class="bg-blue-500/5 border border-blue-500/20 rounded-lg p-4 text-sm">
                <flux:heading size="sm" class="mb-2">
                    <flux:icon icon="information-circle" variant="solid" class="size-4 inline mr-2" />
                    Cómo usar
                </flux:heading>
                <ol class="text-neutral-medium space-y-1 list-decimal list-inside text-xs">
                    <li>Haz clic en la credencial que quieres copiar (Email o Contraseña)</li>
                    <li>Se copiará automáticamente al portapapeles</li>
                    <li>Abre la página de login y pega la información</li>
                    <li>¡Listo! Ahora puedes explorar como ese usuario</li>
                </ol>
            </div>

            <!-- Nota importante -->
            <div class="bg-amber-500/5 border border-amber-500/20 rounded-lg p-4 text-sm">
                <flex:heading size="sm" class="mb-2">
                    <flux:icon icon="exclamation-triangle" variant="solid" class="size-4 inline mr-2" />
                    Nota
                </flex:heading>
                <p class="text-neutral-medium text-xs">
                    Los datos de demostración se reinician regularmente. Esta es una cuenta de prueba para explorar libremente todas las funcionalidades.
                </p>
            </div>
        </div>
    </flux:modal>

    <script>
        document.addEventListener('copy-to-clipboard', (event) => {
            navigator.clipboard.writeText(event.detail.text);
        });
    </script>
</div>
