<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class DocenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Solo admins pueden acceder
        abort_unless(auth()->user()->hasRole('admin'), 403);
        
        $docentes = User::role('docente')
            ->with('wallet')
            ->latest()
            ->paginate(15);
        
        return view('admin.docentes.index', compact('docentes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_unless(auth()->user()->hasRole('admin'), 403);
        
        return view('admin.docentes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_unless(auth()->user()->hasRole('admin'), 403);
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Password::defaults()],
            'rfc' => ['nullable', 'string', 'max:13', 'unique:users'],
        ]);

        // Crear el usuario docente
        $docente = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'rfc' => $validated['rfc'] ?? null,
        ]);

        // Asignar rol de docente (esto evitará que se asigne 'alumno' automáticamente)
        $docente->assignRole('docente');

        return redirect()
            ->route('admin.docentes.index')
            ->with('success', 'Docente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $docente)
    {
        abort_unless(auth()->user()->hasRole('admin'), 403);
        abort_unless($docente->hasRole('docente'), 404);
        
        $docente->load('wallet');
        
        return view('admin.docentes.show', compact('docente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $docente)
    {
        abort_unless(auth()->user()->hasRole('admin'), 403);
        abort_unless($docente->hasRole('docente'), 404);
        
        return view('admin.docentes.edit', compact('docente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $docente)
    {
        abort_unless(auth()->user()->hasRole('admin'), 403);
        abort_unless($docente->hasRole('docente'), 404);
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $docente->id],
            'password' => ['nullable', Password::defaults()],
            'rfc' => ['nullable', 'string', 'max:13', 'unique:users,rfc,' . $docente->id],
        ]);

        $docente->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'rfc' => $validated['rfc'] ?? $docente->rfc,
        ]);

        // Actualizar contraseña solo si se proporciona
        if (!empty($validated['password'])) {
            $docente->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        return redirect()
            ->route('admin.docentes.index')
            ->with('success', 'Docente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $docente)
    {
        abort_unless(auth()->user()->hasRole('admin'), 403);
        abort_unless($docente->hasRole('docente'), 404);
        
        $docente->delete();

        return redirect()
            ->route('admin.docentes.index')
            ->with('success', 'Docente eliminado exitosamente.');
    }
}
