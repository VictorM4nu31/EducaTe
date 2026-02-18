@props([
    'name',
    'title',
    'message' => 'Esta acción no se puede deshacer.',
    'confirmLabel' => 'Eliminar',
    'cancelLabel' => 'Cancelar',
])

<flux:modal.trigger :name="$name">
    {{ $trigger ?? '' }}
</flux:modal.trigger>

<flux:modal :name="$name" focusable class="max-w-md">
    <div class="space-y-6">
        <div class="space-y-2">
            <flux:heading size="lg" class="block w-full text-start">{{ $title }}</flux:heading>
            <flux:subheading class="block w-full text-start text-balance">{{ $message }}</flux:subheading>
        </div>

        <div class="flex flex-col sm:flex-row justify-end gap-3 mt-8">
            <flux:modal.close>
                <flux:button variant="ghost" class="w-full sm:w-auto border-neutral-light">{{ $cancelLabel }}</flux:button>
            </flux:modal.close>
            {{ $slot }}
        </div>
    </div>
</flux:modal>
