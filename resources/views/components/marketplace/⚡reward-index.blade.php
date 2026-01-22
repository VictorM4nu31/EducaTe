<?php

use Livewire\Volt\Component;
use App\Models\Reward;
use App\Services\EconomyService;

new class extends Component
{
    public $selectedReward = null;
    public $showInvoice = false;
    public $lastTransaction = null;

    public function with()
    {
        return [
            'rewards' => Reward::all(),
            'balance' => auth()->user()->wallet->balance ?? 0,
        ];
    }

    public function buy(Reward $reward)
    {
        if ($reward->stock <= 0) {
            $this->dispatch('notify', ['message' => 'Producto agotado.', 'type' => 'error']);
            return;
        }

        try {
            $economy = app(EconomyService::class);
            $this->lastTransaction = $economy->debit(
                auth()->user(), 
                (float)$reward->cost, 
                "Canje: {$reward->name}", 
                'reward',
                ['reward_id' => $reward->id]
            );

            $reward->decrement('stock');
            
            $this->selectedReward = $reward;
            $this->showInvoice = true;

            $this->dispatch('reward-purchased');
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function closeInvoice()
    {
        $this->showInvoice = false;
    }
};
?>

<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Marketplace AulaChain</h2>
            <p class="text-sm text-neutral-500">Canjea tus monedas por premios reales o privilegios.</p>
        </div>
        <div class="bg-emerald-50 dark:bg-emerald-900/30 px-4 py-2 rounded-xl border border-emerald-100 dark:border-emerald-800">
            <span class="text-xs text-emerald-600 dark:text-emerald-400 font-bold uppercase">Tu Saldo</span>
            <p class="text-xl font-bold text-emerald-700 dark:text-emerald-300">₳ {{ number_format($balance, 2) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($rewards as $reward)
            <x-flux:card class="flex flex-col">
                <div class="flex-1 space-y-4">
                    <div class="flex items-center justify-between">
                        <x-flux:badge size="sm" color="blue">{{ $reward->category }}</x-flux:badge>
                        <span class="text-xs text-neutral-500">Stock: {{ $reward->stock }}</span>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-neutral-900 dark:text-white">{{ $reward->name }}</h3>
                        <p class="text-sm text-neutral-500 mt-1">{{ $reward->description }}</p>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-neutral-100 dark:border-neutral-800 flex items-center justify-between">
                    <div class="font-bold text-xl text-neutral-900 dark:text-white">
                        <span class="text-emerald-500 text-sm">₳</span> {{ number_format($reward->cost, 0) }}
                    </div>
                    <x-flux:button 
                        variant="primary" 
                        size="sm" 
                        wire:click="buy({{ $reward->id }})"
                        :disabled="$reward->stock <= 0 || $balance < $reward->cost"
                    >
                        {{ $reward->stock <= 0 ? 'Agotado' : 'Canjear' }}
                    </x-flux:button>
                </div>
            </x-flux:card>
        @endforeach
    </div>

    @if($showInvoice && $lastTransaction)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
            <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-2xl max-w-md w-full overflow-hidden animate-in fade-in zoom-in-95">
                <div class="p-6">
                    <livewire:marketplace.invoice-view :transaction="$lastTransaction" :reward="$selectedReward" />
                    
                    <div class="mt-8">
                        <x-flux:button variant="primary" class="w-full" wire:click="closeInvoice">Entendido</x-flux:button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>