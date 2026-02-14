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
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-orange-500 to-orange-600 p-8 shadow-xl text-white mb-8">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h2 class="text-3xl font-bold">Marketplace AulaChain</h2>
                <p class="text-orange-100 italic">Canjea tus monedas por premios reales o privilegios.</p>
            </div>
            <div class="bg-white/20 backdrop-blur-sm px-6 py-3 rounded-xl border border-white/30">
                <span class="text-xs text-orange-100 font-bold uppercase tracking-wider">Tu Saldo</span>
                <p class="text-2xl font-bold">₳ {{ number_format($balance, 2) }}</p>
            </div>
        </div>
        <div class="absolute -right-12 -top-12 h-40 w-40 rounded-full bg-white/10 blur-3xl"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($rewards as $reward)
            <flux:card class="flex flex-col">
                <div class="flex-1 space-y-4">
                    <div class="flex items-center justify-between">
                        <flux:badge size="sm" color="blue">{{ $reward->category }}</flux:badge>
                        <span class="text-xs text-neutral-500">Stock: {{ $reward->stock }}</span>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-neutral-900 dark:text-white">{{ $reward->name }}</h3>
                        <p class="text-sm text-neutral-500 mt-1">{{ $reward->description }}</p>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-neutral-light dark:border-neutral-800 flex items-center justify-between">
                    <div class="font-bold text-xl text-neutral-dark dark:text-white">
                        <span class="text-green-500 text-sm">₳</span> {{ number_format($reward->cost, 0) }}
                    </div>
                    <button 
                        wire:click="buy({{ $reward->id }})"
                        @disabled($reward->stock <= 0 || $balance < $reward->cost)
                        @class([
                            'px-4 py-2 rounded-lg font-bold text-white transition-all',
                            'bg-orange-500 hover:bg-orange-600 active:bg-orange-700 shadow-sm' => $reward->stock > 0 && $balance >= $reward->cost,
                            'bg-neutral-light cursor-not-allowed opacity-50' => $reward->stock <= 0 || $balance < $reward->cost,
                        ])
                    >
                        {{ $reward->stock <= 0 ? 'Agotado' : 'Canjear' }}
                    </button>
                </div>
            </flux:card>
        @endforeach
    </div>

    @if($showInvoice && $lastTransaction)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
            <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-2xl max-w-md w-full overflow-hidden animate-in fade-in zoom-in-95">
                <div class="p-6">
                    <livewire:marketplace.invoice-view :transaction="$lastTransaction" :reward="$selectedReward" />
                    
                    <div class="mt-8">
                        <flux:button variant="primary" class="w-full" wire:click="closeInvoice">Entendido</flux:button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
