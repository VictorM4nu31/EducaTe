<?php

use App\Models\Task;
use App\Models\TaskAssignment;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component
{
    public Task $task;

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
    public $groups;

    public function mount(Task $task)
    {
        $this->task = $task;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->difficulty = $task->difficulty;
        $this->ac_reward = $task->ac_reward;
        $this->due_date = $task->due_date ? $task->due_date->format('Y-m-d\TH:i') : '';
        $this->instructions = $task->instructions;
        
        $this->selectedGroups = $task->assignments()->pluck('group_id')->toArray();
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

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'instructions' => $this->instructions,
            'difficulty' => $this->difficulty,
            'ac_reward' => $this->ac_reward,
            'due_date' => $this->due_date ?: null,
        ];

        if (is_null($this->task->created_by)) {
            $data['created_by'] = auth()->id();
        }

        $this->task->update($data);

        // Actualizar asignaciones
        $this->task->assignments()->delete();
        foreach ($this->selectedGroups as $groupId) {
            TaskAssignment::create([
                'task_id' => $this->task->id,
                'group_id' => $groupId,
            ]);
        }

        return redirect()->route('teacher.tasks')->with('success', 'Tarea actualizada exitosamente');
    }
};
?>

<div class="max-w-2xl mx-auto">
    <flux:card class="space-y-6">
        <div>
            <h2 class="text-xl font-bold text-neutral-900 dark:text-white">Editar Tarea</h2>
            <p class="text-sm text-neutral-500">Modifica los detalles de la actividad académica.</p>
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
                                <input type="checkbox" wire:model="selectedGroups" value="{{ $group->id }}" @checked(in_array($group->id, $selectedGroups)) class="rounded border-neutral-300">
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
                </div>
            @endif

            <div class="flex justify-end gap-3 pt-4">
                <flux:button variant="ghost" href="{{ route('teacher.tasks') }}">Cancelar</flux:button>
                <flux:button type="submit" variant="primary">
                    Guardar Cambios
                </flux:button>
            </div>
        </form>
    </flux:card>
</div>
