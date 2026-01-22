<x-layouts::app :title="__('Dashboard')">
    <div class="container mx-auto py-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Hola, {{ auth()->user()->name }} 👋</h1>
            <p class="text-neutral-500 dark:text-neutral-400">Bienvenido a tu panel de control de EducaTe.</p>
        </div>

        <livewire:bank.dashboard />
    </div>
</x-layouts::app>
