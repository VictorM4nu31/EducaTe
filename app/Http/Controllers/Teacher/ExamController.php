<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamAssignment;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::where('created_by', auth()->id())
            ->withCount('questions')
            ->latest()
            ->get();
        return view('teacher.exams.index', compact('exams'));
    }

    public function create()
    {
        $groups = auth()->user()->taughtGroups()->where('is_active', true)->get();
        return view('teacher.exams.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ac_reward_bonus' => 'required|numeric|min:0',
            'time_limit' => 'nullable|integer|min:1',
        ]);

        $exam = Exam::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'ac_reward_bonus' => $validated['ac_reward_bonus'],
            'time_limit' => $validated['time_limit'] ?? null,
            'created_by' => auth()->id(),
        ]);

        // Asignar a grupos
        if ($request->has('groups')) {
            foreach ($request->groups as $groupId) {
                ExamAssignment::create([
                    'exam_id' => $exam->id,
                    'group_id' => $groupId,
                ]);
            }
        }

        return redirect()
            ->route('teacher.exams.show', $exam)
            ->with('success', 'Examen creado. Ahora agrega las preguntas.');
    }

    public function show(Exam $exam)
    {
        \Illuminate\Support\Facades\Gate::authorize('view', $exam);

        $exam->load(['questions' => function($query) {
            $query->orderBy('order');
        }, 'assignments.group']);

        return view('teacher.exams.show', compact('exam'));
    }

    public function edit(Exam $exam)
    {
        \Illuminate\Support\Facades\Gate::authorize('update', $exam);

        $groups = auth()->user()->taughtGroups()->where('is_active', true)->get();
        return view('teacher.exams.edit', compact('exam', 'groups'));
    }

    public function update(Request $request, Exam $exam)
    {
        \Illuminate\Support\Facades\Gate::authorize('update', $exam);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ac_reward_bonus' => 'required|numeric|min:0',
            'time_limit' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $exam->update($validated);

        return redirect()
            ->route('teacher.exams.show', $exam)
            ->with('success', 'Examen actualizado exitosamente');
    }

    public function destroy(Exam $exam)
    {
        \Illuminate\Support\Facades\Gate::authorize('delete', $exam);

        $exam->delete();

        return redirect()
            ->route('teacher.exams.index')
            ->with('success', 'Examen eliminado exitosamente');
    }

    /**
     * Re-habilitar un intento de examen anulado
     */
    public function reenableAttempt(Exam $exam, \App\Models\ExamAttempt $attempt)
    {
        \Illuminate\Support\Facades\Gate::authorize('update', $exam);

        if ($attempt->exam_id !== $exam->id) {
            abort(403);
        }

        $attempt->update(['is_annulled' => false]);

        return back()->with('success', "Examen de {$attempt->user->name} habilitado nuevamente.");
    }
}
