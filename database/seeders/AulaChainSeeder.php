<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\Reward;
use App\Models\Group;
use App\Models\User;

class AulaChainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Crea datos de demostración extenso para mostrar el potencial del sistema
     */
    public function run(): void
    {
        // ========================================
        // 1. OBTENER DOCENTE DEMO
        // ========================================
        $teacher = User::where('email', 'docente@demo.educate.com')->first();
        if (!$teacher) {
            echo "⚠️  Docente demo no encontrado. Por favor ejecuta DemoUsersSeeder primero.\n";
            return;
        }

        // ========================================
        // 2. CREAR GRUPOS/CLASES
        // ========================================
        $groups = [
            Group::firstOrCreate(
                ['name' => '1-A Historia Universal'],
                [
                    'teacher_id' => $teacher->id,
                    'slug' => '1-a-historia-universal',
                    'description' => 'Clase de Historia Universal para 1er año - Prof. Juan Carlos Rivera',
                    'is_active' => true,
                ]
            ),
            Group::firstOrCreate(
                ['name' => '2-B Matemáticas Avanzadas'],
                [
                    'teacher_id' => $teacher->id,
                    'slug' => '2-b-matematicas-avanzadas',
                    'description' => 'Matemáticas Avanzadas para 2do año - Prof. Juan Carlos Rivera',
                    'is_active' => true,
                ]
            ),
            Group::firstOrCreate(
                ['name' => '3-C Ciencias Naturales'],
                [
                    'teacher_id' => $teacher->id,
                    'slug' => '3-c-ciencias-naturales',
                    'description' => 'Ciencias Naturales para 3er año - Prof. Juan Carlos Rivera',
                    'is_active' => true,
                ]
            ),
        ];

        // ========================================
        // 2. TAREAS EXTENSAS Y VARIADAS
        // ========================================
        $tasks = [
            // TAREAS BÁSICAS
            Task::firstOrCreate(
                ['title' => 'Cuestionario: Historia Prehispánica'],
                [
                    'description' => 'Responde las 20 preguntas sobre las culturas Olmeca, Maya y Azteca. Duración estimada: 20 minutos. Incluye preguntas de opción múltiple y análisis.',
                    'difficulty' => 'basic',
                    'ac_reward' => 15,
                    'due_date' => now()->addDays(3),
                ]
            ),
            Task::firstOrCreate(
                ['title' => 'Ejercicios de Álgebra - Ecuaciones Lineales'],
                [
                    'description' => 'Resuelve 25 ecuaciones lineales de dificultad progresiva. Incluye comprobación y explicación del procedimiento.',
                    'difficulty' => 'basic',
                    'ac_reward' => 12,
                    'due_date' => now()->addDays(2),
                ]
            ),
            Task::firstOrCreate(
                ['title' => 'Lectura: Los Artículos Constitucionales'],
                [
                    'description' => 'Lee los primeros 30 artículos de la Constitución y realiza un resumen ejecutivo de máximo 2 páginas.',
                    'difficulty' => 'basic',
                    'ac_reward' => 18,
                    'due_date' => now()->addDays(5),
                ]
            ),

            // TAREAS INTERMEDIAS
            Task::firstOrCreate(
                ['title' => 'Ensayo: La Independencia de México'],
                [
                    'description' => 'Ensayo de 3-4 cuartillas sobre los factores externos e internos de la independencia mexicana. Incluir mínimo 5 referencias bibliográficas.',
                    'difficulty' => 'intermediate',
                    'ac_reward' => 35,
                    'due_date' => now()->addDays(7),
                ]
            ),
            Task::firstOrCreate(
                ['title' => 'Análisis Crítico: Revolución Francesa vs Revolución Mexicana'],
                [
                    'description' => 'Analiza las similitudes y diferencias entre ambas revoluciones. Mínimo 5 páginas con comparativa de causas, consecuencias y legado.',
                    'difficulty' => 'intermediate',
                    'ac_reward' => 40,
                    'due_date' => now()->addDays(10),
                ]
            ),
            Task::firstOrCreate(
                ['title' => 'Resolución de Problemas: Cálculo Diferencial'],
                [
                    'description' => 'Resuelve 15 problemas de aplicación de derivadas. Incluye gráficas y análisis de puntos críticos.',
                    'difficulty' => 'intermediate',
                    'ac_reward' => 38,
                    'due_date' => now()->addDays(6),
                ]
            ),
            Task::firstOrCreate(
                ['title' => 'Presentación: Ciclo del Agua en Ecosistemas'],
                [
                    'description' => 'Crea una presentación interactiva (PowerPoint o Canva) con mínimo 12 diapositivas. Incluye diagrama del ciclo, impacto ambiental y ejemplos locales.',
                    'difficulty' => 'intermediate',
                    'ac_reward' => 32,
                    'due_date' => now()->addDays(8),
                ]
            ),

            // TAREAS AVANZADAS
            Task::firstOrCreate(
                ['title' => 'Proyecto: Maqueta del Sistema Solar'],
                [
                    'description' => 'Construir una maqueta a escala del Sistema Solar con materiales reciclados. Incluir distancias relativas, características de planetas y explicación científica. Mínimo 30cm de diámetro.',
                    'difficulty' => 'advanced',
                    'ac_reward' => 60,
                    'due_date' => now()->addDays(14),
                ]
            ),
            Task::firstOrCreate(
                ['title' => 'Investigación: Impacto de la IA en la Educación'],
                [
                    'description' => 'Investiga y redacta un trabajo monográfico (8-10 páginas) sobre cómo la Inteligencia Artificial está transformando la educación. Incluir casos de uso, beneficios, riesgos y conclusiones.',
                    'difficulty' => 'advanced',
                    'ac_reward' => 75,
                    'due_date' => now()->addDays(21),
                ]
            ),
            Task::firstOrCreate(
                ['title' => 'Exposición Oral: Movimientos Artísticos del Siglo XX'],
                [
                    'description' => 'Prepara una exposición oral de 15 minutos sobre un movimiento artístico del siglo XX (Surrealismo, Cubismo, Dadaísmo, etc.). Incluir análisis de obras maestras y contexto histórico.',
                    'difficulty' => 'advanced',
                    'ac_reward' => 55,
                    'due_date' => now()->addDays(12),
                ]
            ),
            Task::firstOrCreate(
                ['title' => 'Proyecto Colaborativo: Simulación Económica'],
                [
                    'description' => 'En equipo de 4-5 personas, crea una simulación de un mercado económico simple. Debe incluir producción, comercio, impuestos y análisis de resultados.',
                    'difficulty' => 'advanced',
                    'ac_reward' => 80,
                    'due_date' => now()->addDays(18),
                ]
            ),
        ];

        // ========================================
        // 3. RECOMPENSAS EXTENSO MARKETPLACE
        // ========================================
        $rewards = [
            // SNACKS Y COMIDA
            Reward::firstOrCreate(
                ['name' => 'Dulce de la Cooperativa'],
                [
                    'description' => 'Un dulce individual a elegir de la tienda escolar. Variedad de opciones disponible.',
                    'cost' => 20,
                    'category' => 'Snacks',
                    'stock' => 50,
                ]
            ),
            Reward::firstOrCreate(
                ['name' => 'Papas / Sabritas'],
                [
                    'description' => 'Bolsa de papas fritas de tamaño personal. Variedad de sabores disponible.',
                    'cost' => 50,
                    'category' => 'Snacks',
                    'stock' => 30,
                ]
            ),
            Reward::firstOrCreate(
                ['name' => 'Botella de Refresco'],
                [
                    'description' => 'Botella de refresco de 600ml. Marca y sabor a elección (disponibilidad sujeta a stock).',
                    'cost' => 40,
                    'category' => 'Bebidas',
                    'stock' => 25,
                ]
            ),
            Reward::firstOrCreate(
                ['name' => 'Pizza o Sándwich de la Cafetería'],
                [
                    'description' => 'Un slice de pizza casera o sándwich especial de la cafetería escolar. Válido para el almuerzo.',
                    'cost' => 85,
                    'category' => 'Comidas',
                    'stock' => 15,
                ]
            ),

            // PRIVILEGIOS ACADÉMICOS
            Reward::firstOrCreate(
                ['name' => 'Pase "Sin Tarea" Básica'],
                [
                    'description' => 'Exenta una tarea básica de tu elección (excepto proyectos ni tareas calificadas).',
                    'cost' => 200,
                    'category' => 'Privilegios',
                    'stock' => 8,
                ]
            ),
            Reward::firstOrCreate(
                ['name' => '10 Minutos Extra en Examen'],
                [
                    'description' => 'Recibe 10 minutos adicionales en tu próximo examen para completar preguntas.',
                    'cost' => 150,
                    'category' => 'Privilegios',
                    'stock' => 12,
                ]
            ),
            Reward::firstOrCreate(
                ['name' => 'Ayuda de Profesor (30 min)'],
                [
                    'description' => 'Sesión de tutoría individual de 30 minutos con el profesor para aclarar dudas de cualquier materia.',
                    'cost' => 250,
                    'category' => 'Educación',
                    'stock' => 6,
                ]
            ),

            // PRIVILEGIOS DE CLASE
            Reward::firstOrCreate(
                ['name' => 'Elegir Asiento (1 semana)'],
                [
                    'description' => 'Privilegio de elegir tu lugar en el salón de clase durante 1 semana completa.',
                    'cost' => 100,
                    'category' => 'Privilegios',
                    'stock' => 5,
                ]
            ),
            Reward::firstOrCreate(
                ['name' => 'Ser Monitor por un Día'],
                [
                    'description' => 'Sé el encargado de asistir al profesor en tareas administrativas por un día. Puedes tomar asistencia y distribuir materiales.',
                    'cost' => 120,
                    'category' => 'Responsabilidades',
                    'stock' => 4,
                ]
            ),
            Reward::firstOrCreate(
                ['name' => 'Libre de Participación Obligatoria'],
                [
                    'description' => 'Durante una clase, no es obligatorio participar si no deseas hacerlo (por causa justificada).',
                    'cost' => 80,
                    'category' => 'Privilegios',
                    'stock' => 10,
                ]
            ),

            // ITEMS COLECCIONABLES
            Reward::firstOrCreate(
                ['name' => 'Insignia Digital: Estudiante Estrella'],
                [
                    'description' => 'Insignia digital que se suma a tu perfil. Colecciona 5 insignias diferentes para un premio especial.',
                    'cost' => 30,
                    'category' => 'Coleccionables',
                    'stock' => 100,
                ]
            ),
            Reward::firstOrCreate(
                ['name' => 'Certificado de Excelencia'],
                [
                    'description' => 'Certificado digital imprimible para tu portafolio académico. Válido para solicitudes de admisión.',
                    'cost' => 45,
                    'category' => 'Certificados',
                    'stock' => 20,
                ]
            ),

            // EXPERIENCIAS
            Reward::firstOrCreate(
                ['name' => 'Excursión Virtual: Museo Británico'],
                [
                    'description' => 'Acceso guiado a un tour virtual del Museo Británico con comentarios educativos. Duración: 1.5 horas.',
                    'cost' => 200,
                    'category' => 'Experiencias',
                    'stock' => 50,
                ]
            ),
            Reward::firstOrCreate(
                ['name' => 'Webinar: Carreras Tecnológicas del Futuro'],
                [
                    'description' => 'Asiste a un webinar especializado sobre carreras en tecnología, impartido por profesionales de la industria.',
                    'cost' => 180,
                    'category' => 'Educación',
                    'stock' => 30,
                ]
            ),
        ];

        echo "✅ Seeder completado: " . count($groups) . " grupos, " . count($tasks) . " tareas, " . count($rewards) . " recompensas creadas.\n";
    }
}
