<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-neutral-dark">
    <flux:sidebar sticky collapsible="mobile"
        class="border-e border-neutral-light bg-neutral-very-light dark:border-neutral-light dark:bg-neutral-very-light">
        <flux:sidebar.header>
            <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
            <flux:sidebar.collapse class="lg:hidden" />
        </flux:sidebar.header>

        <flux:sidebar.nav>
            <flux:sidebar.group :heading="__('Platform')" class="grid">
                <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                    wire:navigate>
                    {{ __('Dashboard') }}
                </flux:sidebar.item>
            </flux:sidebar.group>

            @role('admin')
            <flux:sidebar.group heading="Administración" class="grid">
                <flux:sidebar.item icon="layout-grid" :href="route('admin.dashboard')"
                    :current="request()->routeIs('admin.dashboard')" wire:navigate>
                    Dashboard Admin
                </flux:sidebar.item>
                <flux:sidebar.item icon="user-group" :href="route('admin.docentes.index')"
                    :current="request()->routeIs('admin.docentes.*')" wire:navigate>
                    Docentes
                </flux:sidebar.item>
                <flux:sidebar.item icon="users" :href="route('admin.alumnos.index')"
                    :current="request()->routeIs('admin.alumnos.index')" wire:navigate>
                    Alumnos
                </flux:sidebar.item>
                <flux:sidebar.item icon="cog-6-tooth" :href="route('admin.settings')"
                    :current="request()->routeIs('admin.settings')" wire:navigate>
                    Ajustes
                </flux:sidebar.item>
            </flux:sidebar.group>
            @endrole

            @role('docente')
            <flux:sidebar.group heading="Docencia" class="grid">
                <flux:sidebar.item icon="academic-cap" :href="route('teacher.tasks')"
                    :current="request()->routeIs('teacher.tasks*')" wire:navigate>
                    Tareas
                </flux:sidebar.item>
                <flux:sidebar.item icon="document-text" :href="route('teacher.exams.index')"
                    :current="request()->routeIs('teacher.exams*')" wire:navigate>
                    Exámenes
                </flux:sidebar.item>
                <flux:sidebar.item icon="user-group" :href="route('teacher.groups.index')"
                    :current="request()->routeIs('teacher.groups*')" wire:navigate>
                    Mis Clases
                </flux:sidebar.item>
                <flux:sidebar.item icon="gift" :href="route('teacher.rewards.index')"
                    :current="request()->routeIs('teacher.rewards*')" wire:navigate>
                    Recompensas
                </flux:sidebar.item>
                <flux:sidebar.item icon="chart-bar" :href="route('teacher.reports')"
                    :current="request()->routeIs('teacher.reports')" wire:navigate>
                    Reportes
                </flux:sidebar.item>
            </flux:sidebar.group>
            @endrole

            @role('alumno')
            @unlessrole('admin|docente')
            <flux:sidebar.group heading="Mi Aula" class="grid">
                <flux:sidebar.item icon="pencil-square" :href="route('tasks')" :current="request()->routeIs('tasks')"
                    wire:navigate>
                    Mis Tareas
                </flux:sidebar.item>
                <flux:sidebar.item icon="document-text" :href="route('student.exams')"
                    :current="request()->routeIs('student.exams*')" wire:navigate>
                    Exámenes
                </flux:sidebar.item>
                <flux:sidebar.item icon="user-group" :href="route('groups.join')"
                    :current="request()->routeIs('groups.*')" wire:navigate>
                    Mis Clases
                </flux:sidebar.item>
                <flux:sidebar.item icon="shopping-bag" :href="route('marketplace')"
                    :current="request()->routeIs('marketplace')" wire:navigate>
                    Marketplace
                </flux:sidebar.item>
            </flux:sidebar.group>
            @endunlessrole
            @endrole
        </flux:sidebar.nav>

        <flux:spacer />

        <flux:sidebar.nav>
            <flux:sidebar.group heading="Educación" class="grid">
                <flux:sidebar.item icon="academic-cap" :href="route('sat-education.index')"
                    :current="request()->routeIs('sat-education.*')" wire:navigate>
                    Módulo SAT
                </flux:sidebar.item>
            </flux:sidebar.group>

            <flux:sidebar.group heading="Recursos" class="grid">
                @role('admin')
                <flux:sidebar.item icon="clipboard-document-check" :href="route('admin.audit')"
                    :current="request()->routeIs('admin.audit')" wire:navigate>Registro de Auditoría</flux:sidebar.item>
                @endrole

                @role('docente')
                <flux:sidebar.item icon="book-open" :href="route('resources.manual')"
                    :current="request()->routeIs('resources.manual')" wire:navigate>Manual del Docente
                </flux:sidebar.item>
                <flux:sidebar.item icon="question-mark-circle" :href="route('resources.help')"
                    :current="request()->routeIs('resources.help')" wire:navigate>Centro de Ayuda</flux:sidebar.item>
                @endrole

                <flux:sidebar.item icon="document-text" :href="route('resources.regulations.index')"
                    :current="request()->routeIs('resources.regulations.*')" wire:navigate>Reglamento del Aula
                </flux:sidebar.item>

                @role('alumno')
                @unlessrole('admin|docente')
                <flux:sidebar.item icon="chat-bubble-left-right" :href="route('resources.help')"
                    :current="request()->routeIs('resources.help')" wire:navigate>Preguntas Frecuentes
                </flux:sidebar.item>
                @endunlessrole
                @endrole
            </flux:sidebar.group>
        </flux:sidebar.nav>

        <div class="hidden lg:block">
            <x-desktop-user-menu :name="auth()->user()->name" />
        </div>
    </flux:sidebar>


    <!-- Mobile User Menu -->
    <flux:header
        class="lg:hidden bg-white dark:bg-neutral-dark border-b border-neutral-light dark:border-neutral-light/10">
        <flux:sidebar.toggle class="lg:hidden text-neutral-dark dark:text-white" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <flux:avatar :name="auth()->user()->name" :initials="auth()->user()->initials()" />

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                        {{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                        class="w-full cursor-pointer" data-test="logout-button">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}

    @fluxScripts
</body>

</html>