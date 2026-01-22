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
            <x-flux:card class="flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <x-flux:badge @class([
                            'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' => $task->difficulty === 'basic',
                            'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300' => $task->difficulty === 'intermediate',
                            'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-300' => $task->difficulty === 'advanced',
                            'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300' => $task->difficulty === 'excellence',
                        ]) size="sm">
                            {{ ucfirst($task->difficulty) }}
                        </x-flux:badge>
                        <span class="text-xs text-neutral-500">{{ $task->due_date ? 'Vence: ' . $task->due_date->diffForHumans() : 'Sin fecha limite' }}</span>
                    </div>

                    <h3 class="text-lg font-bold text-neutral-800 dark:text-neutral-200">{{ $task->title }}</h3>
                    <p class="text-sm text-neutral-500 line-clamp-2">{{ $task->description }}</p>
                </div>

                <div class="mt-6 flex items-center justify-between pt-4 border-t border-neutral-100 dark:border-neutral-800">
                    <div class="flex items-center gap-1 font-bold text-emerald-600">
                        <span>₳</span> {{ number_format($task->ac_reward, 0) }}
                    </div>
                    <x-flux:button variant="ghost" size="sm" icon="cloud-arrow-up">Subir Tarea</x-flux:button>
                </div>
            </x-flux:card>
        @empty
            <div class="col-span-full py-12 text-center text-neutral-500">
                <x-flux:icon.clipboard-document-list class="size-12 mx-auto mb-3 opacity-20" />
                <p>No hay tareas asignadas por el momento.</p>
            </div>
        @endforelse
    </div>
</div>