<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = auth()->user()->taughtGroups()
            ->withCount('students')
            ->latest()
            ->get();

        return view('teacher.groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teacher.groups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject' => 'nullable|string|max:255',
            'grade' => 'nullable|string|max:50',
        ]);

        $group = Group::create([
            'teacher_id' => auth()->id(),
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'subject' => $validated['subject'] ?? null,
            'grade' => $validated['grade'] ?? null,
        ]);

        return redirect()
            ->route('teacher.groups.show', $group)
            ->with('success', 'Clase creada exitosamente. Comparte el código: ' . $group->code);
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        // Verificar que el usuario es el profesor de esta clase
        if ($group->teacher_id !== auth()->id()) {
            abort(403);
        }

        $group->load(['students' => function ($query) {
            $query->with('wallet')->orderBy('name');
        }]);

        return view('teacher.groups.show', compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        if ($group->teacher_id !== auth()->id()) {
            abort(403);
        }

        return view('teacher.groups.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        if ($group->teacher_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject' => 'nullable|string|max:255',
            'grade' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        $group->update($validated);

        return redirect()
            ->route('teacher.groups.show', $group)
            ->with('success', 'Clase actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        if ($group->teacher_id !== auth()->id()) {
            abort(403);
        }

        $group->delete();

        return redirect()
            ->route('teacher.groups.index')
            ->with('success', 'Clase eliminada exitosamente');
    }

    /**
     * Regenerar código de la clase
     */
    public function regenerateCode(Group $group)
    {
        if ($group->teacher_id !== auth()->id()) {
            abort(403);
        }

        $group->code = strtoupper(\Illuminate\Support\Str::random(8));
        $group->save();

        return back()->with('success', 'Código regenerado: ' . $group->code);
    }

    /**
     * Remover estudiante de la clase
     */
    public function removeStudent(Group $group, \App\Models\User $student)
    {
        if ($group->teacher_id !== auth()->id()) {
            abort(403);
        }

        $group->removeStudent($student);

        return back()->with('success', 'Estudiante removido de la clase');
    }
}
