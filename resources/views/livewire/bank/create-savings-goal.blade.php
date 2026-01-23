<?php

use Livewire\Volt\Component;
use App\Models\SavingsGoal;
use Livewire\Attributes\Validate;

new class extends Component
{
    #[Validate('required|string|min:3|max:255')]
    public $name = '';

    #[Validate('nullable|string|max:500')]
    public $description = '';

    #[Validate('required|numeric|min:1')]
    public $target_amount = 100;

    #[Validate('nullable|date|after:today')]
    public $target_date = '';

    public $showForm = false;

    public function save()
    {
        $this->validate();

        SavingsGoal::create([
            'user_id' => auth()->id(),
            'name' => $this->name,
            'description' => $this->description ?: null,
            'target_amount' => $this->target_amount,
            'target_date' => $this->target_date ?: null,
            'current_amount' => auth()->user()->wallet->balance ?? 0,
        ]);

        $this->reset(['name', 'description', 'target_amount', 'target_date', 'showForm']);
        $this->dispatch('savings-goal-created');
        $this->dispatch('notify', ['message' => 'Objetivo de ahorro creado exitosamente', 'type' => 'success']);
    }
};
?>

<div>
    @if(!$showForm)
        <button 
            wire:click="$set('showForm', true)"
            class="p-1.5 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors"
            title="Crear objetivo de ahorro">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
        </button>
    @else
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" wire:click="$set('showForm', false)">
            <div class="bg-white dark:bg-neutral-900 rounded-xl shadow-xl max-w-md w-full p-6 space-y-4" wire:click.stop>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white">Nuevo Objetivo de Ahorro</h3>
                    <button wire:click="$set('showForm', false)" class="text-neutral-500 hover:text-neutral-700 dark:hover:text-neutral-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Nombre del Objetivo *</label>
                        <input 
                            type="text" 
                            wire:model="name"
                            class="w-full rounded-lg border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            placeholder="Ej: Comprar un libro"
                            required
                        />
                        @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Descripción (opcional)</label>
                        <textarea 
                            wire:model="description"
                            rows="2"
                            class="w-full rounded-lg border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            placeholder="Describe tu objetivo..."
                        ></textarea>
                        @error('description') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Meta (₳) *</label>
                        <input 
                            type="number" 
                            wire:model="target_amount"
                            min="1"
                            step="0.01"
                            class="w-full rounded-lg border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            required
                        />
                        @error('target_amount') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Fecha Objetivo (opcional)</label>
                        <input 
                            type="date" 
                            wire:model="target_date"
                            min="{{ now()->addDay()->format('Y-m-d') }}"
                            class="w-full rounded-lg border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        />
                        @error('target_date') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button 
                            type="button"
                            wire:click="$set('showForm', false)"
                            class="flex-1 px-4 py-2 border border-neutral-300 dark:border-neutral-700 rounded-lg text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors"
                        >
                            Cancelar
                        </button>
                        <button 
                            type="submit"
                            class="flex-1 px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors font-medium"
                        >
                            Crear Objetivo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
