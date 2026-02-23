<?php

namespace App\Livewire\Components;

use Livewire\Component;

class DemoUsersModal extends Component
{
    public bool $isOpen = false;
    public ?string $copiedField = null;

    public array $demoUsers = [
        [
            'email' => 'admin@demo.educate.com',
            'password' => 'demo123',
            'name' => 'Administrador Sistema',
            'role' => 'admin',
            'roleLabel' => 'Administrador',
            'description' => 'Acceso completo al panel de administración. Gestiona docentes, alumnos, configuración y reportes del sistema.',
            'icon' => 'shield-check',
            'color' => 'red',
            'features' => ['Gestión de usuarios', 'Reportes y analíticas', 'Configuración del sistema', 'Auditoría de actividades']
        ],
        [
            'email' => 'docente@demo.educate.com',
            'password' => 'demo123',
            'name' => 'Dr. Juan Carlos Rivera',
            'role' => 'docente',
            'roleLabel' => 'Docente',
            'description' => 'Panel de enseñanza. Crea tareas, gestiona recompensas, califica y analiza el progreso de tus estudiantes.',
            'icon' => 'academic-cap',
            'color' => 'blue',
            'features' => ['Crear y calificar tareas', 'Gestionar recompensas', 'Análisis de desempeño', 'Mensajería con alumnos']
        ],
        [
            'email' => 'alumno@demo.educate.com',
            'password' => 'demo123',
            'name' => 'María González López',
            'role' => 'alumno',
            'roleLabel' => 'Estudiante',
            'description' => 'Dashboard de aprendizaje. Completa tareas, gana puntos AulaChain, participa en el marketplace y sigue tu progreso.',
            'icon' => 'book-open',
            'color' => 'emerald',
            'features' => ['Completar tareas', 'Ganar AulaChain', 'Canjear recompensas', 'Ver progreso']
        ],
    ];

    public function toggle(): void
    {
        $this->isOpen = !$this->isOpen;
    }

    public function open(): void
    {
        $this->isOpen = true;
    }

    public function close(): void
    {
        $this->isOpen = false;
    }

    public function copyToClipboard(string $email, string $password): void
    {
        $this->copiedField = $email;
        $this->dispatch('copy-to-clipboard', text: "$email\n$password");
        
        // Limpiar después de 2 segundos
        $this->js('setTimeout(() => { window.copiedField = null; }, 2000)');
    }

    public function render()
    {
        return view('livewire.components.demo-users-modal');
    }
}

