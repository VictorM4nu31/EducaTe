<?php

if (!function_exists('is_admin')) {
    /**
     * Check if the current user is an admin
     */
    function is_admin(): bool
    {
        return auth()->check() && auth()->user()->hasRole('admin');
    }
}

if (!function_exists('is_docente')) {
    /**
     * Check if the current user is a teacher
     */
    function is_docente(): bool
    {
        return auth()->check() && auth()->user()->hasRole('docente');
    }
}

if (!function_exists('is_alumno')) {
    /**
     * Check if the current user is a student
     */
    function is_alumno(): bool
    {
        return auth()->check() && auth()->user()->hasRole('alumno');
    }
}

if (!function_exists('can_manage_tasks')) {
    /**
     * Check if user can create/edit/delete tasks
     */
    function can_manage_tasks(): bool
    {
        return auth()->check() && (
            auth()->user()->hasRole(['admin', 'docente']) ||
            auth()->user()->can('create tasks')
        );
    }
}

if (!function_exists('can_manage_rewards')) {
    /**
     * Check if user can create/edit/delete rewards
     */
    function can_manage_rewards(): bool
    {
        return auth()->check() && (
            auth()->user()->hasRole(['admin', 'docente']) ||
            auth()->user()->can('create rewards')
        );
    }
}

if (!function_exists('can_view_analytics')) {
    /**
     * Check if user can view analytics and reports
     */
    function can_view_analytics(): bool
    {
        return auth()->check() && (
            auth()->user()->hasRole(['admin', 'docente']) ||
            auth()->user()->can('view analytics')
        );
    }
}

if (!function_exists('user_role_badge')) {
    /**
     * Get a formatted badge for the user's role
     */
    function user_role_badge(?string $role = null): string
    {
        $role = $role ?? (auth()->check() ? auth()->user()->getRoleNames()->first() : null);
        
        return match($role) {
            'admin' => '<span class="px-2 py-1 text-xs font-bold rounded bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300">Admin</span>',
            'docente' => '<span class="px-2 py-1 text-xs font-bold rounded bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300">Docente</span>',
            'alumno' => '<span class="px-2 py-1 text-xs font-bold rounded bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">Alumno</span>',
            default => '<span class="px-2 py-1 text-xs font-bold rounded bg-neutral-100 text-neutral-700 dark:bg-neutral-900/40 dark:text-neutral-300">Usuario</span>',
        };
    }
}
