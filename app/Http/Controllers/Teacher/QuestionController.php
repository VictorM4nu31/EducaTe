<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function store(Request $request, Exam $exam)
    {
        if ($exam->created_by !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'question_text' => 'required|string',
            'type' => 'required|in:multiple_choice,true_false,short_answer',
            'points' => 'required|numeric|min:0',
            'options' => 'required_if:type,multiple_choice|array',
            'correct_answer' => 'required|string',
            'explanation' => 'nullable|string',
        ]);

        // Obtener el siguiente orden
        $order = $exam->questions()->max('order') + 1;

        Question::create([
            'exam_id' => $exam->id,
            'question_text' => $validated['question_text'],
            'type' => $validated['type'],
            'points' => $validated['points'],
            'order' => $order,
            'options' => $validated['options'] ?? null,
            'correct_answer' => $validated['correct_answer'],
            'explanation' => $validated['explanation'] ?? null,
        ]);

        return back()->with('success', 'Pregunta agregada exitosamente');
    }

    public function update(Request $request, Exam $exam, Question $question)
    {
        if ($exam->created_by !== auth()->id() || $question->exam_id !== $exam->id) {
            abort(403);
        }

        $validated = $request->validate([
            'question_text' => 'required|string',
            'type' => 'required|in:multiple_choice,true_false,short_answer',
            'points' => 'required|numeric|min:0',
            'options' => 'required_if:type,multiple_choice|array',
            'correct_answer' => 'required|string',
            'explanation' => 'nullable|string',
        ]);

        $question->update($validated);

        return back()->with('success', 'Pregunta actualizada exitosamente');
    }

    public function destroy(Exam $exam, Question $question)
    {
        if ($exam->created_by !== auth()->id() || $question->exam_id !== $exam->id) {
            abort(403);
        }

        $question->delete();

        return back()->with('success', 'Pregunta eliminada exitosamente');
    }
}
