<?php

namespace App\Http\Controllers\Admin;

use App\Concerns\LogsActivity;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class TeacherController extends Controller
{
    use LogsActivity;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // El acceso admin está garantizado por la ruta (middleware role:admin).
        $teachers = User::role('docente')
            ->with('wallet')
            ->latest()
            ->paginate(15);

        return view('admin.teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * El rol se asigna aquí de forma explícita (el modelo ya no auto-asigna
     * ningún rol al crear), evitando que un docente herede el rol 'alumno'.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Password::defaults()],
            'rfc' => ['nullable', 'string', 'max:13', 'unique:users'],
        ]);

        // Crear el usuario docente
        $teacher = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'rfc' => $validated['rfc'] ?? null,
        ]);

        // Asignar rol de docente (esto evitará que se asigne 'alumno' automáticamente)
        $teacher->assignRole('docente');

        $this->logActivity('user.docente_created', "Docente creado: {$teacher->email}", ['user_id' => $teacher->id]);

        return redirect()
            ->route('admin.teachers.index')
            ->with('success', 'Docente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $teacher)
    {
        abort_unless($teacher->hasRole('docente'), 404);

        $teacher->load(['wallet', 'taughtGroups' => function ($query) {
            $query->withCount('students');
        }]);

        return view('admin.teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $teacher)
    {
        abort_unless($teacher->hasRole('docente'), 404);

        return view('admin.teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $teacher)
    {
        abort_unless($teacher->hasRole('docente'), 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$teacher->id],
            'password' => ['nullable', Password::defaults()],
            'rfc' => ['nullable', 'string', 'max:13', 'unique:users,rfc,'.$teacher->id],
        ]);

        $teacher->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'rfc' => $validated['rfc'] ?? $teacher->rfc,
        ]);

        // Actualizar contraseña solo si se proporciona
        if (! empty($validated['password'])) {
            $teacher->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        $this->logActivity('user.docente_updated', "Docente actualizado: {$teacher->email}", ['user_id' => $teacher->id]);

        return redirect()
            ->route('admin.teachers.index')
            ->with('success', 'Docente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $teacher)
    {
        abort_unless($teacher->hasRole('docente'), 404);

        $teacher->delete();

        $this->logActivity('user.docente_deleted', "Docente eliminado: {$teacher->email}", ['user_id' => $teacher->id]);

        return redirect()
            ->route('admin.teachers.index')
            ->with('success', 'Docente eliminado exitosamente.');
    }
}
