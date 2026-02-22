<?php

use Livewire\Volt\Component;
use App\Models\Task;
use App\Models\Group;

new class extends Component {
    public function with()
    {
        return [
            'groups' => Group::where('teacher_id', auth()->id())
                ->with([
                    'tasks' => function ($query) {
                        $query->latest();
                    }
                ])
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

<div class="space-y-10">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-teal-100 dark:bg-teal-900/30 rounded-lg">
                <flux:icon icon="academic-cap" class="size-8 text-teal-600 dark:text-teal-400" />
            </div>
            <div>
                <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Gestión de Tareas</h2>
                <p class="text-sm text-neutral-500">Crea y supervisa las actividades académicas organizadas por clase.
                </p>
            </div>
        </div>
        <flux:button variant="primary" icon="plus" href="{{ route('teacher.tasks.create') }}">Nueva Tarea</flux:button>
    </div>

    @forelse($groups as $group)
        <div class="space-y-4">
            <div class="flex items-center gap-2 px-1">
                <flux:icon icon="user-group" class="text-neutral-400" />
                <h3 class="text-lg font-bold text-neutral-800 dark:text-neutral-200">{{ $group->name }}</h3>
                <flux:badge size="sm" color="zinc">{{ $group->tasks->count() }} tareas</flux:badge>
            </div>

            <div class="space-y-4">
                @forelse($group->tasks as $task)
                    <div
                        class="bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800 p-5 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6 hover:border-neutral-300 dark:hover:border-neutral-700 transition-colors">
                        <!-- Task Info Columns -->
                        <div class="flex-1 grid grid-cols-2 md:grid-cols-4 gap-6">
                            <!-- Title -->
                            <div class="flex flex-col">
                                <span class="text-xs text-neutral-500 mb-1">Tarea</span>
                                <span class="font-bold text-neutral-900 dark:text-neutral-100 truncate"
                                    title="{{ $task->title }}">
                                    {{ $task->title }}
                                </span>
                            </div>

                            <!-- Difficulty -->
                            <div class="flex flex-col">
                                <span class="text-xs text-neutral-500 mb-1 flex items-center gap-1">
                                    <flux:icon icon="signal" class="size-3" />
                                    Dificultad
                                </span>
                                <div>
                                    <flux:badge @class([
                                        'bg-blue-50 text-blue-700 border-blue-100 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-800' => $task->difficulty === 'basic',
                                        'bg-sky-50 text-sky-700 border-sky-100 dark:bg-sky-900/30 dark:text-sky-300 dark:border-sky-800' => $task->difficulty === 'intermediate',
                                        'bg-orange-50 text-orange-700 border-orange-100 dark:bg-orange-900/30 dark:text-orange-300 dark:border-orange-800' => $task->difficulty === 'advanced',
                                        'bg-red-50 text-red-700 border-red-100 dark:bg-red-900/30 dark:text-red-300 dark:border-red-800' => $task->difficulty === 'excellence',
                                    ]) size="sm" class="border">
                                        {{ ucfirst($task->difficulty) }}
                                    </flux:badge>
                                </div>
                            </div>

                            <!-- Reward -->
                            <div class="flex flex-col">
                                <span class="text-xs text-neutral-500 mb-1 flex items-center gap-1">
                                    <flux:icon icon="banknotes" class="size-3" />
                                    Recompensa
                                </span>
                                <span class="font-mono font-bold text-teal-600 dark:text-teal-400 text-lg">
                                    ₳ {{ number_format($task->ac_reward, 0) }}
                                </span>
                            </div>

                            <!-- Due Date -->
                            <div class="flex flex-col">
                                <span class="text-xs text-neutral-500 mb-1 flex items-center gap-1">
                                    <flux:icon icon="calendar" class="size-3" />
                                    Entrega
                                </span>
                                <span class="text-sm text-neutral-700 dark:text-neutral-300">
                                    {{ $task->due_date ? $task->due_date->format('d M, H:i') : 'Sin fecha límite' }}
                                </span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div
                            class="flex items-center gap-3 pt-4 md:pt-0 border-t md:border-t-0 border-neutral-100 dark:border-neutral-800">
                            <flux:button href="{{ route('teacher.tasks.submissions') }}" variant="outline"
                                class="border-teal-600! text-teal-700! dark:text-teal-400! dark:border-teal-500! hover:bg-teal-50! dark:hover:bg-teal-900/20! w-full md:w-auto">
                                Revisar
                            </flux:button>

                            <div class="flex items-center gap-1">
                                <flux:button href="{{ route('teacher.tasks.edit', $task) }}" variant="ghost"
                                    icon="pencil-square" class="text-neutral-400 hover:text-neutral-600" />
                                <x-flux.confirm-delete-modal :name="'delete-task-' . $task->id" title="Eliminar tarea"
                                    message="¿Estás seguro de eliminar esta tarea? Esta acción no se puede deshacer.">
                                    <x-slot:trigger>
                                        <flux:button variant="ghost" icon="trash"
                                            class="text-neutral-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20" />
                                    </x-slot:trigger>
                                    <flux:button variant="danger" wire:click="deleteTask({{ $task->id }})">Eliminar
                                    </flux:button>
                                </x-flux.confirm-delete-modal>
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="text-center py-8 bg-neutral-50 dark:bg-neutral-900/50 rounded-xl border border-dashed border-neutral-200 dark:border-neutral-800">
                        <p class="text-neutral-500 text-sm">No hay tareas asignadas a este grupo.</p>
                    </div>
                @endforelse
            </div>
        </div>
    @empty
        <div class="text-center py-12">
            <div class="bg-neutral-50 dark:bg-neutral-900 rounded-full p-4 inline-flex mb-4">
                <flux:icon icon="user-group" class="size-8 text-neutral-400" />
            </div>
            <h3 class="text-lg font-medium text-neutral-900 dark:text-white">No tienes grupos creados</h3>
            <p class="text-neutral-500 mt-1 max-w-sm mx-auto">Para empezar a asignar tareas, primero debes crear tus clases
                en la sección "Mis Clases".</p>
            <div class="mt-6">
                <flux:button href="{{ route('teacher.groups.index') }}" variant="primary">Ir a Mis Clases</flux:button>
            </div>
        </div>
    @endforelse

    @if($unassignedTasks->isNotEmpty())
        <div class="space-y-4 mt-12 pt-8 border-t border-neutral-200 dark:border-neutral-800">
            <div class="flex items-center gap-2 px-1">
                <flux:icon icon="inbox" class="text-neutral-400" />
                <h3 class="text-lg font-bold text-neutral-800 dark:text-neutral-200">Tareas sin Asignar</h3>
                <flux:badge size="sm" color="zinc">{{ $unassignedTasks->count() }}</flux:badge>
            </div>

            <div class="space-y-4 opacity-75">
                @foreach($unassignedTasks as $task)
                    <div
                        class="bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800 p-5 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6 hover:border-neutral-300 dark:hover:border-neutral-700 transition-colors">
                        <!-- Task Info Columns -->
                        <div class="flex-1 grid grid-cols-2 md:grid-cols-4 gap-6">
                            <!-- Title -->
                            <div class="flex flex-col">
                                <span class="text-xs text-neutral-500 mb-1">Tarea</span>
                                <span class="font-bold text-neutral-900 dark:text-neutral-100 truncate"
                                    title="{{ $task->title }}">
                                    {{ $task->title }}
                                </span>
                            </div>

                            <!-- Difficulty -->
                            <div class="flex flex-col">
                                <span class="text-xs text-neutral-500 mb-1">Dificultad</span>
                                <div>
                                    <flux:badge size="sm"
                                        class="bg-neutral-100 text-neutral-600 border border-neutral-200 dark:bg-neutral-800 dark:text-neutral-400 dark:border-neutral-700">
                                        {{ ucfirst($task->difficulty) }}
                                    </flux:badge>
                                </div>
                            </div>

                            <!-- Reward -->
                            <div class="flex flex-col">
                                <span class="text-xs text-neutral-500 mb-1">Recompensa</span>
                                <span class="font-mono font-bold text-teal-600 dark:text-teal-400 text-lg">
                                    ₳ {{ number_format($task->ac_reward, 0) }}
                                </span>
                            </div>

                            <!-- Due Date -->
                            <div class="flex flex-col">
                                <span class="text-xs text-neutral-500 mb-1">Entrega</span>
                                <span class="text-sm text-neutral-700 dark:text-neutral-300">
                                    {{ $task->due_date ? $task->due_date->format('d M, H:i') : 'Unknown' }}
                                </span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div
                            class="flex items-center gap-3 pt-4 md:pt-0 border-t md:border-t-0 border-neutral-100 dark:border-neutral-800">
                            <flux:button href="{{ route('teacher.tasks.edit', $task) }}" variant="ghost" icon="pencil-square"
                                class="text-neutral-400 hover:text-neutral-600" />
                            <x-flux.confirm-delete-modal :name="'delete-task-unassigned-' . $task->id" title="Eliminar tarea"
                                message="¿Estás seguro de eliminar esta tarea? Esta acción no se puede deshacer.">
                                <x-slot:trigger>
                                    <flux:button variant="ghost" icon="trash"
                                        class="text-neutral-400 hover:text-red-600 hover:bg-red-50 border-transparent hover:border-red-100" />
                                </x-slot:trigger>
                                <flux:button variant="danger" wire:click="deleteTask({{ $task->id }})">Eliminar</flux:button>
                            </x-flux.confirm-delete-modal>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>