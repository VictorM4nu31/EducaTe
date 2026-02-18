<?php

use Livewire\Volt\Component;
use App\Models\Task;
use App\Models\TaskAssignment;
use App\Models\TaskSubmission;

new class extends Component {
    public function with()
    {
        $user = auth()->user();

        // Obtener IDs de grupos del estudiante
        $groupIds = $user->groups()->pluck('groups.id');

        // Obtener tareas asignadas a los grupos del estudiante o directamente al estudiante
        $taskIds = TaskAssignment::where(function ($query) use ($groupIds, $user) {
            $query->whereIn('group_id', $groupIds)
                ->orWhere('user_id', $user->id);
        })->pluck('task_id');

        // Obtener todas las tareas activas asignadas
        $allTasks = Task::whereIn('id', $taskIds)
            ->where('is_active', true)
            ->with([
                'submissions' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                }
            ])
            ->latest()
            ->get();

        // Clasificar tareas en pendientes y completadas
        $pendingTasks = [];
        $completedTasks = [];

        foreach ($allTasks as $task) {
            $submission = $task->submissions->first();
            if ($submission && in_array($submission->status, ['submitted', 'graded'])) {
                $completedTasks[] = $task;
            } else {
                $pendingTasks[] = $task;
            }
        }

        return [
            'pendingTasks' => $pendingTasks,
            'completedTasks' => $completedTasks,
        ];
    }
};
?>

<div class="space-y-12">
    {{-- Tareas Pendientes --}}
    <section class="space-y-6">
        <div>
            <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Tareas Pendientes</h2>
            <p class="text-sm text-neutral-500">Completa tus actividades para ganar AulaChain.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($pendingTasks as $task)
                <flux:card class="flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            @php $submission = $task->submissions->first(); @endphp
                            @if($submission && $submission->status === 'returned')
                                <flux:badge color="red" size="sm">Devuelta</flux:badge>
                            @endif
                            <flux:badge @class([
                                'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' => $task->difficulty === 'basic',
                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' => $task->difficulty === 'intermediate',
                                'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' => $task->difficulty === 'advanced',
                                'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300' => $task->difficulty === 'excellence',
                            ]) size="sm">
                                {{ ucfirst($task->difficulty) }}
                            </flux:badge>
                            <span
                                class="text-xs text-neutral-500">{{ $task->due_date ? 'Vence: ' . $task->due_date->diffForHumans() : 'Sin fecha limite' }}</span>
                        </div>

                        <h3 class="text-lg font-bold text-neutral-800 dark:text-neutral-200">{{ $task->title }}</h3>
                        <p class="text-sm text-neutral-500 line-clamp-2">{{ $task->description }}</p>

                        @if($submission && $submission->status === 'returned' && $submission->feedback)
                            <div
                                class="mt-3 p-3 bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-900/20 rounded-lg">
                                <p class="text-xs font-bold text-red-600 dark:text-red-400 mb-1">Comentarios del Profesor:</p>
                                <p class="text-xs text-neutral-600 dark:text-neutral-400 italic">"{{ $submission->feedback }}"
                                </p>
                            </div>
                        @endif
                    </div>

                    <div
                        class="mt-6 flex items-center justify-between pt-4 border-t border-neutral-light dark:border-neutral-800">
                        <div class="flex items-center gap-1 font-bold text-aulachain-green">
                            <span>₳</span> {{ number_format($task->ac_reward, 0) }}
                        </div>
                        <flux:button variant="primary" size="sm" icon="cloud-arrow-up"
                            href="{{ route('tasks.submit', $task) }}">Subir Tarea</flux:button>
                    </div>
                </flux:card>
            @empty
                <div
                    class="col-span-full py-12 text-center text-neutral-500 bg-white dark:bg-neutral-900 rounded-xl border border-neutral-200 dark:border-neutral-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-12 mx-auto mb-3 opacity-20">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    <p class="font-medium">No tienes tareas pendientes</p>
                    <p class="text-xs mt-1">¡Buen trabajo! Estás al día con tus actividades.</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- Tareas Completadas --}}
    @if(count($completedTasks) > 0)
        <section class="space-y-6">
            <div>
                <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Tareas Completadas</h2>
                <p class="text-sm text-neutral-500">Repasa tus entregas anteriores.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($completedTasks as $task)
                    <flux:card class="flex flex-col justify-between">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <flux:badge variant="neutral" size="sm">
                                    {{ ucfirst($task->difficulty) }}
                                </flux:badge>
                                @php $submission = $task->submissions->first(); @endphp
                                <flux:badge :variant="$submission->status === 'graded' ? 'emerald' : 'blue'" size="sm">
                                    {{ $submission->status === 'graded' ? 'Calificada' : 'Entregada' }}
                                </flux:badge>
                            </div>

                            <h3 class="text-lg font-bold text-neutral-800 dark:text-neutral-200">{{ $task->title }}</h3>
                            <p class="text-sm text-neutral-500 line-clamp-2">Entregado el:
                                {{ $submission->submitted_at->format('d/m/Y') }}
                            </p>

                            @if($submission->status === 'graded' && $submission->feedback)
                                <div
                                    class="mt-3 p-3 bg-neutral-50 dark:bg-white/5 border border-neutral-100 dark:border-white/10 rounded-lg">
                                    <p class="text-xs font-bold text-neutral-600 dark:text-neutral-400 mb-1">Retroalimentación:</p>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 italic">"{{ $submission->feedback }}"
                                    </p>
                                </div>
                            @endif
                        </div>

                        <div
                            class="mt-6 flex items-center justify-between pt-4 border-t border-neutral-light dark:border-neutral-800">
                            <div class="text-sm font-medium">
                                @if($submission->status === 'graded')
                                    <span class="text-neutral-500">Nota:</span>
                                    <span class="font-bold text-neutral-900 dark:text-white">{{ $submission->grade }}/10</span>
                                @else
                                    <span class="text-neutral-500 italic">Pendiente de nota</span>
                                @endif
                            </div>
                            <flux:button variant="ghost" size="sm" icon="pencil-square"
                                href="{{ route('tasks.submit', $task) }}">Editar</flux:button>
                        </div>
                    </flux:card>
                @endforeach
            </div>
        </section>
    @endif
</div>