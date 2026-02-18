<?php

use Livewire\Volt\Component;
use App\Models\Question;
use App\Models\Exam;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;

new class extends Component {
    public Exam $exam;

    // Estado para edición
    public $editingQuestionId = null;
    public $showEditModal = false;

    #[Validate('required|string')]
    public $question_text = '';

    #[Validate('required|in:multiple_choice,true_false,short_answer')]
    public $type = 'multiple_choice';

    #[Validate('required|numeric|min:0')]
    public $points = 1;

    public $options = ['A' => '', 'B' => '', 'C' => '', 'D' => ''];
    public $correct_answer = '';

    #[Validate('nullable|string')]
    public $explanation = '';

    #[On('question-added')]
    public function refreshList()
    {
        $this->exam->refresh();
    }

    public function delete(Question $question)
    {
        if ($question->exam_id !== $this->exam->id) {
            return;
        }

        $question->delete();
        $this->refreshList();
        $this->dispatch('notify', ['message' => 'Pregunta eliminada', 'type' => 'success']);
    }

    public function edit(Question $question)
    {
        if ($question->exam_id !== $this->exam->id) {
            return;
        }

        $this->editingQuestionId = $question->id;
        $this->question_text = $question->question_text;
        $this->type = $question->type;
        $this->points = $question->points;
        $this->options = $question->options ?? ['A' => '', 'B' => '', 'C' => '', 'D' => ''];
        $this->correct_answer = $question->correct_answer;
        $this->explanation = $question->explanation ?? '';

        $this->showEditModal = true;
        $this->dispatch('open-modal', 'edit-question-modal');
    }

    public function updatedType()
    {
        // Resetear opciones cuando cambia el tipo en edición
        if ($this->type !== 'multiple_choice') {
            $this->options = ['A' => '', 'B' => '', 'C' => '', 'D' => ''];
        }
    }

    public function update()
    {
        $question = Question::find($this->editingQuestionId);

        if (!$question || $question->exam_id !== $this->exam->id) {
            return;
        }

        // Validaciones (igual que en AddQuestion)
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

        $question->update([
            'question_text' => $this->question_text,
            'type' => $this->type,
            'points' => $this->points,
            'options' => $this->type === 'multiple_choice' ? $this->options : null,
            'correct_answer' => $this->correct_answer,
            'explanation' => $this->explanation ?: null,
        ]);

        $this->showEditModal = false;
        $this->refreshList();
        $this->dispatch('close-modal', 'edit-question-modal');
        $this->dispatch('notify', ['message' => 'Pregunta actualizada', 'type' => 'success']);
    }

    public function cancelEdit()
    {
        $this->showEditModal = false;
        $this->reset(['editingQuestionId', 'question_text', 'type', 'points', 'options', 'correct_answer', 'explanation']);
        $this->dispatch('close-modal', 'edit-question-modal');
    }
};
?>

