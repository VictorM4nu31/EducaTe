<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class JoinGroupController extends Controller
{
    /**
     * Mostrar formulario para unirse a una clase
     */
    public function show()
    {
        $userGroups = auth()->user()->groups()->pluck('groups.id');
        
        return view('student.groups.join', [
            'myGroups' => auth()->user()->groups()->with('teacher')->get(),
        ]);
    }

    /**
     * Unirse a una clase usando código
     */
    public function join(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|size:8|exists:groups,code',
        ]);

        $group = Group::where('code', strtoupper($validated['code']))->first();

        if (!$group) {
            return back()->withErrors(['code' => 'Código de clase no válido']);
        }

        if (!$group->is_active) {
            return back()->withErrors(['code' => 'Esta clase no está activa']);
        }

        if (auth()->user()->isInGroup($group)) {
            return back()->withErrors(['code' => 'Ya estás en esta clase']);
        }

        $group->addStudent(auth()->user());

        return redirect()
            ->route('groups.join')
            ->with('success', "Te has unido exitosamente a la clase: {$group->name}");
    }

    /**
     * Salir de una clase
     */
    public function leave(Group $group)
    {
        if (!auth()->user()->isInGroup($group)) {
            return back()->withErrors(['error' => 'No estás en esta clase']);
        }

        $group->removeStudent(auth()->user());

        return redirect()
            ->route('groups.join')
            ->with('success', 'Has salido de la clase exitosamente');
    }
}
