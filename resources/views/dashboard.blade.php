<x-layouts::app :title="__('Dashboard')">
    <div class="container mx-auto py-6">
        <div class="mb-8 pl-1">
            <h1 class="text-3xl font-bold text-neutral-dark">Hola, {{ auth()->user()->name }} 👋</h1>
            <p class="text-neutral-medium">Bienvenido a tu panel de control de EducaTe.</p>
        </div>

        <livewire:bank.dashboard />
    </div>
</x-layouts::app>
