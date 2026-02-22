<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Solo admins pueden acceder
        abort_unless(auth()->user()->hasRole('admin'), 403);
        
        $alumnos = User::role('alumno')
            ->with('wallet')
            ->latest()
            ->paginate(15);
        
        return view('admin.alumnos.index', compact('alumnos'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $alumno)
    {
        abort_unless(auth()->user()->hasRole('admin'), 403);
        abort_unless($alumno->hasRole('alumno'), 404);
        
        $alumno->load(['wallet', 'groups']);
        
        return view('admin.alumnos.show', compact('alumno'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $alumno)
    {
        abort_unless(auth()->user()->hasRole('admin'), 403);
        abort_unless($alumno->hasRole('alumno'), 404);
        
        $alumno->delete();

        return redirect()
            ->route('admin.alumnos.index')
            ->with('success', 'Alumno eliminado exitosamente.');
    }
}
