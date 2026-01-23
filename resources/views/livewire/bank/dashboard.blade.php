<?php

use Livewire\Component;
use App\Models\Transaction;

new class extends Component
{
    public $balance;
    public $transactions;
    public $savingsProjection;

    public function mount()
    {
        $user = auth()->user();
        
        // Ensure wallet exists (safety check for existing users)
        $wallet = $user->wallet ?: $user->wallet()->create(['balance' => 0]);
        
        $this->balance = $wallet->balance;
        $this->transactions = $wallet->transactions()->latest()->take(10)->get();
        
        // Mock projection: If you save 50 AC/week, in 4 weeks you'll have...
        $this->savingsProjection = $this->balance + (50 * 4);
    }
};
?>

<div class="space-y-6">
    <!-- Header with Balance (Glassmorphism) -->
    <div class="relative overflow-hidden rounded-2xl bg-white/10 p-8 shadow-xl backdrop-blur-md border border-white/20 dark:bg-black/20 dark:border-white/10">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <p class="text-sm font-medium text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Mi AulaChain</p>
                <h2 class="text-5xl font-bold text-neutral-900 dark:text-white mt-1">
                    <span class="text-emerald-500">₳</span> {{ number_format($balance, 2) }}
                </h2>
                <div class="mt-4 flex gap-3">
                    <div class="flex items-center gap-1 scale-90 origin-left">
                        <span class="px-2 py-0.5 rounded bg-blue-100 text-blue-700 text-xs font-bold dark:bg-blue-900/40 dark:text-blue-300">RFC: {{ auth()->user()->rfc }}</span>
                    </div>
                    <div class="flex items-center gap-1 scale-90 origin-left">
                        {!! user_role_badge() !!}
                    </div>
                </div>
            </div>
            
            <div class="bg-white/30 dark:bg-white/5 p-4 rounded-xl border border-white/40 flex flex-col gap-1">
                <span class="text-xs text-neutral-500 dark:text-neutral-400">Proyección de Ahorro (4 sem)</span>
                <span class="text-xl font-semibold text-emerald-600 dark:text-emerald-300">₳ {{ number_format($savingsProjection, 2) }}</span>
                <span class="text-[10px] text-emerald-500">+ ₳ 200 estimado</span>
            </div>
        </div>
        
        <!-- Decorative blob -->
        <div class="absolute -right-16 -top-16 h-48 w-48 rounded-full bg-emerald-500/20 blur-3xl"></div>
        <div class="absolute -left-16 -bottom-16 h-32 w-32 rounded-full bg-blue-500/10 blur-2xl"></div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Transactions List -->
        <div class="lg:col-span-2 space-y-4">
            <div class="flex items-center justify-between px-2">
                <h3 class="text-lg font-bold text-neutral-800 dark:text-neutral-200">Historial Reciente</h3>
                <a href="#" class="text-xs text-emerald-600 hover:underline font-medium">Ver todo</a>
            </div>
            
            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800 divide-y divide-neutral-100 dark:divide-neutral-800 overflow-hidden">
                @forelse($transactions as $tx)
                    <div class="p-4 flex items-center justify-between hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition-colors">
                        <div class="flex items-center gap-4">
                            <div @class([
                                'p-2 rounded-lg',
                                'bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400' => $tx->amount > 0,
                                'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400' => $tx->amount < 0,
                            ])>
                                @if($tx->type === 'income') 
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                                    </svg>
                                @elseif($tx->type === 'expense' || $tx->type === 'tax') 
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" />
                                    </svg>
                                @elseif($tx->type === 'p2p') 
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                    </svg>
                                @else 
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-neutral-800 dark:text-neutral-200">{{ $tx->description }}</p>
                                <p class="text-xs text-neutral-500">{{ $tx->created_at->diffForHumans() }} • <span class="capitalize">{{ $tx->type }}</span></p>
                            </div>
                        </div>
                        <div @class([
                            'text-sm font-bold',
                            'text-emerald-600 dark:text-emerald-400' => $tx->amount > 0,
                            'text-red-600 dark:text-red-400' => $tx->amount < 0,
                        ])>
                            {{ $tx->amount > 0 ? '+' : '' }}{{ number_format($tx->amount, 2) }} ₳
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center text-neutral-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 mx-auto mb-3 opacity-20">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                        </svg>
                        <p>No hay transacciones aún.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Sidebar / Statistics -->
        <div class="space-y-6">
            <div class="bg-neutral-50 dark:bg-neutral-900/50 p-6 rounded-2xl border border-neutral-200/60 dark:border-neutral-800">
                <h4 class="text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-4">Módulo SAT: Educación Fiscal</h4>
                <div class="space-y-4">
                    <div class="flex justify-between items-end border-b border-neutral-200 dark:border-neutral-800 pb-2">
                        <span class="text-xs text-neutral-500">Retención Automática</span>
                        <span class="text-sm font-bold text-red-500">5%</span>
                    </div>
                    <p class="text-[11px] text-neutral-500 italic">
                        Sabías que cada AulaChain ganado contribuye con un 5% al fondo común de la clase para eventos especiales.
                    </p>
                    <button class="w-full text-xs py-1.5 px-3 rounded-lg text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors font-medium">
                        ¿Qué es el RFC?
                    </button>
                </div>
            </div>

            <livewire:bank.transfer-p2-p />

            <div class="bg-emerald-600 p-6 rounded-2xl text-white shadow-lg shadow-emerald-500/20">
                <h4 class="text-sm font-bold mb-2">Meta de Ahorro</h4>
                <p class="text-xs opacity-90 mb-4">Ahorra 500 AC y obtén el badge "Ahorrador Experto".</p>
                <div class="w-full bg-black/20 rounded-full h-2 mb-2">
                    <div class="bg-white rounded-full h-2 transition-all duration-500" style="width: {{ min(($balance/500)*100, 100) }}%"></div>
                </div>
                <div class="flex justify-between text-[10px] font-bold">
                    <span>{{ min(round(($balance/500)*100), 100) }}%</span>
                    <span>500 ₳</span>
                </div>
            </div>
        </div>
    </div>
</div>