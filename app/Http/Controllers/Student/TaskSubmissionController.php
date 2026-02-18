<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskSubmissionController extends Controller
{
    /**
     * Mostrar formulario de subida para una tarea
     */
    public function create(Task $task)
    {
        // Verificar que el estudiante tiene acceso a esta tarea
        $user = auth()->user();
        $hasAccess = false;

        // Verificar si está asignada a algún grupo del estudiante
        foreach ($user->groups as $group) {
            if ($task->assignments()->where('group_id', $group->id)->exists()) {
                $hasAccess = true;
                break;
            }
        }

        // O si está asignada directamente al estudiante
        if ($task->assignments()->where('user_id', $user->id)->exists()) {
            $hasAccess = true;
        }

        if (!$hasAccess) {
            abort(403, 'No tienes acceso a esta tarea');
        }

        // Verificar si ya tiene una entrega
        $submission = TaskSubmission::where('task_id', $task->id)
            ->where('user_id', $user->id)
            ->whereIn('status', ['submitted', 'graded', 'rejected', 'returned'])
            ->latest()
            ->first();

        return view('student.tasks.submit', compact('task', 'submission'));
    }

    /**
     * Guardar la entrega de la tarea
     */
    public function store(Request $request, Task $task)
    {
        $validated = $request->validate([
            'file' => 'required|file|max:10240', // Máximo 10MB
            'notes' => 'nullable|string|max:1000',
        ]);

        $user = auth()->user();

        // Verificar acceso (mismo código que en create)
        $hasAccess = false;
        foreach ($user->groups as $group) {
            if ($task->assignments()->where('group_id', $group->id)->exists()) {
                $hasAccess = true;
                break;
            }
        }
        if ($task->assignments()->where('user_id', $user->id)->exists()) {
            $hasAccess = true;
        }
        if (!$hasAccess) {
            abort(403);
        }

        // Guardar archivo
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('task_submissions', $fileName, 'public');

        // Determinar si es entrega anticipada o tardía
        $isEarly = $task->due_date && now()->lt($task->due_date->subDays(1));
        $isLate = $task->due_date && now()->gt($task->due_date);

        // Buscar si ya existe una entrega (cualquiera que sea su estado)
        $submission = TaskSubmission::where('task_id', $task->id)
            ->where('user_id', $user->id)
            ->first();

        if ($submission) {
            // Eliminar archivo anterior si existe
            if ($submission->file_path) {
                Storage::disk('public')->delete($submission->file_path);
            }

            $submission->update([
                'file_path' => $filePath,
                'file_name' => $file->getClientOriginalName(),
                'notes' => $validated['notes'] ?? null,
                'status' => 'submitted', // Volver a estado enviado para revisión
                'grade' => null,         // Limpiar nota previa para revisión
                'graded_at' => null,     // Limpiar fecha de calificación
                'is_early' => $isEarly,
                'is_late' => $isLate,
                'submitted_at' => now(),
            ]);
        } else {
            // Crear nueva entrega
            $submission = TaskSubmission::create([
                'task_id' => $task->id,
                'user_id' => $user->id,
                'status' => 'submitted',
                'file_path' => $filePath,
                'file_name' => $file->getClientOriginalName(),
                'notes' => $validated['notes'] ?? null,
                'is_early' => $isEarly,
                'is_late' => $isLate,
                'submitted_at' => now(),
            ]);
        }

        return redirect()
            ->route('tasks')
            ->with('success', 'Tarea entregada exitosamente. Espera la calificación de tu profesor.');
    }

    /**
     * Descargar archivo de entrega
     */
    public function download(TaskSubmission $submission)
    {
        if ($submission->user_id !== auth()->id() && !auth()->user()->hasRole(['admin', 'docente'])) {
            abort(403);
        }

        return Storage::disk('public')->download($submission->file_path, $submission->file_name);
    }
}
