<?php

use Livewire\Volt\Component;
use App\Services\EconomyService;
use App\Models\ExamAttempt;

new class extends Component {
    public $question;
    public $attempt;
    public $hintUsed = false;
    public $hintText = '';

    public function mount()
    {
        // Verificar si ya se usó pista para esta pregunta
        $metadata = $this->attempt->metadata ?? [];
        if (isset($metadata['hints'][$this->question->id])) {
            $this->hintUsed = true;
            $this->hintText = $metadata['hint_texts'][$this->question->id] ?? 'Pista ya utilizada.';
        }
    }

    public function useHint()
    {
        if ($this->attempt->hints_used >= 3) {
            $this->dispatch('notify', ['message' => 'Ya has usado el máximo de pistas (3)', 'type' => 'error']);
            return;
        }

        $costs = [15, 25, 40];
        $cost = $costs[$this->attempt->hints_used] ?? 40;

        try {
            $economy = app(EconomyService::class);
            $economy->debit(
                auth()->user(),
                (float) $cost,
                "Pista de examen - Pregunta #{$this->question->order}",
                'expense'
            );

            $this->attempt->increment('hints_used');
            $this->hintUsed = true;

            // Generar pista según tipo de pregunta
            $this->hintText = $this->generateHint();

            // Actualizar metadata
            $metadata = $this->attempt->metadata ?? [];
            if (!isset($metadata['hints'])) {
                $metadata['hints'] = [];
            }
            if (!isset($metadata['hint_texts'])) {
                $metadata['hint_texts'] = [];
            }
            $metadata['hints'][$this->question->id] = true;
            $metadata['hint_texts'][$this->question->id] = $this->hintText;
            $this->attempt->update(['metadata' => $metadata]);

            // Actualizar input hidden y UI global
            $this->dispatch('hint-used', ['hintsUsed' => $this->attempt->hints_used]);
            $this->dispatch('refresh-hints-counter', hintsUsed: $this->attempt->hints_used);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            if (str_contains($message, 'Saldo insuficiente')) {
                $message = "No tienes suficientes AulaChain (AC) para esta pista. ¡Ve a la tienda para conseguir más!";
            }
            $this->dispatch('notify', ['message' => $message, 'type' => 'error']);
        }
    }

    protected function generateHint()
    {
        if ($this->question->type === 'multiple_choice') {
            return $this->generateMultipleChoiceHint();
        }

        if ($this->question->type === 'true_false') {
            return "Pista: Analiza cuidadosamente la afirmación. A veces un solo detalle puede cambiar la veracidad completa.";
        }

        return "Pista: Enfócate en la palabra clave o el concepto principal de la pregunta para formular tu respuesta.";
    }

    protected function generateMultipleChoiceHint()
    {
        $hintNumber = $this->attempt->hints_used;
        $hints = [
            1 => "Orientación: La respuesta se relaciona con el concepto principal mencionado en la pregunta.",
            2 => "Eliminación: Revisa las opciones y descarta las que claramente no tienen relación.",
            3 => "Ejemplo: Piensa en un ejemplo práctico que ilustre el concepto correcto.",
        ];

        return $hints[min($hintNumber, 3)] ?? $hints[1];
    }
};
?>

<div>
    @if(!$hintUsed && $attempt->hints_used < 3)
        <button type="button" wire:click="useHint"
            class="w-full flex items-center justify-between p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-5 text-blue-600 dark:text-blue-400">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                </svg>
                <span class="text-sm font-medium text-blue-900 dark:text-blue-200">Usar Pista</span>
            </div>
            <div class="text-right">
                @php
                    $costs = [15, 25, 40];
                    $currentCost = $costs[$attempt->hints_used] ?? 15;
                @endphp
                <p class="text-xs text-blue-700 dark:text-blue-300">Costo: ₳ {{ $currentCost }}</p>
                <p class="text-[10px] text-blue-600 dark:text-blue-400">Penalización: -2%</p>
            </div>
        </button>
    @elseif($hintUsed)
        <div class="p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
            <p class="text-sm font-medium text-yellow-900 dark:text-yellow-200 mb-1">Pista Usada:</p>
            <p class="text-xs text-yellow-800 dark:text-yellow-300">{{ $hintText }}</p>
        </div>
    @else
        <div class="p-3 bg-neutral-50 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg">
            <p class="text-xs text-neutral-500 dark:text-neutral-400">Ya has usado el máximo de pistas (3)</p>
        </div>
    @endif
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('hint-used', (data) => {
            const input = document.getElementById('hints-used-input');
            if (input) {
                input.value = data.hintsUsed;
            }
        });
    });
</script>