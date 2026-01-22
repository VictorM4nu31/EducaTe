<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AulaChainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Teacher Role if needed (via Spatie)
        // (Assuming roles are handled elsewhere or manual for now, 
        // but let's at least create some sample tasks and rewards)

        // 2. Sample Tasks
        \App\Models\Task::create([
            'title' => 'Cuestionario: Historia Prehispánica',
            'description' => 'Responde las 20 preguntas sobre las culturas Olmeca y Maya.',
            'difficulty' => 'basic',
            'ac_reward' => 15,
            'due_date' => now()->addDays(3),
        ]);

        \App\Models\Task::create([
            'title' => 'Ensayo: La Independencia de México',
            'description' => 'Ensayo de 3 cuartillas sobre los factores externos de la independencia.',
            'difficulty' => 'intermediate',
            'ac_reward' => 35,
            'due_date' => now()->addDays(7),
        ]);

        \App\Models\Task::create([
            'title' => 'Proyecto: Maqueta del Sistema Solar',
            'description' => 'Construir una maqueta a escala con materiales reciclados.',
            'difficulty' => 'advanced',
            'ac_reward' => 60,
            'due_date' => now()->addDays(14),
        ]);

        // 3. Sample Rewards (Marketplace)
        \App\Models\Reward::create([
            'name' => 'Dulce de la Cooperativa',
            'description' => 'Un dulce individual a elegir de la tienda escolar.',
            'cost' => 20,
            'category' => 'Snacks',
            'stock' => 50,
        ]);

        \App\Models\Reward::create([
            'name' => 'Papas / Sabritas',
            'description' => 'Bolsa de papas de tamaño personal.',
            'cost' => 50,
            'category' => 'Snacks',
            'stock' => 20,
        ]);

        \App\Models\Reward::create([
            'name' => 'Pase "Sin Tarea"',
            'description' => 'Exenta una tarea básica de tu elección (excepto proyectos).',
            'cost' => 200,
            'category' => 'Privilegios',
            'stock' => 5,
        ]);

        \App\Models\Reward::create([
            'name' => 'Elegir Asiento (1 semana)',
            'description' => 'Ten el privilegio de elegir tu lugar en el salón durante 1 semana completa.',
            'cost' => 100,
            'category' => 'Privilegios',
            'stock' => 3,
        ]);
    }
}
