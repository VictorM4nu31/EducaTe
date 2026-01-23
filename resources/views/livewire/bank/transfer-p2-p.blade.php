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

<div class="bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800 p-6 space-y-6">
    <div>
        <h3 class="text-lg font-bold text-neutral-900 dark:text-white">Transferencia P2P</h3>
        <p class="text-xs text-neutral-500 dark:text-neutral-400">Envía AulaChain a tus compañeros de clase.</p>
    </div>

    <form wire:submit="send" class="space-y-4">
        <div class="space-y-1">
            <label class="text-sm font-medium text-neutral-700 dark:text-neutral-300">RFC del Receptor</label>
            <input wire:model.live="targetRfc" type="text" placeholder="ABCD000000XYZ" maxlength="13" 
                class="w-full rounded-lg border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" />
            @error('targetRfc') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>
        
        @if($searchResult)
            <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg flex items-center justify-between border border-blue-100 dark:border-blue-800">
                <div class="flex items-center gap-3">
                    <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs">
                        {{ substr($searchResult->name, 0, 2) }}
                    </div>
                    <span class="text-sm font-medium text-neutral-900 dark:text-white">{{ $searchResult->name }}</span>
                </div>
                <span class="px-2 py-1 text-xs font-medium rounded bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Válido</span>
            </div>
        @endif

        <div class="space-y-1">
            <label class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Cantidad a enviar (₳)</label>
            <input wire:model="amount" type="number" min="1"
                class="w-full rounded-lg border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" />
            @error('amount') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="p-3 bg-orange-50 dark:bg-orange-900/20 rounded-lg border border-orange-100 dark:border-orange-800">
            <div class="flex gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-orange-600 shrink-0">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                </svg>
                <p class="text-[10px] text-orange-800 dark:text-orange-300 italic">
                    Nota: Todas las transacciones son monitoreadas por los maestros para evitar mal uso del sistema.
                </p>
            </div>
        </div>

        <button type="submit" 
            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
            @if(!$searchResult) disabled @endif>
            Enviar AulaChain
        </button>
    </form>
</div>