<div class="space-y-4">
    @forelse($exam->questions->sortBy('order') as $question)
        <div wire:key="question-{{ $question->id }}"
            class="p-4 border border-neutral-200 dark:border-neutral-700 rounded-lg group hover:border-blue-200 dark:hover:border-blue-800 transition-colors relative">

            <!-- Content -->
            <div class="space-y-3 lg:pr-24">
                <!-- Badges -->
                <div class="flex items-center gap-2 flex-wrap">
                    <flux:badge size="sm" color="blue">Pregunta {{ $question->order }}</flux:badge>
                    <flux:badge size="sm" color="zinc">{{ $question->points }} pts</flux:badge>
                    <flux:badge size="sm" variant="outline">{{ 
                                    match ($question->type) {
                'multiple_choice' => 'Opción Múltiple',
                'true_false' => 'Verdadero/Falso',
                'short_answer' => 'Respuesta Corta',
                default => $question->type
            }
                                }}</flux:badge>
                </div>

                <!-- Question text -->
                <p class="font-medium text-neutral-900 dark:text-white text-base sm:text-lg">{{ $question->question_text }}
                </p>

                <!-- Answer options/correct answer -->
                @if($question->type === 'multiple_choice' && $question->options)
                    <div class="ml-4 space-y-2">
                        @foreach($question->options as $key => $option)
                            <div
                                class="flex items-start gap-2 {{ $key === $question->correct_answer ? 'text-emerald-700 dark:text-emerald-400' : 'text-neutral-600 dark:text-neutral-400' }}">
                                <span
                                    class="font-bold border rounded px-1.5 text-xs shrink-0 mt-0.5 {{ $key === $question->correct_answer ? 'border-emerald-500 bg-emerald-50 dark:bg-emerald-900/30' : 'border-neutral-300 dark:border-neutral-700' }}">{{ $key }})</span>
                                <span
                                    class="flex-1 wrap-break-word {{ $key === $question->correct_answer ? 'font-medium' : '' }}">{{ $option }}</span>
                                @if($key === $question->correct_answer)
                                    <flux:icon name="check-circle" class="size-4 text-emerald-500 shrink-0 mt-0.5" />
                                @endif
                            </div>
                        @endforeach
                    </div>
                @elseif($question->type === 'true_false')
                    <div class="ml-4 flex items-center gap-2 flex-wrap">
                        <span class="text-sm text-neutral-500">Respuesta:</span>
                        <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $question->correct_answer }}</span>
                    </div>
                @else
                    <div class="ml-4 flex items-center gap-2 flex-wrap">
                        <span class="text-sm text-neutral-500">Respuesta correcta:</span>
                        <span
                            class="font-mono bg-neutral-100 dark:bg-neutral-800 px-2 py-0.5 rounded text-neutral-900 dark:text-white break-all text-sm">{{ $question->correct_answer }}</span>
                    </div>
                @endif

                <!-- Explanation -->
                @if($question->explanation)
                    <div
                        class="p-2 bg-blue-50 dark:bg-blue-900/10 rounded text-sm text-blue-800 dark:text-blue-200 border border-blue-100 dark:border-blue-800/30">
                        <strong>Explicación:</strong> {{ $question->explanation }}
                    </div>
                @endif
            </div>

            <!-- Action buttons - below content on mobile, floating top-right on desktop -->
            <div
                class="flex gap-2 mt-4 justify-end lg:absolute lg:top-4 lg:right-4 lg:mt-0 lg:opacity-0 lg:group-hover:opacity-100 transition-opacity">
                <flux:button wire:click="edit({{ $question->id }})" variant="ghost" size="sm" icon="pencil-square" />
                <x-flux.confirm-delete-modal
                    :name="'delete-question-'.$question->id"
                    title="Eliminar pregunta"
                    message="¿Estás seguro de eliminar esta pregunta? Esta acción no se puede deshacer."
                >
                    <x-slot:trigger>
                        <flux:button variant="ghost" size="sm" icon="trash" class="text-red-500 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-950" />
                    </x-slot:trigger>
                    <flux:button variant="danger" wire:click="delete({{ $question->id }})">Eliminar</flux:button>
                </x-flux.confirm-delete-modal>
            </div>
        </div>
    @empty
        <div class="text-center py-12 border-2 border-dashed border-neutral-200 dark:border-neutral-700 rounded-xl">
            <div
                class="mx-auto size-12 rounded-full bg-neutral-100 dark:bg-neutral-800 flex items-center justify-center mb-3">
                <flux:icon name="question-mark-circle" class="size-6 text-neutral-400" />
            </div>
            <p class="font-medium text-neutral-600 dark:text-neutral-300">No hay preguntas aún</p>
            <p class="text-xs text-neutral-500 mt-1">Usa el botón "Agregar Pregunta" para comenzar</p>
        </div>
    @endforelse

    <!-- Modal de Edición -->
    <flux:modal name="edit-question-modal" class="md:w-2xl text-left" :show="$showEditModal">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Editar Pregunta</flux:heading>
                <flux:subheading>Modifica los detalles de la pregunta.</flux:subheading>
            </div>

            <form wire:submit="update" class="space-y-6">
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
                        <flux:button variant="ghost" wire:click="cancelEdit" type="button">Cancelar</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">Guardar Cambios</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <!-- Hidden trigger for edit modal -->
    <flux:modal.trigger name="edit-question-modal" class="hidden">
        <button id="edit-modal-trigger">Open</button>
    </flux:modal.trigger>

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('open-modal', (params) => {
                if (params[0] === 'edit-question-modal') {
                    document.getElementById('edit-modal-trigger')?.click();
                }
            });

            Livewire.on('close-modal', (params) => {
                // Find all possible close buttons or use Flux helper
                if (window.Flux && window.Flux.modals) {
                    window.Flux.modals[params[0]]?.close();
                }

                const modalEl = document.querySelector(`[name="${params[0]}"]`) || document.getElementById(params[0]);
                if (modalEl) {
                    // Try internal close click
                    modalEl.querySelector('[data-flux-close]')?.click();
                    // Try dialog close
                    if (modalEl.close) modalEl.close();
                    // Custom event
                    modalEl.dispatchEvent(new CustomEvent('close'));
                }
            });
        });
    </script>
</div>