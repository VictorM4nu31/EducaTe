<?php

use Livewire\Volt\Component;
use App\Models\Question;
use Livewire\Attributes\Validate;

new class extends Component {
    public $exam;
    public $showForm = false;

    #[Validate('required|string')]
    public $question_text = '';

    #[Validate('required|in:multiple_choice,true_false,short_answer')]
    public $type = 'multiple_choice';

    #[Validate('required|numeric|min:0')]
    public $points = 1;

    public $options = ['A' => '', 'B' => '', 'C' => '', 'D' => ''];
    public $correct_answer = '';

    public function updatedType()
    {
        // Resetear opciones cuando cambia el tipo
        if ($this->type !== 'multiple_choice') {
            $this->options = ['A' => '', 'B' => '', 'C' => '', 'D' => ''];
            $this->correct_answer = '';
        }
    }

    #[Validate('nullable|string')]
    public $explanation = '';

    public function save()
    {
        if ($this->type === 'multiple_choice') {
            $this->validate([
                'options.A' => 'required|string',
                'options.B' => 'required|string',
                'options.C' => 'required|string',
                'options.D' => 'required|string',
                'correct_answer' => 'required|in:A,B,C,D',
            ]);
        } elseif ($this->type === 'true_false') {
            $this->validate([
                'correct_answer' => 'required|in:Verdadero,Falso',
            ]);
        } else {
            $this->validate([
                'correct_answer' => 'required|string',
            ]);
        }

        $this->validate();

        Question::create([
            'exam_id' => $this->exam->id,
            'question_text' => $this->question_text,
            'type' => $this->type,
            'points' => $this->points,
            'order' => $this->exam->questions()->max('order') + 1,
            'options' => $this->type === 'multiple_choice' ? $this->options : null,
            'correct_answer' => $this->correct_answer,
            'explanation' => $this->explanation ?: null,
        ]);

        $this->reset(['question_text', 'type', 'points', 'options', 'correct_answer', 'explanation', 'showForm']);
        $this->options = ['A' => '', 'B' => '', 'C' => '', 'D' => ''];
        $this->dispatch('question-added');
        $this->dispatch('close-modal', 'add-question-modal');
        $this->dispatch('notify', ['message' => 'Pregunta agregada exitosamente', 'type' => 'success']);
    }
};
?>

<div>
    <flux:modal.trigger name="add-question-modal">
        <flux:button variant="primary" icon="plus" class="w-full sm:w-auto">
            Agregar Pregunta
        </flux:button>
    </flux:modal.trigger>

    <flux:modal name="add-question-modal" class="md:w-2xl text-left">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Nueva Pregunta</flux:heading>
                <flux:subheading>Agrega una nueva pregunta al examen.</flux:subheading>
            </div>

            <form wire:submit="save" class="space-y-6">
                <!-- Tipo y Puntos -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <flux:select label="Tipo de Pregunta" wire:model.live="type"
                            placeholder="Selecciona el tipo...">
                            <flux:select.option value="multiple_choice">Opción Múltiple</flux:select.option>
                            <flux:select.option value="true_false">Verdadero/Falso</flux:select.option>
                            <flux:select.option value="short_answer">Respuesta Corta</flux:select.option>
                        </flux:select>
                    </div>

                    <div>
                        <flux:input type="number" step="0.5" min="0" label="Puntos" wire:model="points" />
                    </div>
                </div>

                <!-- Texto de la Pregunta -->
                <flux:textarea label="Pregunta" wire:model="question_text" placeholder="Escribe la pregunta aquí..."
                    rows="3" />

                <flux:separator />

                <!-- Opciones / Respuesta Correcta -->
                <div>
                    <flux:heading size="md" class="mb-3">Respuesta</flux:heading>

                    @if($type === 'multiple_choice')
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 gap-3">
                                @foreach(['A', 'B', 'C', 'D'] as $key)
                                    <div class="flex items-center gap-2">
                                        <flux:badge size="sm">{{ $key }}</flux:badge>
                                        <div class="flex-1">
                                            <flux:input wire:model="options.{{ $key }}" placeholder="Opción {{ $key }}" />
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <flux:select label="Respuesta Correcta" wire:model="correct_answer"
                                placeholder="Selecciona la correcta">
                                <flux:select.option value="A">Opción A</flux:select.option>
                                <flux:select.option value="B">Opción B</flux:select.option>
                                <flux:select.option value="C">Opción C</flux:select.option>
                                <flux:select.option value="D">Opción D</flux:select.option>
                            </flux:select>
                        </div>
                    @elseif($type === 'true_false')
                        <flux:radio.group label="Respuesta Correcta" wire:model="correct_answer">
                            <flux:radio value="Verdadero" label="Verdadero" />
                            <flux:radio value="Falso" label="Falso" />
                        </flux:radio.group>
                    @else
                        <flux:input label="Respuesta Correcta (Texto Exacto)" wire:model="correct_answer"
                            placeholder="Escribe la respuesta correcta" />
                        <flux:text size="sm" class="mt-1">El alumno deberá escribir exactamente esto.</flux:text>
                    @endif
                </div>

                <flux:separator />

                <!-- Explicación -->
                <flux:textarea label="Explicación / Retroalimentación (Opcional)" wire:model="explanation"
                    placeholder="Explica por qué es la respuesta correcta..." rows="2" />

                <div class="flex gap-2 justify-end">
                    <flux:modal.close>
                        <flux:button variant="ghost" type="button">Cancelar</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">Guardar Pregunta</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>


    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('close-modal', (params) => {
                // Flux internal API or standard HTML dialog close
                const modal = document.querySelector(`[data-flux-modal="${params[0]}"]`) || document.getElementById(params[0]);
                if (modal && modal.close) {
                    modal.close();
                } else {
                    // Fallback for Flux: find the close button or trigger
                    // For now, let's assume Flux handles 'close' if we can access the component.
                    // Actually, if using name="add-question-modal", we can often use Alpine data.
                    // Let's try dispatching a custom event that Alpine can pick up if needed, 
                    // but simpler: Flux modals often have a `close()` method on the element instance if it's a dialog.
                }

                // Try Flux helper if available globally
                if (window.Flux && window.Flux.modals) {
                    window.Flux.modals[params[0]]?.close();
                }

                // Simplest: trigger the close button click
                document.querySelector(`[data-flux-modal="${params[0]}"] [data-flux-close]`)?.click();

                // Another attempt: dispatch 'close' event to the modal element
                const modalEl = document.querySelector(`flux-modal[name="${params[0]}"]`) || document.querySelector(`[name="${params[0]}"]`);
                if (modalEl) modalEl.dispatchEvent(new CustomEvent('close'));
            });
        });
    </script>
</div>