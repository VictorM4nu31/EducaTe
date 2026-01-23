<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\ExamAssignment;
use App\Models\User;
use App\Services\EconomyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    /**
     * Listar exámenes disponibles para el estudiante
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        
        if (!$user) {
            abort(403);
        }

        $groupIds = $user->groups()->pluck('groups.id');

        // Obtener exámenes asignados a los grupos del estudiante
        $examIds = ExamAssignment::whereIn('group_id', $groupIds)
            ->where(function($query) {
                $query->whereNull('available_from')
                    ->orWhere('available_from', '<=', now());
            })
            ->where(function($query) {
                $query->whereNull('available_until')
                    ->orWhere('available_until', '>=', now());
            })
            ->pluck('exam_id');

        $exams = Exam::whereIn('id', $examIds)
            ->where('is_active', true)
            ->with(['questions', 'attempts' => function($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->get();

        return view('student.exams.index', compact('exams'));
    }

    /**
     * Iniciar un examen
     */
    public function start(Exam $exam)
    {
        /** @var User $user */
        $user = Auth::user();
        
        if (!$user) {
            abort(403);
        }

        // Verificar acceso
        $hasAccess = false;
        foreach ($user->groups as $group) {
            if ($exam->assignments()->where('group_id', $group->id)->exists()) {
                $hasAccess = true;
                break;
            }
        }

        if (!$hasAccess) {
            abort(403);
        }

        // Verificar si ya tiene un intento en progreso
        $attempt = ExamAttempt::where('exam_id', $exam->id)
            ->where('user_id', $user->id)
            ->where('is_completed', false)
            ->latest()
            ->first();

        if (!$attempt) {
            $attempt = ExamAttempt::create([
                'exam_id' => $exam->id,
                'user_id' => $user->id,
                'started_at' => now(),
                'metadata' => ['hints' => []],
            ]);
        }

        $exam->load(['questions' => function($query) {
            $query->orderBy('order');
        }]);

        // Si el examen ya está completado, mostrar resultados
        if ($attempt->is_completed) {
            return view('student.exams.results', compact('exam', 'attempt'));
        }

        return view('student.exams.take', compact('exam', 'attempt'));
    }

    /**
     * Guardar respuestas y finalizar examen
     */
    public function submit(Request $request, Exam $exam, ExamAttempt $attempt)
    {
        /** @var User|null $user */
        $user = Auth::user();
        
        if (!$user || $attempt->user_id !== $user->id || $attempt->exam_id !== $exam->id) {
            abort(403);
        }

        if ($attempt->is_completed) {
            return back()->withErrors(['error' => 'Este examen ya fue completado']);
        }

        $answers = $request->input('answers', []);
        $hintsUsed = (int)$request->input('hints_used', $attempt->hints_used);

        // Calcular calificación
        $totalPoints = 0;
        $earnedPoints = 0;

        foreach ($exam->questions as $question) {
            $totalPoints += $question->points;
            $userAnswer = $answers[$question->id] ?? null;

            if ($userAnswer && strtolower(trim($userAnswer)) === strtolower(trim($question->correct_answer))) {
                $earnedPoints += $question->points;
            }
        }

        $grade = $totalPoints > 0 ? ($earnedPoints / $totalPoints) * 100 : 0;
        $finalGrade = max(0, $grade - ($hintsUsed * 2)); // Penalización por pistas

        // Calcular AC ganados
        $acEarned = 0;

        // Bonificación por no usar pistas
        if ($hintsUsed === 0) {
            $acEarned += $exam->ac_reward_bonus;
        }

        // Bonificaciones por calificación
        if ($finalGrade >= 10) {
            $acEarned += 50;
        } elseif ($finalGrade >= 9) {
            $acEarned += 30;
        } elseif ($finalGrade >= 8) {
            $acEarned += 15;
        }

        // Actualizar intento
        $attempt->update([
            'answers' => $answers,
            'hints_used' => $hintsUsed,
            'grade' => $grade,
            'final_grade' => $finalGrade,
            'ac_earned' => $acEarned,
            'is_completed' => true,
            'submitted_at' => now(),
        ]);

        // Otorgar AC
        if ($acEarned > 0 && $user) {
            $economy = app(EconomyService::class);
            $economy->credit(
                $user,
                $acEarned,
                "Examen completado: {$exam->title}",
                [
                    'exam_id' => $exam->id,
                    'attempt_id' => $attempt->id,
                    'grade' => $finalGrade,
                ]
            );
        }

        return redirect()
            ->route('exams')
            ->with('success', "Examen completado. Calificación: " . number_format($finalGrade, 1) . ". Ganaste " . number_format($acEarned, 2) . " AC.");
    }
}
