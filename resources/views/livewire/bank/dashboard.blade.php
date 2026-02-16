<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On;
use App\Models\Transaction;
use App\Models\SavingsGoal;
use Illuminate\Support\Facades\DB;

new class extends Component {
    public $balance;
    public $transactions;
    public $savingsGoals;

    // Estadísticas
    public $totalIncome = 0;
    public $totalExpenses = 0;
    public $totalTaxes = 0;
    public $netSavings = 0;

    // Gráficas de datos (últimos 30 días)
    public $chartData = [];

    // Proyecciones
    public $weeklyAverage = 0;
    public $projection4Weeks = 0;
    public $projection8Weeks = 0;

    // Intereses simbólicos
    public $symbolicInterest = 0;
    public $daysWithoutSpending = 0;

    public function mount()
    {
        $user = auth()->user();

        // Ensure wallet exists
        $wallet = $user->wallet ?: $user->wallet()->create(['balance' => 0]);

        $this->balance = $wallet->balance;
        $this->transactions = $wallet->transactions()->latest()->take(15)->get();
        $this->savingsGoals = $user->savingsGoals()->where('is_completed', false)->get();

        // Calcular estadísticas
        $this->calculateStatistics($wallet);

        // Calcular datos para gráficas
        $this->calculateChartData($wallet);

        // Calcular proyecciones
        $this->calculateProjections($wallet);

        // Calcular intereses simbólicos
        $this->calculateSymbolicInterest($wallet);

        // Actualizar objetivos de ahorro con balance actual
        $this->updateSavingsGoals();
    }

    public function updated($property)
    {
        // Si se actualiza el balance, refrescar objetivos
        if ($property === 'balance') {
            $this->updateSavingsGoals();
        }
    }

    #[On('savings-goal-created')]
    public function refreshSavingsGoals()
    {
        $this->savingsGoals = auth()->user()->savingsGoals()->where('is_completed', false)->get();
    }

    protected function calculateStatistics($wallet)
    {
        $thirtyDaysAgo = now()->subDays(30);

        $this->totalIncome = $wallet->transactions()
            ->where('type', 'income')
            ->where('amount', '>', 0)
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->sum('amount');

        $this->totalExpenses = abs($wallet->transactions()
            ->whereIn('type', ['expense', 'reward', 'p2p'])
            ->where('amount', '<', 0)
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->sum('amount'));

        $this->totalTaxes = abs($wallet->transactions()
            ->where('type', 'tax')
            ->where('amount', '<', 0)
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->sum('amount'));

        $this->netSavings = $this->totalIncome - $this->totalExpenses - $this->totalTaxes;
    }

    protected function calculateChartData($wallet)
    {
        $thirtyDaysAgo = now()->subDays(30);

        // Agrupar por día (últimos 7 días para visualización)
        $dailyData = $wallet->transactions()
            ->where('created_at', '>=', now()->subDays(7))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(CASE WHEN amount > 0 THEN amount ELSE 0 END) as income'),
                DB::raw('SUM(CASE WHEN amount < 0 THEN ABS(amount) ELSE 0 END) as expense')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $this->chartData = $dailyData->map(function ($item) {
            return [
                'date' => $item->date,
                'income' => (float) $item->income,
                'expense' => (float) $item->expense,
            ];
        })->toArray();
    }

    protected function calculateProjections($wallet)
    {
        $thirtyDaysAgo = now()->subDays(30);

        // Calcular promedio semanal de ingresos
        $weeklyIncome = $wallet->transactions()
            ->where('type', 'income')
            ->where('amount', '>', 0)
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->sum('amount') / 4; // Promedio semanal (30 días / ~4 semanas)

        $this->weeklyAverage = max(0, $weeklyIncome);

        // Proyecciones asumiendo que se mantiene el promedio semanal
        $this->projection4Weeks = $this->balance + ($this->weeklyAverage * 4);
        $this->projection8Weeks = $this->balance + ($this->weeklyAverage * 8);
    }

    protected function calculateSymbolicInterest($wallet)
    {
        // Calcular días sin gastar (última transacción de gasto)
        $lastExpense = $wallet->transactions()
            ->where('amount', '<', 0)
            ->whereIn('type', ['expense', 'reward'])
            ->latest()
            ->first();

        if ($lastExpense) {
            $this->daysWithoutSpending = now()->diffInDays($lastExpense->created_at);
        } else {
            // Si nunca ha gastado, usar días desde creación de wallet
            $this->daysWithoutSpending = now()->diffInDays($wallet->created_at);
        }

        // Interés simbólico: 0.1% por día sin gastar (máximo 30 días = 3%)
        $interestRate = min($this->daysWithoutSpending * 0.001, 0.03);
        $this->symbolicInterest = $this->balance * $interestRate;
    }

    protected function updateSavingsGoals()
    {
        // Actualizar current_amount de objetivos con el balance actual
        foreach ($this->savingsGoals as $goal) {
            $goal->current_amount = min($this->balance, $goal->target_amount);
            if ($goal->current_amount >= $goal->target_amount && !$goal->is_completed) {
                $goal->is_completed = true;
                $goal->completed_at = now();
            }
            $goal->save();
        }
    }
};
?>

