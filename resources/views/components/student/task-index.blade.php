<?php

use Livewire\Volt\Component;
use App\Models\Task;
use App\Models\TaskAssignment;
use App\Models\TaskSubmission;

new class extends Component
{
    public function with()
    {
        $user = auth()->user();
        
        // Obtener IDs de grupos del estudiante
        $groupIds = $user->groups()->pluck('groups.id');
        
        // Obtener tareas asignadas a los grupos del estudiante o directamente al estudiante
        $taskIds = TaskAssignment::where(function($query) use ($groupIds, $user) {
            $query->whereIn('group_id', $groupIds)
                  ->orWhere('user_id', $user->id);
        })->pluck('task_id');
        
        $tasks = Task::whereIn('id', $taskIds)
            ->where('is_active', true)
            ->with(['submissions' => function($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->latest()
            ->get();
        
        return [
            'tasks' => $tasks,
        ];
    }
};
?>

<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Tareas Pendientes</h2>
            <p class="text-sm text-neutral-500">Completa tus actividades para ganar AulaChain.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($tasks as $task)
            <flux:card class="flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <flux:badge @class([
                            'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' => $task->difficulty === 'basic',
                            'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' => $task->difficulty === 'intermediate',
                            'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' => $task->difficulty === 'advanced',
                            'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300' => $task->difficulty === 'excellence',
                        ]) size="sm">
                            {{ ucfirst($task->difficulty) }}
                        </flux:badge>
                        <span class="text-xs text-neutral-500">{{ $task->due_date ? 'Vence: ' . $task->due_date->diffForHumans() : 'Sin fecha limite' }}</span>
                    </div>

                    <h3 class="text-lg font-bold text-neutral-800 dark:text-neutral-200">{{ $task->title }}</h3>
                    <p class="text-sm text-neutral-500 line-clamp-2">{{ $task->description }}</p>
                </div>

                <div class="mt-6 flex items-center justify-between pt-4 border-t border-neutral-light dark:border-neutral-800">
                    <div class="flex items-center gap-1 font-bold text-aulachain-green">
                        <span>₳</span> {{ number_format($task->ac_reward, 0) }}
                    </div>
                    <flux:button variant="primary" size="sm" icon="cloud-arrow-up" href="{{ route('tasks.submit', $task) }}">Subir Tarea</flux:button>
                </div>
            </flux:card>
        @empty
            <div class="col-span-full py-12 text-center text-neutral-500 bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 mx-auto mb-3 opacity-20">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
                <p class="font-medium">No hay tareas asignadas por el momento</p>
                <p class="text-xs mt-1">Únete a una clase para ver las tareas asignadas</p>
            </div>
        @endforelse
    </div>
</div>

