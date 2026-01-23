<?php

use App\Http\Controllers\Admin\DocenteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->hasRole('docente')) {
        return redirect()->route('teacher.tasks');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ========================================
// RUTAS DE ADMINISTRACIÓN (Solo Admin)
// ========================================
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Gestión de Docentes
    Route::resource('docentes', DocenteController::class);

    // Panel de administración
    Route::view('/', 'admin.dashboard')->name('dashboard');

    // Gestión de Alumnos (ver todos los alumnos)
    Route::get('alumnos', function () {
        $alumnos = \App\Models\User::role('alumno')
            ->with('wallet')
            ->latest()
            ->paginate(15);

        return view('admin.alumnos.index', compact('alumnos'));
    })->name('alumnos.index');

    // Configuración del sistema
    Route::view('settings', 'admin.settings')->name('settings');
});

// ========================================
// RUTAS DE DOCENTE (Admin y Docente)
// ========================================
Route::middleware(['auth', 'verified', 'role:admin|docente'])->prefix('teacher')->name('teacher.')->group(function () {
    // Gestión de Tareas
    Route::view('tasks', 'teacher.tasks.index')->name('tasks');
    Route::view('tasks/create', 'teacher.tasks.create')->name('tasks.create');

    // Gestión de Recompensas
    Route::view('rewards', 'teacher.rewards.index')->name('rewards');
    Route::view('rewards/create', 'teacher.rewards.create')->name('rewards.create');

    // Reportes y Analíticas
    Route::view('reports', 'teacher.reports')->name('reports');
});

// ========================================
// RUTAS DE ALUMNO (Solo Alumnos)
// ========================================
Route::middleware(['auth', 'verified', 'role:alumno'])->group(function () {
    // Tareas del alumno
    Route::view('tasks', 'student.tasks.index')->name('tasks');

    // Exámenes
    Route::view('exams', 'student.exams.index')->name('exams');

    // Marketplace de recompensas
    Route::view('marketplace', 'student.marketplace.index')->name('marketplace');
});

require __DIR__.'/settings.php';
