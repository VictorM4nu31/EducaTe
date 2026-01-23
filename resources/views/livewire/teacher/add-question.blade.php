<?php

use Livewire\Volt\Component;
use App\Models\Question;
use Livewire\Attributes\Validate;

new class extends Component
{
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
        $this->dispatch('notify', ['message' => 'Pregunta agregada exitosamente', 'type' => 'success']);
    }
};
?>

<div>
    @if(!$showForm)
        <flux:button wire:click="$set('showForm', true)" variant="primary" size="sm" icon="plus">
            Agregar Pregunta
        </flux:button>
    @else
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" wire:click="$set('showForm', false)">
            <div class="bg-white dark:bg-neutral-900 rounded-xl shadow-xl max-w-2xl w-full p-6 space-y-4 max-h-[90vh] overflow-y-auto" wire:click.stop>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white">Nueva Pregunta</h3>
                    <button wire:click="$set('showForm', false)" class="text-neutral-500 hover:text-neutral-700 dark:hover:text-neutral-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Texto de la Pregunta *</label>
                        <textarea 
                            wire:model="question_text"
                            rows="3"
                            class="w-full rounded-lg border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            placeholder="Escribe la pregunta aquí..."
                            required
                        ></textarea>
                        @error('question_text') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Tipo *</label>
                            <select 
                                wire:model.live="type"
                                class="w-full rounded-lg border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                required
                            >
                                <option value="multiple_choice">Opción Múltiple</option>
                                <option value="true_false">Verdadero/Falso</option>
                                <option value="short_answer">Respuesta Corta</option>
                            </select>
                            @error('type') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Puntos *</label>
                            <input 
                                type="number" 
                                wire:model="points"
                                min="0"
                                step="0.1"
                                class="w-full rounded-lg border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                required
                            />
                            @error('points') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    @if($type === 'multiple_choice')
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Opciones de Respuesta *</label>
                            @foreach(['A', 'B', 'C', 'D'] as $key)
                                <div class="flex items-center gap-2">
                                    <span class="w-8 text-sm font-bold text-neutral-600 dark:text-neutral-400">{{ $key }})</span>
                                    <input 
                                        type="text" 
                                        wire:model="options.{{ $key }}"
                                        class="flex-1 rounded-lg border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                        placeholder="Opción {{ $key }}"
                                        required
                                    />
                                </div>
                            @endforeach
                            <div class="mt-2">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Respuesta Correcta *</label>
                                <select 
                                    wire:model="correct_answer"
                                    class="w-full rounded-lg border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    required
                                >
                                    <option value="">Selecciona la respuesta correcta</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                </select>
                                @error('correct_answer') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    @else
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Respuesta Correcta *</label>
                            <input 
                                type="text" 
                                wire:model="correct_answer"
                                class="w-full rounded-lg border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                placeholder="Escribe la respuesta correcta"
                                required
                            />
                            @error('correct_answer') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Explicación (opcional)</label>
                        <textarea 
                            wire:model="explanation"
                            rows="2"
                            class="w-full rounded-lg border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            placeholder="Explicación de la respuesta correcta..."
                        ></textarea>
                        @error('explanation') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button 
                            type="button"
                            wire:click="$set('showForm', false)"
                            class="flex-1 px-4 py-2 border border-neutral-300 dark:border-neutral-700 rounded-lg text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors"
                        >
                            Cancelar
                        </button>
                        <button 
                            type="submit"
                            class="flex-1 px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors font-medium"
                        >
                            Agregar Pregunta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
