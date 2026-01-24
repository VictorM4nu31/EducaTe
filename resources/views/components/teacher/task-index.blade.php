<?php

use Livewire\Volt\Component;
use App\Models\Task;
use App\Models\Group;

new class extends Component
{
    public function with()
    {
        return [
            'groups' => Group::where('teacher_id', auth()->id())
                ->with(['tasks' => function($query) {
                    $query->latest();
                }])
                ->get(),
            // También obtenemos tareas sin asignar por si acaso
            'unassignedTasks' => Task::where('created_by', auth()->id())
                ->doesntHave('groups')
                ->latest()
                ->get()
        ];
    }

    public function deleteTask(Task $task)
    {
        $task->delete();
    }
};
?>

<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Gestión de Tareas</h2>
            <p class="text-sm text-neutral-500">Crea y supervisa las actividades académicas organizadas por clase.</p>
        </div>
        <flux:button variant="primary" icon="plus" href="{{ route('teacher.tasks.create') }}">Nueva Tarea</flux:button>
    </div>

    @forelse($groups as $group)
        <div class="space-y-3">
            <div class="flex items-center gap-2 px-1">
                <flux:icon icon="user-group" class="text-neutral-400" />
                <h3 class="text-lg font-bold text-neutral-800 dark:text-neutral-200">{{ $group->name }}</h3>
                <flux:badge size="sm" color="zinc">{{ $group->tasks->count() }} tareas</flux:badge>
            </div>

            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800 overflow-hidden shadow-sm">
                <flux:table>
                    <flux:table.columns>
                        <flux:table.column class="pl-6">Tarea</flux:table.column>
                        <flux:table.column>Dificultad</flux:table.column>
                        <flux:table.column>Recompensa</flux:table.column>
                        <flux:table.column>Entrega</flux:table.column>
                        <flux:table.column></flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @forelse($group->tasks as $task)
                            <flux:table.row :key="$task->id">
                                <flux:table.cell class="py-4 pl-6">
                                    <span class="font-bold text-neutral-800 dark:text-neutral-200">{{ $task->title }}</span>
                                </flux:table.cell>

                                <flux:table.cell class="py-4">
                                    <flux:badge @class([
                                        'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' => $task->difficulty === 'basic',
                                        'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' => $task->difficulty === 'intermediate',
                                        'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' => $task->difficulty === 'advanced',
                                        'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300' => $task->difficulty === 'excellence',
                                    ]) size="sm">
                                        {{ ucfirst($task->difficulty) }}
                                    </flux:badge>
                                </flux:table.cell>

                                <flux:table.cell class="py-4">
                                    <span class="font-mono font-bold text-aulachain-green">₳ {{ number_format($task->ac_reward, 0) }}</span>
                                </flux:table.cell>

                                <flux:table.cell class="py-4">
                                    <span class="text-xs text-neutral-500">
                                        {{ $task->due_date ? $task->due_date->format('d M, H:i') : 'Sin fecha limit' }}
                                    </span>
                                </flux:table.cell>

                                <flux:table.cell class="py-4 flex justify-end gap-2">
                                    <flux:button href="{{ route('teacher.tasks.submissions') }}" variant="ghost" size="sm" icon="document-check">
                                        Revisar
                                    </flux:button>
                                    <flux:button href="{{ route('teacher.tasks.edit', $task) }}" variant="ghost" size="sm" icon="pencil-square" />
                                    <flux:button variant="ghost" size="sm" icon="trash" wire:click="deleteTask({{ $task->id }})" wire:confirm="¿Estás seguro de eliminar esta tarea?" />
                                </flux:table.cell>
                            </flux:table.row>
                        @empty
                            <flux:table.row>
                                <flux:table.cell colspan="5" class="text-center py-6 text-neutral-500 text-sm">
                                    No hay tareas asignadas a este grupo.
                                </flux:table.cell>
                            </flux:table.row>
                        @endforelse
                    </flux:table.rows>
                </flux:table>
            </div>
        </div>
    @empty
        <div class="text-center py-12">
            <div class="bg-neutral-50 dark:bg-neutral-900 rounded-full p-4 inline-flex mb-4">
                <flux:icon icon="user-group" class="size-8 text-neutral-400" />
            </div>
            <h3 class="text-lg font-medium text-neutral-900 dark:text-white">No tienes grupos creados</h3>
            <p class="text-neutral-500 mt-1 max-w-sm mx-auto">Para empezar a asignar tareas, primero debes crear tus clases en la sección "Mis Clases".</p>
            <div class="mt-6">
                <flux:button href="{{ route('teacher.groups.index') }}" variant="primary">Ir a Mis Clases</flux:button>
            </div>
        </div>
    @endforelse

    @if($unassignedTasks->isNotEmpty())
        <div class="space-y-3 mt-12 pt-8 border-t border-neutral-200 dark:border-neutral-800">
            <div class="flex items-center gap-2 px-1">
                <flux:icon icon="inbox" class="text-neutral-400" />
                <h3 class="text-lg font-bold text-neutral-800 dark:text-neutral-200">Tareas sin Asignar</h3>
                <flux:badge size="sm" color="zinc">{{ $unassignedTasks->count() }}</flux:badge>
            </div>

            <div class="bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800 overflow-hidden shadow-sm opacity-75">
                <flux:table>
                    <flux:table.columns>
                        <flux:table.column class="pl-6">Tarea</flux:table.column>
                        <flux:table.column>Dificultad</flux:table.column>
                        <flux:table.column>Recompensa</flux:table.column>
                        <flux:table.column>Entrega</flux:table.column>
                        <flux:table.column></flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @foreach($unassignedTasks as $task)
                            <flux:table.row :key="$task->id">
                                <flux:table.cell class="py-4 pl-6">
                                    <span class="font-bold text-neutral-800 dark:text-neutral-200">{{ $task->title }}</span>
                                </flux:table.cell>
                                <flux:table.cell class="py-4">
                                    <flux:badge size="sm">{{ ucfirst($task->difficulty) }}</flux:badge>
                                </flux:table.cell>
                                <flux:table.cell class="py-4">
                                    <span class="font-mono font-bold text-aulachain-green">₳ {{ number_format($task->ac_reward, 0) }}</span>
                                </flux:table.cell>
                                <flux:table.cell class="py-4">
                                    <span class="text-xs text-neutral-500">
                                        {{ $task->due_date ? $task->due_date->format('d M, H:i') : 'Unknown' }}
                                    </span>
                                </flux:table.cell>
                                <flux:table.cell class="py-4 flex justify-end gap-2">
                                    <flux:button href="{{ route('teacher.tasks.edit', $task) }}" variant="ghost" size="sm" icon="pencil-square" />
                                    <flux:button variant="ghost" size="sm" icon="trash" wire:click="deleteTask({{ $task->id }})" wire:confirm="¿Borrar?" />
                                </flux:table.cell>
                            </flux:table.row>
                        @endforeach
                    </flux:table.rows>
                </flux:table>
            </div>
        </div>
    @endif
</div>