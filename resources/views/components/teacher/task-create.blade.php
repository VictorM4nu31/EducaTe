<?php

use Livewire\Volt\Component;
use App\Models\Task;
use App\Models\Group;
use App\Models\TaskAssignment;
use Livewire\Attributes\Validate;

new class extends Component
{
    #[Validate('required|string|min:3')]
    public $title = '';

    #[Validate('nullable|string')]
    public $description = '';

    #[Validate('required|in:basic,intermediate,advanced,excellence')]
    public $difficulty = 'basic';

    #[Validate('required|numeric|min:0')]
    public $ac_reward = 15;

    #[Validate('nullable|date')]
    public $due_date = '';

    #[Validate('nullable|string')]
    public $instructions = '';

    public $selectedGroups = [];

    public function mount()
    {
        $this->groups = auth()->user()->taughtGroups()->where('is_active', true)->get();
    }

    public function updatedDifficulty($value)
    {
        $rewards = [
            'basic' => 15,
            'intermediate' => 35,
            'advanced' => 60,
            'excellence' => 85,
        ];

        $this->ac_reward = $rewards[$value] ?? 15;
    }

    public function save()
    {
        $this->validate();

        $task = Task::create([
            'title' => $this->title,
            'description' => $this->description,
            'instructions' => $this->instructions,
            'difficulty' => $this->difficulty,
            'ac_reward' => $this->ac_reward,
            'due_date' => $this->due_date ?: null,
            'created_by' => auth()->id(),
        ]);

        // Asignar a grupos seleccionados
        foreach ($this->selectedGroups as $groupId) {
            TaskAssignment::create([
                'task_id' => $task->id,
                'group_id' => $groupId,
            ]);
        }

        $this->dispatch('task-created');
        
        return redirect()->route('teacher.tasks')->with('success', 'Tarea creada y asignada exitosamente');
    }
};
?>

<div class="max-w-2xl mx-auto">
    <flux:card class="space-y-6">
        <div>
            <h2 class="text-xl font-bold text-neutral-900 dark:text-white">Nueva Tarea Educativa</h2>
            <p class="text-sm text-neutral-500">Asigna trabajo y define la recompensa en AulaChain.</p>
        </div>

        <form wire:submit="save" class="space-y-4">
            <flux:input wire:model="title" label="Título de la Tarea" placeholder="Ej: Ensayo sobre Historia de México" />
            
            <flux:textarea wire:model="description" label="Descripción / Instrucciones" placeholder="Detalla lo que el estudiante debe realizar..." rows="4" />

            <div class="grid grid-cols-2 gap-4">
                <flux:select wire:model.live="difficulty" label="Nivel de Dificultad">
                    <option value="basic">Básica (15 ₳)</option>
                    <option value="intermediate">Intermedia (35 ₳)</option>
                    <option value="advanced">Avanzada (60 ₳)</option>
                    <option value="excellence">Excelencia (+85 ₳)</option>
                </flux:select>

                <flux:input wire:model="ac_reward" type="number" label="Recompensa AulaChain (₳)" />
            </div>

            <flux:input wire:model="due_date" type="datetime-local" label="Fecha de Entrega" />

            <flux:textarea wire:model="instructions" label="Instrucciones Adicionales" placeholder="Instrucciones detalladas para los estudiantes..." rows="3" />

            @if($this->groups->count() > 0)
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Asignar a Clases</label>
                    <div class="space-y-2">
                        @foreach($this->groups as $group)
                            <label class="flex items-center gap-2 p-2 rounded-lg hover:bg-neutral-50 dark:hover:bg-neutral-800 cursor-pointer">
                                <input type="checkbox" wire:model="selectedGroups" value="{{ $group->id }}" class="rounded border-neutral-300">
                                <div class="flex-1">
                                    <span class="font-medium text-neutral-900 dark:text-white">{{ $group->name }}</span>
                                    @if($group->subject)
                                        <span class="text-xs text-neutral-500 dark:text-neutral-400 ml-2">{{ $group->subject }}</span>
                                    @endif
                                </div>
                                <span class="text-xs text-neutral-500 dark:text-neutral-400">{{ $group->students_count }} estudiantes</span>
                            </label>
                        @endforeach
                    </div>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400">Selecciona las clases a las que se asignará esta tarea</p>
                </div>
            @else
                <div class="p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-200 dark:border-yellow-800">
                    <p class="text-sm text-yellow-800 dark:text-yellow-200">
                        No tienes clases creadas. <a href="{{ route('teacher.groups.create') }}" class="underline font-medium">Crea una clase</a> para poder asignar tareas.
                    </p>
                </div>
            @endif

            <div class="flex justify-end gap-3 pt-4">
                <flux:button variant="ghost" href="{{ route('teacher.tasks') }}">Cancelar</flux:button>
                <flux:button type="submit" variant="primary" @if($this->groups->count() === 0) disabled @endif>
                    Crear Tarea y Asignar
                </flux:button>
            </div>
        </form>
    </flux:card>
</div>