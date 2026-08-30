<?php

namespace App\Http\Controllers\Teacher;

use App\Concerns\LogsActivity;
use App\Http\Controllers\Controller;
use App\Models\Reward;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    use LogsActivity;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rewards = Reward::latest()->paginate(15);

        return view('teacher.rewards.index', compact('rewards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teacher.rewards.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
        ]);

        Reward::create($validated);

        $this->logActivity('reward.created', "Recompensa creada: {$validated['name']}");

        return redirect()
            ->route('teacher.rewards.index')
            ->with('success', 'Recompensa creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reward $reward)
    {
        return view('teacher.rewards.show', compact('reward'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reward $reward)
    {
        return view('teacher.rewards.edit', compact('reward'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reward $reward)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
        ]);

        $reward->update($validated);

        $this->logActivity('reward.updated', "Recompensa actualizada: {$reward->name}");

        return redirect()
            ->route('teacher.rewards.index')
            ->with('success', 'Recompensa actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reward $reward)
    {
        $reward->delete();

        $this->logActivity('reward.deleted', "Recompensa eliminada: {$reward->name}");

        return redirect()
            ->route('teacher.rewards.index')
            ->with('success', 'Recompensa eliminada exitosamente');
    }
}
