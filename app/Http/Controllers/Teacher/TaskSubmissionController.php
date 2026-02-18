<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskSubmission;
use App\Services\EconomyService;
use Illuminate\Http\Request;

class TaskSubmissionController extends Controller
{
    /**
     * Listar todas las entregas pendientes de revisión
     */
    public function index()
    {
        // Obtener tareas creadas por el profesor
        $taskIds = Task::where('created_by', auth()->id())->pluck('id');

        $submissions = TaskSubmission::whereIn('task_id', $taskIds)
            ->where('status', 'submitted')
            ->with(['task', 'user'])
            ->latest('submitted_at')
            ->paginate(20);

        return view('teacher.tasks.submissions', compact('submissions'));
    }

    /**
     * Mostrar una entrega específica para calificar
     */
    public function show(TaskSubmission $submission)
    {
        \Illuminate\Support\Facades\Gate::authorize('view', $submission);

        return view('teacher.tasks.grade', compact('submission'));
    }

    /**
     * Calificar una entrega
     */
    public function grade(Request $request, TaskSubmission $submission)
    {
        \Illuminate\Support\Facades\Gate::authorize('grade', $submission);

        $validated = $request->validate([
            'grade' => 'required|numeric|min:0|max:10',
            'feedback' => 'nullable|string|max:2000',
            'is_excellent' => 'boolean',
        ]);

        $grade = $validated['grade'];
        $isExcellent = $validated['is_excellent'] ?? false;

        // Calcular AC ganados
        $baseReward = $submission->task->ac_reward;
        
        // Recompensa proporcional a la calificación (Ej: 10 = 100%, 5 = 50%)
        $acEarned = ($baseReward * ($grade / 10));

        // Bonificaciones extra fijas
        if ($grade >= 10) {
            $acEarned += 50; // +50 AC por calificación perfecta
        }

        // Bonificación por calidad excepcional
        if ($isExcellent) {
            $acEarned += 25;
        }

        // Bonificación por entrega anticipada (+10%)
        if ($submission->is_early) {
            $acEarned = $acEarned * 1.10;
        }

        // Penalización por entrega tardía (-20%)
        if ($submission->is_late) {
            $acEarned = $acEarned * 0.80;
        }

        $acEarned = round($acEarned, 2);

        // Actualizar entrega
        $submission->update([
            'grade' => $grade,
            'feedback' => $validated['feedback'] ?? null,
            'is_excellent' => $isExcellent,
            'ac_earned' => $acEarned,
            'status' => 'graded',
            'graded_at' => now(),
        ]);

        // Si la nota es aprobatoria (6+), otorgar AC
        if ($grade >= 6) {
            $economy = app(EconomyService::class);
            $economy->credit(
                $submission->user,
                $acEarned,
                "Tarea completada: {$submission->task->title}",
                [
                    'task_id' => $submission->task->id,
                    'submission_id' => $submission->id,
                    'grade' => $grade,
                ]
            );
        }

        return redirect()
            ->route('teacher.tasks.submissions')
            ->with('success', 'Tarea calificada exitosamente. Se otorgaron ' . number_format($acEarned, 2) . ' AC al estudiante.');
    }

    /**
     * Devolver tarea para corrección
     */
    public function returnTask(Request $request, TaskSubmission $submission)
    {
        \Illuminate\Support\Facades\Gate::authorize('grade', $submission); // Usamos el mismo permiso que calificar

        $validated = $request->validate([
            'feedback' => 'required|string|max:2000',
        ]);

        $submission->update([
            'status' => 'returned',
            'feedback' => $validated['feedback'],
            'grade' => null,
            'graded_at' => null,
            'ac_earned' => 0,
        ]);

        return redirect()
            ->route('teacher.tasks.submissions')
            ->with('info', 'Tarea devuelta al estudiante para corrección.');
    }
}
