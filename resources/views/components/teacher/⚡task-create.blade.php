<?php

use Livewire\Volt\Component;
use App\Models\Task;
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

        Task::create([
            'title' => $this->title,
            'description' => $this->description,
            'difficulty' => $this->difficulty,
            'ac_reward' => $this->ac_reward,
            'due_date' => $this->due_date ?: null,
        ]);

        $this->dispatch('task-created');
        
        return redirect()->route('teacher.tasks');
    }
};
?>

<div class="max-w-2xl mx-auto">
    <x-flux:card class="space-y-6">
        <div>
            <h2 class="text-xl font-bold text-neutral-900 dark:text-white">Nueva Tarea Educativa</h2>
            <p class="text-sm text-neutral-500">Asigna trabajo y define la recompensa en AulaChain.</p>
        </div>

        <form wire:submit="save" class="space-y-4">
            <x-flux:input wire:model="title" label="Título de la Tarea" placeholder="Ej: Ensayo sobre Historia de México" />
            
            <x-flux:textarea wire:model="description" label="Descripción / Instrucciones" placeholder="Detalla lo que el estudiante debe realizar..." rows="4" />

            <div class="grid grid-cols-2 gap-4">
                <x-flux:select wire:model.live="difficulty" label="Nivel de Dificultad">
                    <option value="basic">Básica (15 ₳)</option>
                    <option value="intermediate">Intermedia (35 ₳)</option>
                    <option value="advanced">Avanzada (60 ₳)</option>
                    <option value="excellence">Excelencia (+85 ₳)</option>
                </x-flux:select>

                <x-flux:input wire:model="ac_reward" type="number" label="Recompensa AulaChain (₳)" />
            </div>

            <x-flux:input wire:model="due_date" type="datetime-local" label="Fecha de Entrega" />

            <div class="flex justify-end gap-3 pt-4">
                <x-flux:button variant="ghost" href="{{ route('teacher.tasks') }}">Cancelar</x-flux:button>
                <x-flux:button type="submit" variant="primary">Crear Tarea y Asignar AC</x-flux:button>
            </div>
        </form>
    </x-flux:card>
</div>