<?php

namespace App\Http\Controllers;

use App\Enums\TransactionType;
use App\Models\SatLesson;
use App\Models\SatLessonCompletion;
use App\Services\EconomyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SatEducationController extends Controller
{
    /**
     * Mostrar índice de lecciones SAT
     */
    public function index()
    {
        $lessons = SatLesson::active()->get()->groupBy('category');

        return view('sat-education.index', compact('lessons'));
    }

    /**
     * Mostrar una lección específica
     */
    public function show(SatLesson $lesson)
    {
        if (! $lesson->is_active) {
            abort(404);
        }

        // Obtener lecciones relacionadas (misma categoría)
        $relatedLessons = SatLesson::active()
            ->where('category', $lesson->category)
            ->where('id', '!=', $lesson->id)
            ->orderBy('order')
            ->get();

        return view('sat-education.show', compact('lesson', 'relatedLessons'));
    }

    /**
     * Página especial sobre RFC
     */
    public function rfc()
    {
        $user = auth()->user();

        return view('sat-education.rfc', [
            'userRfc' => $user->rfc,
            'rfcExplanation' => $this->explainRfc($user->rfc),
        ]);
    }

    /**
     * Explicar el RFC del usuario
     */
    private function explainRfc(string $rfc): array
    {
        // Formato RFC: 4 letras + 6 dígitos + 3 caracteres
        // Ejemplo: JUAN260123ABC

        if (strlen($rfc) !== 13) {
            return [
                'parts' => [],
                'explanation' => 'El RFC debe tener 13 caracteres',
            ];
        }

        $initials = substr($rfc, 0, 4);
        $date = substr($rfc, 4, 6);
        $homoclave = substr($rfc, 10, 3);

        $year = '20'.substr($date, 0, 2);
        $month = substr($date, 2, 2);
        $day = substr($date, 4, 2);

        return [
            'parts' => [
                'initials' => [
                    'value' => $initials,
                    'label' => 'Iniciales del Nombre',
                    'explanation' => 'Las primeras 4 letras provienen de tu nombre completo. En el RFC real, se toman las primeras letras de tu apellido paterno, materno y nombre(s).',
                ],
                'date' => [
                    'value' => $date,
                    'label' => 'Fecha de Registro',
                    'explanation' => "Representa la fecha en que se generó tu RFC: {$day}/{$month}/{$year}. En el RFC real, esta es tu fecha de nacimiento o registro fiscal.",
                ],
                'homoclave' => [
                    'value' => $homoclave,
                    'label' => 'Homoclave',
                    'explanation' => 'Son 3 caracteres alfanuméricos que el SAT asigna para evitar duplicados. Es único para cada persona.',
                ],
            ],
            'full_explanation' => "Tu RFC simulado es: <strong>{$rfc}</strong>. En el mundo real, el RFC es tu identificación fiscal única ante el SAT (Servicio de Administración Tributaria) de México. Es obligatorio para realizar actividades económicas, recibir ingresos, y cumplir con tus obligaciones fiscales.",
        ];
    }

    /**
     * Calculadora interactiva de impuestos
     */
    public function calculator()
    {
        return view('sat-education.calculator');
    }

    /**
     * Simulador de Declaración
     */
    public function simulator()
    {
        $user = auth()->user();

        // Simular algunos datos de ingresos y deducciones del mes actual
        $ingresosMes = $user->wallet
            ? $user->wallet->transactions()->where('type', TransactionType::Income->value)->where('amount', '>', 0)->whereMonth('created_at', now()->month)->sum('amount')
            : 0;
        $gastosMes = $user->wallet
            ? abs($user->wallet->transactions()->whereIn('type', [TransactionType::Expense->value, TransactionType::Tax->value])->where('amount', '<', 0)->whereMonth('created_at', now()->month)->sum('amount'))
            : 0;

        return view('sat-education.simulator', compact('user', 'ingresosMes', 'gastosMes'));
    }

    /**
     * Procesar el Simulador de Declaración
     */
    public function submitSimulator(Request $request): RedirectResponse
    {
        $request->validate([
            'period' => 'nullable|string|max:50',
        ]);

        $user = auth()->user();

        // Simular que obtienen un "Saldo a Favor" por hacer su declaración escolar a tiempo
        $recompensaAC = 10;

        // Guard: una única declaración por día para evitar la generación ilimitada de AC.
        $already = $user->wallet?->transactions()
            ->where('type', TransactionType::Income->value)
            ->whereDate('created_at', today())
            ->where('description', 'like', '%Declaración Escolar%')
            ->exists();

        if ($already) {
            return redirect()->route('sat-education.index')
                ->with('error', 'Ya presentaste tu declaración hoy. Vuelve mañana para obtener tu saldo a favor.');
        }

        app(EconomyService::class)->credit(
            $user,
            $recompensaAC,
            'Saldo a favor del SAT por Declaración Escolar',
            ['source' => 'sat_simulator'],
            TransactionType::Income,
            false,
        );

        return redirect()->route('sat-education.index')
            ->with('success', '¡Declaración presentada con éxito! El SAT te devolvió '.$recompensaAC.' AC por saldo a favor.');
    }

    /**
     * Mostrar el Quiz de una lección
     */
    public function takeQuiz(SatLesson $lesson)
    {
        if (empty($lesson->quiz_data) || ! isset($lesson->quiz_data['questions'])) {
            return redirect()->route('sat-education.show', $lesson)->with('error', 'Esta lección no tiene quiz disponible.');
        }

        $user = auth()->user();
        $completed = SatLessonCompletion::where('user_id', $user->id)
            ->where('sat_lesson_id', $lesson->id)
            ->exists();

        return view('sat-education.quiz', compact('lesson', 'completed'));
    }

    /**
     * Evaluar el Quiz y dar recompensa si acierta todo
     */
    public function submitQuiz(Request $request, SatLesson $lesson)
    {
        $user = auth()->user();

        // Verificar que no lo haya completado antes
        $alreadyCompleted = SatLessonCompletion::where('user_id', $user->id)
            ->where('sat_lesson_id', $lesson->id)
            ->exists();

        if ($alreadyCompleted) {
            return redirect()->route('sat-education.show', $lesson)
                ->with('error', 'Ya completaste este quiz anterioremente.');
        }

        if (empty($lesson->quiz_data) || ! isset($lesson->quiz_data['questions'])) {
            return redirect()->back()->with('error', 'El quiz no tiene preguntas válidas.');
        }

        $questions = $lesson->quiz_data['questions'];
        $score = 0;
        $totalQuestions = count($questions);

        $answers = $request->input('answers', []);

        foreach ($questions as $index => $q) {
            if (isset($answers[$index]) && (int) $answers[$index] === $q['correct_answer']) {
                $score++;
            }
        }

        // Si tuvo todas bien, darle 5 AC
        $earnedAC = 0;
        if ($score === $totalQuestions) {
            $earnedAC = 5;

            app(EconomyService::class)->credit(
                $user,
                $earnedAC,
                'Bono por aprobar el Quiz de: '.$lesson->title,
                ['source' => 'sat_quiz'],
                TransactionType::Income,
                false,
            );

            // Registrar intento (solo si pasa)
            SatLessonCompletion::create([
                'user_id' => $user->id,
                'sat_lesson_id' => $lesson->id,
                'score' => $score,
                'earned_ac' => $earnedAC,
            ]);

            return redirect()->route('sat-education.show', $lesson)
                ->with('success', "¡Felicidades! Aprobaste el quiz ({$score}/{$totalQuestions}) y ganaste {$earnedAC} AC.");
        }

        return redirect()->back()
            ->withInput()
            ->with('error', "Obtuviste {$score} de {$totalQuestions} aciertos. ¡Inténtalo de nuevo para ganar tu recompensa!");
    }
}