<div class="space-y-6">
    <!-- Header with Balance -->
    <div
        class="relative overflow-hidden rounded-2xl bg-linear-to-br from-aulachain-green to-aulachain-green-active p-8 shadow-xl text-white">
        <div class="relative z-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <p class="text-sm font-medium text-emerald-100 uppercase tracking-wider mb-1">Banco Virtual
                        AulaChain</p>
                    <h2 class="text-5xl font-bold mt-1">
                        ₳ {{ number_format($balance, 2) }}
                    </h2>
                    <div class="mt-4 flex gap-3 flex-wrap">
                        <div class="px-3 py-1 rounded-full bg-white/20 backdrop-blur-sm text-xs font-medium">
                            RFC: {{ auth()->user()->rfc }}
                        </div>
                        {!! user_role_badge() !!}
                        @if($daysWithoutSpending > 0)
                            <div class="px-3 py-1 rounded-full bg-white/20 backdrop-blur-sm text-xs font-medium">
                                {{ $daysWithoutSpending }} días sin gastar
                            </div>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white/20 backdrop-blur-sm p-4 rounded-xl border border-white/30">
                        <p class="text-xs text-emerald-100 mb-1">Interés Simbólico</p>
                        <p class="text-2xl font-bold">+₳ {{ number_format($symbolicInterest, 2) }}</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm p-4 rounded-xl border border-white/30">
                        <p class="text-xs text-emerald-100 mb-1">Ahorro Neto (30d)</p>
                        <p class="text-2xl font-bold">₳ {{ number_format($netSavings, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Decorative blobs -->
        <div class="absolute -right-16 -top-16 h-48 w-48 rounded-full bg-white/10 blur-3xl"></div>
        <div class="absolute -left-16 -bottom-16 h-32 w-32 rounded-full bg-blue-500/20 blur-2xl"></div>
    </div>

    <!-- Estadísticas Rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <flux:card class="p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">Ingresos (30d)</p>
                    <p class="text-2xl font-bold text-aulachain-green">₳ {{ number_format($totalIncome, 2) }}</p>
                </div>
                <div class="p-3 bg-aulachain-green/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 text-aulachain-green">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                    </svg>
                </div>
            </div>
        </flux:card>

        <flux:card class="p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">Gastos (30d)</p>
                    <p class="text-2xl font-bold text-alert-red">₳ {{ number_format($totalExpenses, 2) }}</p>
                </div>
                <div class="p-3 bg-alert-red/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 text-alert-red">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" />
                    </svg>
                </div>
            </div>
        </flux:card>

        <flux:card class="p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">Impuestos (30d)</p>
                    <p class="text-2xl font-bold text-aulachain-orange">₳ {{ number_format($totalTaxes, 2) }}</p>
                </div>
                <div class="p-3 bg-aulachain-orange/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 text-aulachain-orange">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                    </svg>
                </div>
            </div>
        </flux:card>

        <flux:card class="p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">Promedio Semanal</p>
                    <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">₳
                        {{ number_format($weeklyAverage, 2) }}
                    </p>
                </div>
                <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 text-blue-600 dark:text-blue-400">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                    </svg>
                </div>
            </div>
        </flux:card>
    </div>

    <!-- Gráfica de Ahorro vs Gasto -->
    <flux:card>
        <div class="mb-4">
            <h3 class="text-lg font-bold text-neutral-900 dark:text-white">Ahorro vs Gasto (Últimos 7 días)</h3>
            <p class="text-sm text-neutral-500 dark:text-neutral-400">Comparativa visual de ingresos y gastos diarios
            </p>
        </div>

        <div class="h-64 flex items-end justify-between gap-2">
            @php
                $maxValue = max(
                    collect($chartData)->max('income') ?? 0,
                    collect($chartData)->max('expense') ?? 0,
                    1
                );
            @endphp

            @if(count($chartData) > 0)
                @foreach($chartData as $data)
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-full flex flex-col items-center gap-1" style="height: 200px;">
                            <!-- Gasto (rojo) -->
                            <div class="w-full bg-alert-red rounded-t transition-all duration-500 hover:bg-alert-red-hover"
                                style="height: {{ ($data['expense'] / $maxValue) * 100 }}%"
                                title="Gasto: ₳{{ number_format($data['expense'], 2) }}"></div>

                            <!-- Ingreso (verde) -->
                            <div class="w-full bg-aulachain-green rounded-t transition-all duration-500 hover:bg-aulachain-green-hover"
                                style="height: {{ ($data['income'] / $maxValue) * 100 }}%"
                                title="Ingreso: ₳{{ number_format($data['income'], 2) }}"></div>
                        </div>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 text-center">
                            {{ \Carbon\Carbon::parse($data['date'])->format('d/m') }}
                        </p>
                    </div>
                @endforeach
            @else
                <div class="w-full text-center py-12 text-neutral-500">
                    <p>No hay datos suficientes para mostrar la gráfica</p>
                </div>
            @endif
        </div>

        <div class="mt-4 flex items-center justify-center gap-6 text-sm">
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 bg-aulachain-green rounded"></div>
                <span class="text-neutral-600 dark:text-neutral-400">Ingresos</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 bg-alert-red rounded"></div>
                <span class="text-neutral-600 dark:text-neutral-400">Gastos</span>
            </div>
        </div>
    </flux:card>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Transactions List -->
        <div class="lg:col-span-2 space-y-4">
            <div class="flex items-center justify-between px-2">
                <h3 class="text-lg font-bold text-neutral-800 dark:text-neutral-200">Historial de Transacciones</h3>
            </div>

            <flux:card class="divide-y divide-neutral-100 dark:divide-neutral-800">
                @forelse($transactions as $tx)
                    <div
                        class="p-4 flex items-center justify-between hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition-colors">
                        <div class="flex items-center gap-4 flex-1">
                            <div @class([
                                'p-2 rounded-lg shrink-0',
                                'bg-aulachain-green/10 text-aulachain-green' => $tx->amount > 0,
                                'bg-alert-red/10 text-alert-red' => ($tx->amount < 0 && $tx->type !== 'tax'),
                                'bg-academic-purple/10 text-academic-purple' => $tx->type === 'tax',
                            ])>
                                @if($tx->type === 'income')
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                                    </svg>
                                @elseif($tx->type === 'expense' || $tx->type === 'tax')
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" />
                                    </svg>
                                @elseif($tx->type === 'p2p')
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-neutral-800 dark:text-neutral-200 truncate">
                                    {{ $tx->description }}
                                </p>
                                <p class="text-xs text-neutral-500">{{ $tx->created_at->diffForHumans() }} • <span
                                        class="capitalize">{{ $tx->type }}</span></p>
                            </div>
                        </div>
                        <div @class([
                            'text-sm font-bold shrink-0 ml-4',
                            'text-aulachain-green' => $tx->amount > 0,
                            'text-alert-red' => ($tx->amount < 0 && $tx->type !== 'tax'),
                            'text-academic-purple' => $tx->type === 'tax',
                        ])>
                            {{ $tx->amount > 0 ? '+' : '' }}{{ number_format($tx->amount, 2) }} ₳
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center text-neutral-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-12 mx-auto mb-3 opacity-20">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                        </svg>
                        <p>No hay transacciones aún.</p>
                    </div>
                @endforelse
            </flux:card>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Proyecciones -->
            <flux:card>
                <h4 class="text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-4">Proyecciones de Ahorro</h4>
                <div class="space-y-4">
                    <div
                        class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <p class="text-xs text-blue-700 dark:text-blue-300 mb-1">En 4 semanas</p>
                        <p class="text-lg font-bold text-blue-900 dark:text-blue-200">₳
                            {{ number_format($projection4Weeks, 2) }}
                        </p>
                        <p class="text-[10px] text-blue-600 dark:text-blue-400 mt-1">+₳
                            {{ number_format($projection4Weeks - $balance, 2) }} estimado
                        </p>
                    </div>
                    <div
                        class="p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg border border-purple-200 dark:border-purple-800">
                        <p class="text-xs text-purple-700 dark:text-purple-300 mb-1">En 8 semanas</p>
                        <p class="text-lg font-bold text-purple-900 dark:text-purple-200">₳
                            {{ number_format($projection8Weeks, 2) }}
                        </p>
                        <p class="text-[10px] text-purple-600 dark:text-purple-400 mt-1">+₳
                            {{ number_format($projection8Weeks - $balance, 2) }} estimado
                        </p>
                    </div>
                </div>
            </flux:card>

            <!-- Objetivos de Ahorro -->
            <flux:card>
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-sm font-bold text-neutral-700 dark:text-neutral-300">Mis Objetivos</h4>
                    <livewire:bank.create-savings-goal />
                </div>

                <div class="space-y-3">
                    @forelse($savingsGoals as $goal)
                        <div
                            class="p-3 bg-neutral-50 dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700">
                            <div class="flex items-center justify-between mb-2">
                                <h5 class="text-sm font-bold text-neutral-900 dark:text-white">{{ $goal->name }}</h5>
                                @if($goal->isNearGoal())
                                    <span
                                        class="px-2 py-0.5 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 rounded text-xs font-bold">
                                        ¡Cerca!
                                    </span>
                                @endif
                            </div>
                            <div class="w-full bg-neutral-200 dark:bg-neutral-700 rounded-full h-2 mb-2">
                                <div class="bg-emerald-500 rounded-full h-2 transition-all duration-500"
                                    style="width: {{ min($goal->progress_percentage, 100) }}%"></div>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="text-neutral-600 dark:text-neutral-400">
                                    ₳ {{ number_format($goal->current_amount, 2) }} / ₳
                                    {{ number_format($goal->target_amount, 2) }}
                                </span>
                                <span class="font-bold text-emerald-600 dark:text-emerald-400">
                                    {{ round($goal->progress_percentage) }}%
                                </span>
                            </div>
                            @if($goal->target_date)
                                <p class="text-[10px] text-neutral-500 dark:text-neutral-400 mt-1">
                                    {{ $goal->days_remaining !== null ? ($goal->days_remaining > 0 ? $goal->days_remaining . ' días restantes' : '¡Tiempo cumplido!') : '' }}
                                </p>
                            @endif
                        </div>
                    @empty
                        <p class="text-sm text-neutral-500 dark:text-neutral-400 text-center py-4">
                            No tienes objetivos de ahorro aún
                        </p>
                    @endforelse
                </div>
            </flux:card>

            <!-- Módulo SAT -->
            <flux:card>
                <h4 class="text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-4">Módulo SAT: Educación Fiscal
                </h4>
                <div class="space-y-4">
                    <div
                        class="flex justify-between items-end border-b border-neutral-200 dark:border-neutral-800 pb-2">
                        <span class="text-xs text-neutral-500">Retención Automática</span>
                        <span class="text-sm font-bold text-red-500">5%</span>
                    </div>
                    <p class="text-[11px] text-neutral-500 italic">
                        Cada AulaChain ganado contribuye con un 5% al fondo común de la clase.
                    </p>
                    <flux:button href="{{ route('sat-education.index') }}" variant="ghost" size="sm" class="w-full">
                        Aprender sobre SAT
                    </flux:button>
                </div>
            </flux:card>

            <!-- Transferencias P2P -->
            <livewire:bank.transfer-p2-p />
        </div>
    </div>
</div>