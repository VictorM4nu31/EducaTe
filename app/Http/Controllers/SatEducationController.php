<?php

namespace App\Http\Controllers;

use App\Models\SatLesson;
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
        if (!$lesson->is_active) {
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

        $year = '20' . substr($date, 0, 2);
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
}
