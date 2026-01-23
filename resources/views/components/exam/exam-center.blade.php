<?php

use Livewire\Volt\Component;
use App\Services\EconomyService;
use App\Models\Exam;

new class extends Component
{
    public $hintsUsed = 0;
    public $grade = 100;
    public $hintText = '';
    public $examStarted = false;

    public function startExam()
    {
        $this->examStarted = true;
    }

    public function useHint()
    {
        if ($this->hintsUsed >= 3) return;

        $costs = [
            1 => 15,
            2 => 25,
            3 => 40
        ];

        $penalty = 2; // -2% per hint
        $cost = $costs[$this->hintsUsed + 1];

        try {
            $economy = app(EconomyService::class);
            $economy->debit(auth()->user(), (float)$cost, "Pista de examen #".($this->hintsUsed + 1), 'expense');
            
            $this->hintsUsed++;
            $this->grade -= $penalty;
            $this->updateHintText();
            
            $this->dispatch('hint-purchased');
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => $e->getMessage(), 'type' => 'error']);
        }
    }

    protected function updateHintText()
    {
        $hints = [
            1 => 'Orientación: La respuesta se relaciona con el concepto de "Soberanía".',
            2 => 'Eliminación: No es la opción B ni la D.',
            3 => 'Ejemplo: Imagina que el pueblo decide sus propias leyes sin intervención externa.'
        ];

        $this->hintText = $hints[$this->hintsUsed];
    }
};
?>

<div class="max-w-3xl mx-auto space-y-6">
    @if(!$examStarted)
        <flux:card class="text-center py-12">
            <flux:icon icon="" class="size-16 mx-auto mb-4 text-blue-500 opacity-50" />
            <h2 class="text-2xl font-bold mb-2">Examen: Civismo y Responsabilidad</h2>
            <p class="text-neutral-500 mb-6">Puntos extra: 30 ₳ por calificación perfecta sin pistas.</p>
            <flux:button variant="primary" size="lg" wire:click="startExam">Comenzar Examen</flux:button>
        </flux:card>
    @else
        <div class="flex items-center justify-between px-2">
            <div class="flex items-center gap-4">
                <span class="text-sm font-medium text-neutral-500">Progreso:</span>
                <div class="w-32 h-2 bg-neutral-200 rounded-full overflow-hidden">
                    <div class="bg-blue-500 h-full" style="width: 25%"></div>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex flex-col items-end">
                    <span class="text-[10px] uppercase font-bold text-neutral-400">Calificación Max</span>
                    <span class="text-xl font-mono font-bold text-blue-600">{{ $grade }}%</span>
                </div>
            </div>
        </div>

        <flux:card class="space-y-8">
            <div class="space-y-4">
                <h3 class="text-lg font-bold">Pregunta 1 de 10</h3>
                <p class="text-neutral-800 dark:text-neutral-200 text-lg">¿Cuál es el principio fundamental que establece que el poder reside en el pueblo?</p>
                
                <div class="space-y-2">
                    <flux:button variant="ghost" class="w-full justify-start py-4">A) Democracia Representativa</flux:button>
                    <flux:button variant="ghost" class="w-full justify-start py-4">B) Monarquía Absoluta</flux:button>
                    <flux:button variant="ghost" class="w-full justify-start py-4">C) Soberanía Nacional</flux:button>
                    <flux:button variant="ghost" class="w-full justify-start py-4">D) Dictadura Militar</flux:button>
                </div>
            </div>

            <div class="pt-6 border-t border-neutral-100 dark:border-neutral-800">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex flex-col">
                        <span class="text-sm font-bold">Sistema de Pistas de AulaChain</span>
                        <span class="text-[11px] text-neutral-500">Pistas usadas: {{ $hintsUsed }} / 3 (Penalización: -{{ $hintsUsed * 2 }}%)</span>
                    </div>
                    
                    @if($hintsUsed < 3)
                        <flux:button 
                            variant="primary" 
                            size="sm" 
                            wire:click="useHint"
                            wire:confirm="¿Usar pista por {{ $hintsUsed == 0 ? 15 : ($hintsUsed == 1 ? 25 : 40) }} ₳? Esto restará 2% a tu calificación."
                        >
                            Comprar Pista ({{ $hintsUsed == 0 ? 15 : ($hintsUsed == 1 ? 25 : 40) }} ₳)
                        </flux:button>
                    @endif
                </div>

                @if($hintText)
                    <div class="p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-lg animate-in fade-in slide-in-from-top-2">
                        <div class="flex gap-3">
                            <flux:icon icon="" class="size-5 text-emerald-600" />
                            <p class="text-sm text-emerald-800 dark:text-emerald-300 font-medium">{{ $hintText }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </flux:card>
    @endif
</div>

