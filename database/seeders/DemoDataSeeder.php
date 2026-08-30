<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Reward;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    /**
     * Crea usuarios y contenido de demostración para la plataforma.
     */
    public function run(): void
    {
        $admin = $this->createUser(config('app.demo.admin'), 'admin');
        $docente = $this->createUser(config('app.demo.docente'), 'docente');
        $alumno = $this->createUser(config('app.demo.alumno'), 'alumno');

        // Clase de ejemplo impartida por el docente demo
        $group = Group::firstOrCreate(
            ['name' => 'Matemáticas - Grupo A'],
            [
                'teacher_id' => $docente->id,
                'subject' => 'Matemáticas',
                'grade' => '10°',
                'description' => 'Clase de demostración creada automáticamente.',
            ]
        );

        // Vincular al alumno demo con la clase
        if (! $group->hasStudent($alumno)) {
            $group->addStudent($alumno);
        }

        // Tareas de ejemplo
        Task::firstOrCreate(
            ['title' => 'Cuestionario: Historia Prehispánica'],
            [
                'description' => 'Responde las 20 preguntas sobre las culturas Olmeca y Maya.',
                'difficulty' => 'basic',
                'ac_reward' => 15,
                'due_date' => now()->addDays(3),
                'created_by' => $docente->id,
            ]
        );

        Task::firstOrCreate(
            ['title' => 'Proyecto: Maqueta del Sistema Solar'],
            [
                'description' => 'Construir una maqueta a escala con materiales reciclados.',
                'difficulty' => 'advanced',
                'ac_reward' => 60,
                'due_date' => now()->addDays(14),
                'created_by' => $docente->id,
            ]
        );

        // Recompensas de ejemplo (Marketplace)
        Reward::firstOrCreate(
            ['name' => 'Dulce de la Cooperativa'],
            [
                'description' => 'Un dulce individual a elegir de la tienda escolar.',
                'cost' => 20,
                'category' => 'Snacks',
                'stock' => 50,
            ]
        );

        Reward::firstOrCreate(
            ['name' => 'Pase "Sin Tarea"'],
            [
                'description' => 'Exenta una tarea básica de tu elección (excepto proyectos).',
                'cost' => 200,
                'category' => 'Privilegios',
                'stock' => 5,
            ]
        );

        $this->command?->info('Datos de demostración creados correctamente.');
    }

    /**
     * Crea un usuario de demo con el rol indicado, de forma idempotente.
     */
    private function createUser(array $credentials, string $roleName): User
    {
        $user = User::firstOrCreate(
            ['email' => $credentials['email']],
            [
                'name' => ucfirst($roleName).' de demostración',
                'password' => $credentials['password'],
            ]
        );

        $user->assignRole($roleName);

        if (! $user->wallet) {
            $user->wallet()->create(['balance' => 0]);
        }

        // Saldo inicial de demostración (la wallet se autocrea en 0 al registrar).
        if ((float) $user->wallet->balance < 100) {
            $user->wallet()->update(['balance' => 100]);
        }

        return $user;
    }
}
