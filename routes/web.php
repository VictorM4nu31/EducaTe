<?php

use App\Http\Controllers\Admin\DocenteController;
use App\Http\Controllers\Teacher\GroupController;
use App\Http\Controllers\Student\JoinGroupController;
use App\Http\Controllers\SatEducationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth'])->get('style-guide', function () {
    return view('style-guide');
})->name('style-guide');

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
    Route::get('tasks/{task}/edit', function (\App\Models\Task $task) {
        return view('teacher.tasks.edit', compact('task'));
    })->name('tasks.edit');
    
    // Revisión de Entregas
    Route::get('tasks/submissions', [\App\Http\Controllers\Teacher\TaskSubmissionController::class, 'index'])->name('tasks.submissions');
    Route::get('tasks/submissions/{submission}', [\App\Http\Controllers\Teacher\TaskSubmissionController::class, 'show'])->name('tasks.submissions.show');
    Route::post('tasks/submissions/{submission}/grade', [\App\Http\Controllers\Teacher\TaskSubmissionController::class, 'grade'])->name('tasks.submissions.grade');

    // Gestión de Recompensas
    Route::resource('rewards', \App\Http\Controllers\Teacher\RewardController::class);

    // Reportes y Analíticas
    Route::view('reports', 'teacher.reports')->name('reports');

    // Gestión de Exámenes
    Route::resource('exams', \App\Http\Controllers\Teacher\ExamController::class);
    Route::post('exams/{exam}/questions', [\App\Http\Controllers\Teacher\QuestionController::class, 'store'])->name('exams.questions.store');
    Route::put('exams/{exam}/questions/{question}', [\App\Http\Controllers\Teacher\QuestionController::class, 'update'])->name('exams.questions.update');
    Route::delete('exams/{exam}/questions/{question}', [\App\Http\Controllers\Teacher\QuestionController::class, 'destroy'])->name('exams.questions.destroy');

    // Gestión de Clases/Grupos
    Route::resource('groups', GroupController::class);
    Route::post('groups/{group}/regenerate-code', [GroupController::class, 'regenerateCode'])->name('groups.regenerate-code');
    Route::delete('groups/{group}/students/{student}', [GroupController::class, 'removeStudent'])->name('groups.remove-student');
});

// ========================================
// RUTAS DE ALUMNO (Solo Alumnos)
// ========================================
Route::middleware(['auth', 'verified', 'role:alumno'])->group(function () {
    // Tareas del alumno
    Route::view('tasks', 'student.tasks.index')->name('tasks');
    Route::get('tasks/{task}/submit', [\App\Http\Controllers\Student\TaskSubmissionController::class, 'create'])->name('tasks.submit');
    Route::post('tasks/{task}/submit', [\App\Http\Controllers\Student\TaskSubmissionController::class, 'store'])->name('tasks.submit.store');
    Route::get('submissions/{submission}/download', [\App\Http\Controllers\Student\TaskSubmissionController::class, 'download'])->name('submissions.download');

    // Exámenes
    Route::get('exams', [\App\Http\Controllers\Student\ExamController::class, 'index'])->name('exams');
    Route::get('exams/{exam}/start', [\App\Http\Controllers\Student\ExamController::class, 'start'])->name('exams.start');
    Route::post('exams/{exam}/attempts/{attempt}/submit', [\App\Http\Controllers\Student\ExamController::class, 'submit'])->name('exams.submit');

    // Marketplace de recompensas
    Route::view('marketplace', 'student.marketplace.index')->name('marketplace');

    // Unirse a Clases
    Route::get('groups/join', [JoinGroupController::class, 'show'])->name('groups.join');
    Route::post('groups/join', [JoinGroupController::class, 'join'])->name('groups.join.store');
    Route::delete('groups/{group}/leave', [JoinGroupController::class, 'leave'])->name('groups.leave');
});

// ========================================
// RECURSOS Y AYUDA (Todos los roles con control interno)
// ========================================
Route::middleware(['auth', 'verified'])->prefix('resources')->name('resources.')->group(function () {
    // Reglamento (Ver todos, editar solo admin)
    Route::get('regulations', [\App\Http\Controllers\Resources\RegulationController::class, 'index'])->name('regulations.index');
    Route::middleware('role:admin')->group(function () {
        Route::get('regulations/create', [\App\Http\Controllers\Resources\RegulationController::class, 'create'])->name('regulations.create');
        Route::post('regulations', [\App\Http\Controllers\Resources\RegulationController::class, 'store'])->name('regulations.store');
        Route::get('regulations/{regulation}/edit', [\App\Http\Controllers\Resources\RegulationController::class, 'edit'])->name('regulations.edit');
        Route::put('regulations/{regulation}', [\App\Http\Controllers\Resources\RegulationController::class, 'update'])->name('regulations.update');
    });

    // Centro de Ayuda / FAQs
    Route::get('help', function () {
        return view('resources.help');
    })->name('help');
    
    // Manual del Docente (Solo docentes/admins)
    Route::middleware('role:admin|docente')->get('manual', function () {
        return view('resources.manual');
    })->name('manual');
});

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Registro de Auditoría
    Route::get('audit', [\App\Http\Controllers\Admin\AuditController::class, 'index'])->name('audit');
    
    // Soporte del Sistema
    Route::get('support', function () {
        return view('admin.support');
    })->name('support');
});

// ========================================
// MÓDULO EDUCATIVO SAT (Todos los usuarios)
// ========================================
Route::middleware(['auth', 'verified'])->prefix('sat-education')->name('sat-education.')->group(function () {
    Route::get('/', [SatEducationController::class, 'index'])->name('index');
    Route::get('rfc', [SatEducationController::class, 'rfc'])->name('rfc');
    Route::get('lessons/{lesson}', [SatEducationController::class, 'show'])->name('show');
});

require __DIR__.'/settings.php';
