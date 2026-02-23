<?php

use Livewire\Component;

new class extends Component {
    public function render()
    {
        return view('pages.settings.two-factor.index');
    }
}; ?>

<div class="space-y-6">
    {{-- Banner de Demo --}}
    @if (auth()->user()->email === 'admin@demo.educate.com' || auth()->user()->email === 'docente@demo.educate.com' || auth()->user()->email === 'alumno@demo.educate.com')
        <flux:card class="border-amber-500/30 bg-amber-500/5">
            <div class="flex items-start gap-3">
                <flux:icon icon="exclamation-triangle" variant="solid" class="size-5 text-amber-600 dark:text-amber-400 mt-0.5 shrink-0" />
                <div class="flex-1">
                    <flux:heading size="sm" class="text-amber-700 dark:text-amber-400 font-semibold">
                        Autenticación de 2 Factores No Disponible en Demo
                    </flux:heading>
                    <flux:text variant="subtle" class="mt-1 text-sm">
                        Esta funcionalidad no está habilitada en las cuentas de demostración para todos los roles. 
                        Para usar 2FA, por favor crea una cuenta oficial.
                    </flux:text>
                </div>
            </div>
        </flux:card>
    @else
        {{-- Contenido normal de 2FA para cuentas reales --}}
        <div class="space-y-6">
            <div class="space-y-2">
                <flux:heading size="lg">{{ __('Two-Factor Authentication') }}</flux:heading>
                <flux:text variant="subtle">
                    {{ __('Secure your account with an authenticator app or security key.') }}
                </flux:text>
            </div>

            <livewire:pages.settings.two-factor.enable-authenticator-app />
            <livewire:pages.settings.two-factor.recovery-codes />
        </div>
    @endif
</div>
