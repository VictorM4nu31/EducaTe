<?php

use Livewire\Volt\Component;
use App\Models\User;
use App\Services\EconomyService;
use Livewire\Attributes\Validate;

new class extends Component
{
    #[Validate('required|string|size:13')]
    public $targetRfc = '';

    #[Validate('required|numeric|min:1')]
    public $amount = 0;

    public $searchResult = null;

    public function updatedTargetRfc($value)
    {
        if (strlen($value) === 13) {
            $this->searchResult = User::where('rfc', $value)->first();
        } else {
            $this->searchResult = null;
        }
    }

    public function send()
    {
        $this->validate();

        $receiver = User::where('rfc', $this->targetRfc)->first();

        if (!$receiver) {
            $this->dispatch('notify', ['message' => 'Estudiante no encontrado.', 'type' => 'error']);
            return;
        }

        try {
            $economy = app(EconomyService::class);
            $economy->transfer(auth()->user(), $receiver, (float)$this->amount);
            
            $this->targetRfc = '';
            $this->amount = 0;
            $this->searchResult = null;

            $this->dispatch('transfer-success');
            $this->dispatch('notify', ['message' => 'Transferencia realizada con éxito.', 'type' => 'success']);
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => $e->getMessage(), 'type' => 'error']);
        }
    }
};
?>

<x-flux:card class="space-y-6">
    <div>
        <h3 class="text-lg font-bold">Transferencia P2P</h3>
        <p class="text-xs text-neutral-500">Envía AulaChain a tus compañeros de clase.</p>
    </div>

    <form wire:submit="send" class="space-y-4">
        <x-flux:input wire:model.live="targetRfc" label="RFC del Receptor" placeholder="ABCD000000XYZ" maxlength="13" />
        
        @if($searchResult)
            <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg flex items-center justify-between border border-blue-100 dark:border-blue-800">
                <div class="flex items-center gap-3">
                    <x-flux:avatar :name="$searchResult->name" size="sm" />
                    <span class="text-sm font-medium">{{ $searchResult->name }}</span>
                </div>
                <x-flux:badge size="sm" color="blue">Válido</x-flux:badge>
            </div>
        @endif

        <x-flux:input wire:model="amount" type="number" label="Cantidad a enviar (₳)" min="1" />

        <div class="p-3 bg-orange-50 dark:bg-orange-900/20 rounded-lg border border-orange-100 dark:border-orange-800">
            <div class="flex gap-2">
                <x-flux:icon.information-circle class="size-4 text-orange-600 shrink-0" />
                <p class="text-[10px] text-orange-800 dark:text-orange-300 italic">
                    Nota: Todas las transacciones son monitoreadas por los maestros para evitar mal uso del sistema.
                </p>
            </div>
        </div>

        <x-flux:button type="submit" variant="primary" class="w-full" :disabled="!$searchResult">
            Enviar AulaChain
        </x-flux:button>
    </form>
</x-flux:card>