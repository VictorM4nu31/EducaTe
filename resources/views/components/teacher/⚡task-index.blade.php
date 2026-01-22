<?php

use Livewire\Volt\Component;
use App\Models\Task;

new class extends Component
{
    public function with()
    {
        return [
            'tasks' => Task::latest()->get(),
        ];
    }

    public function deleteTask(Task $task)
    {
        $task->delete();
    }
};
?>

<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Gestión de Tareas</h2>
            <p class="text-sm text-neutral-500">Crea y supervisa las actividades académicas de tus grupos.</p>
        </div>
        <x-flux:button variant="primary" icon="plus" href="{{ route('teacher.tasks.create') }}">Nueva Tarea</x-flux:button>
    </div>

    <div class="bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800 overflow-hidden shadow-sm">
        <x-flux:table>
            <x-flux:table.columns>
                <x-flux:table.column>Tarea</x-flux:table.column>
                <x-flux:table.column>Dificultad</x-flux:table.column>
                <x-flux:table.column>Recompensa</x-flux:table.column>
                <x-flux:table.column>Entrega</x-flux:table.column>
                <x-flux:table.column></x-flux:table.column>
            </x-flux:table.columns>

            <x-flux:table.rows>
                @forelse($tasks as $task)
                    <x-flux:table.row :key="$task->id">
                        <x-flux:table.cell>
                            <span class="font-bold text-neutral-800 dark:text-neutral-200">{{ $task->title }}</span>
                        </x-flux:table.cell>

                        <x-flux:table.cell>
                            <x-flux:badge @class([
                                'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' => $task->difficulty === 'basic',
                                'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300' => $task->difficulty === 'intermediate',
                                'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-300' => $task->difficulty === 'advanced',
                                'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300' => $task->difficulty === 'excellence',
                            ]) size="sm">
                                {{ ucfirst($task->difficulty) }}
                            </x-flux:badge>
                        </x-flux:table.cell>

                        <x-flux:table.cell>
                            <span class="font-mono font-bold text-emerald-600">₳ {{ number_format($task->ac_reward, 0) }}</span>
                        </x-flux:table.cell>

                        <x-flux:table.cell>
                            <span class="text-xs text-neutral-500">
                                {{ $task->due_date ? $task->due_date->format('d M, H:i') : 'Sin fecha limit' }}
                            </span>
                        </x-flux:table.cell>

                        <x-flux:table.cell class="flex justify-end gap-2">
                            <x-flux:button variant="ghost" size="sm" icon="pencil-square" />
                            <x-flux:button variant="ghost" size="sm" icon="trash" wire:click="deleteTask({{ $task->id }})" wire:confirm="¿Estás seguro de eliminar esta tarea?" />
                        </x-flux:table.cell>
                    </x-flux:table.row>
                @empty
                    <x-flux:table.row>
                        <x-flux:table.cell colspan="5" class="text-center py-12 text-neutral-500">
                            No has creado tareas todavía.
                        </x-flux:table.cell>
                    </x-flux:table.row>
                @endforelse
            </x-flux:table.rows>
        </x-flux:table>
    </div>
</div>