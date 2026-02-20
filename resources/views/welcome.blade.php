<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head', ['title' => 'EducaTe - Bienvenida'])
</head>

<body class="min-h-screen bg-white dark:bg-neutral-dark text-neutral-dark font-sans selection:bg-blue-500/30">

    <!-- Background Gradients -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10 text-neutral-dark">
        <div class="absolute -top-[25%] -left-[10%] w-[70%] h-[70%] bg-blue-500/10 blur-[120px] rounded-full"></div>
        <div class="absolute -bottom-[25%] -right-[10%] w-[70%] h-[70%] bg-green-500/10 blur-[120px] rounded-full">
        </div>
    </div>

    <flux:header container
        class="border-b border-neutral-light bg-white/80 backdrop-blur-md dark:border-neutral-light dark:bg-neutral-dark/80 sticky top-0 z-50">
        <x-app-logo href="/" class="max-sm:hidden" />
        <x-app-logo icon-only class="sm:hidden" />

        <flux:spacer />

        <flux:navbar class="hidden md:flex">
            <flux:navbar.item href="#features">Funcionalidades</flux:navbar.item>
            <flux:navbar.item href="#roles">Roles</flux:navbar.item>
            <flux:navbar.item href="#about">Sobre EducaTe</flux:navbar.item>
        </flux:navbar>

        <flux:spacer />

        <div class="flex items-center gap-2">
            @auth
                <flux:button href="{{ route('dashboard') }}" variant="primary" wire:navigate>Dashboard</flux:button>
            @else
                <flux:button href="{{ route('login') }}" variant="ghost" wire:navigate>Entrar</flux:button>
                <flux:button href="{{ route('register') }}" variant="primary" wire:navigate>Empezar</flux:button>
            @endauth
        </div>
    </flux:header>

    <main>
        <!-- Hero Section -->
        <section class="relative pt-20 pb-24 lg:pt-32 lg:pb-40 overflow-hidden">
            <div class="container mx-auto px-6 text-center">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-500 text-sm font-medium mb-8 animate-fade-in-up">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-500/40 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                    </span>
                    Nueva Experiencia Educativa
                </div>

                <h1 class="text-5xl lg:text-7xl font-bold tracking-tight mb-8 animate-fade-in-up"
                    style="animation-delay: 100ms">
                    Educa<span class="text-blue-500">Te</span>
                    <br />
                    El Futuro del Aprendizaje
                </h1>

                <p class="max-w-2xl mx-auto text-lg lg:text-xl text-neutral-medium mb-12 animate-fade-in-up"
                    style="animation-delay: 200ms">
                    Una plataforma integral diseñada para modernizar la gestión académica,
                    potenciar la enseñanza y motivar a los estudiantes a través de gamificación y analíticas
                    inteligentes.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-fade-in-up"
                    style="animation-delay: 300ms">
                    <flux:button variant="primary" href="{{ route('register') }}"
                        class="w-full sm:w-auto px-8 h-12 text-base shadow-lg shadow-blue-500/20">
                        Crear Cuenta Gratuita
                    </flux:button>
                    <flux:button variant="ghost" href="#features"
                        class="w-full sm:w-auto px-8 h-12 text-base border-neutral-light">
                        Ver características
                    </flux:button>
                </div>

                <div class="mt-20 relative animate-fade-in-up" style="animation-delay: 400ms">
                    <div
                        class="absolute inset-0 bg-linear-to-t from-zinc-50 dark:from-zinc-950 to-transparent z-10 h-24 bottom-0">
                    </div>
                    <div
                        class="rounded-2xl border border-neutral-light dark:border-neutral-light/20 bg-neutral-very-light dark:bg-neutral-dark/50 overflow-hidden shadow-2xl mx-auto max-w-5xl aspect-video relative">
                        <!-- Placeholder for a dashboard screenshot or video -->
                        <div class="absolute inset-0 flex items-center justify-center bg-neutral-light/10">
                            <x-app-logo-icon class="size-24 opacity-20" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features"
            class="py-24 bg-neutral-very-light dark:bg-neutral-dark/30 border-y border-neutral-light dark:border-neutral-light/10">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold mb-4">Todo lo que necesitas para tu institución</h2>
                    <p class="text-neutral-medium">Herramientas diseñadas para cada actor del proceso educativo.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div
                        class="p-8 rounded-2xl bg-white dark:bg-neutral-dark border border-neutral-light dark:border-neutral-light/20 hover:border-blue-500/50 transition-colors group">
                        <div
                            class="size-12 rounded-xl bg-blue-500/10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <flux:icon icon="academic-cap" class="text-blue-500" />
                        </div>
                        <h3 class="text-xl font-bold mb-3">Gestión Académica</h3>
                        <p class="text-neutral-medium leading-relaxed">Control total sobre docentes, alumnos y
                            actividades curriculares desde un solo lugar.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div
                        class="p-8 rounded-2xl bg-white dark:bg-neutral-dark border border-neutral-light dark:border-neutral-light/20 hover:border-green-500/50 transition-colors group">
                        <div
                            class="size-12 rounded-xl bg-green-500/10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <flux:icon icon="bolt" class="text-green-500" />
                        </div>
                        <h3 class="text-xl font-bold mb-3">Gamificación</h3>
                        <p class="text-neutral-medium leading-relaxed">Marketplace de recompensas y sistema de niveles
                            para incentivar el desempeño de los estudiantes.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div
                        class="p-8 rounded-2xl bg-white dark:bg-neutral-dark border border-neutral-light dark:border-neutral-light/20 hover:border-orange-500/50 transition-colors group">
                        <div
                            class="size-12 rounded-xl bg-orange-500/10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <flux:icon icon="chart-bar-square" class="text-orange-500" />
                        </div>
                        <h3 class="text-xl font-bold mb-3">Analíticas Inteligentes</h3>
                        <p class="text-neutral-medium leading-relaxed">Reportes detallados y seguimiento en tiempo real
                            del progreso de cada aula y estudiante.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Roles Section -->
        <section id="roles" class="py-24 overflow-hidden">
            <div class="container mx-auto px-6">
                <div class="flex flex-col lg:flex-row items-center gap-16">
                    <div class="lg:w-1/2">
                        <h2 class="text-3xl lg:text-4xl font-bold mb-6">Adaptado a cada necesidad</h2>
                        <p class="text-lg text-neutral-medium mb-8 leading-relaxed">
                            EducaTe no solo es un sistema, es un ecosistema. Hemos diseñado experiencias únicas para
                            administradores, docentes y alumnos, asegurando que cada uno tenga las herramientas que
                            realmente necesita.
                        </p>

                        <ul class="space-y-4">
                            <li
                                class="flex items-start gap-4 p-4 rounded-xl bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800">
                                <div
                                    class="mt-1 size-6 rounded-full bg-indigo-500 flex items-center justify-center shrink-0">
                                    <flux:icon icon="check" variant="solid" class="size-4 text-white" />
                                </div>
                                <div>
                                    <h4 class="font-bold">Admin</h4>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Supervisión global, gestión de
                                        personal y configuración avanzada del sistema.</p>
                                </div>
                            </li>
                            <li
                                class="flex items-start gap-4 p-4 rounded-xl bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800">
                                <div
                                    class="mt-1 size-6 rounded-full bg-blue-500 flex items-center justify-center shrink-0">
                                    <flux:icon icon="check" variant="solid" class="size-4 text-white" />
                                </div>
                                <div>
                                    <h4 class="font-bold">Docente</h4>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Creación de tareas, evaluaciones
                                        y visualización de progreso grupal.</p>
                                </div>
                            </li>
                            <li
                                class="flex items-start gap-4 p-4 rounded-xl bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800">
                                <div
                                    class="mt-1 size-6 rounded-full bg-teal-500 flex items-center justify-center shrink-0">
                                    <flux:icon icon="check" variant="solid" class="size-4 text-white" />
                                </div>
                                <div>
                                    <h4 class="font-bold">Alumno</h4>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Entorno de aprendizaje
                                        interactivo, Wallet virtual y canje de recompensas.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="lg:w-1/2 relative">
                        <div
                            class="relative bg-linear-to-br from-blue-500 to-green-500 p-1 z-10 shadow-3xl rounded-3xl">
                            <div
                                class="bg-neutral-dark rounded-[22px] overflow-hidden aspect-square flex items-center justify-center p-12">
                                <x-app-logo-icon class="size-48" />
                            </div>
                        </div>
                        <div class="absolute -top-12 -right-12 size-64 bg-blue-500/20 blur-[100px] -z-10 rounded-full">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-24">
            <div class="container mx-auto px-6">
                <div
                    class="relative rounded-3xl bg-blue-500 px-8 py-16 md:px-16 md:py-24 text-center overflow-hidden shadow-2xl">
                    <div
                        class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,#7fb069,transparent)] opacity-30">
                    </div>
                    <div class="relative z-10">
                        <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">¿Listo para transformar tu aula?</h2>
                        <p class="text-blue-50 text-lg md:text-xl max-w-2xl mx-auto mb-10">
                            Únete a EducaTe hoy mismo y experimenta una nueva forma de enseñar y aprender.
                        </p>
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                            <flux:button variant="ghost"
                                class="bg-white text-blue-500 hover:bg-neutral-very-light border-none w-full sm:w-auto h-12 px-8 text-base shadow-sm font-bold"
                                href="{{ route('register') }}">
                                Comenzar ahora
                            </flux:button>
                            <flux:button variant="ghost"
                                class="text-white border-white/30 hover:bg-white/10 w-full sm:w-auto h-12 px-8 text-base font-medium">
                                Contactar ventas
                            </flux:button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="py-12 border-t border-neutral-light dark:border-neutral-light/10">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                <div class="flex items-center gap-3">
                    <x-app-logo icon-only />
                    <span class="font-bold text-xl tracking-tight font-heading">Educa<span
                            class="text-blue-500">Te</span></span>
                </div>

                <div class="flex gap-8 text-sm text-neutral-medium">
                    <a href="#" class="hover:text-blue-500 transition-colors">Privacidad</a>
                    <a href="#" class="hover:text-blue-500 transition-colors">Términos</a>
                    <a href="#" class="hover:text-blue-500 transition-colors">Soporte</a>
                </div>

                <div class="text-neutral-medium text-sm">
                    &copy; {{ date('Y') }} EducaTe. Todos los derechos reservados.
                </div>
            </div>
        </div>
    </footer>

    @fluxScripts
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
        }
    </style>
</body>

</html>