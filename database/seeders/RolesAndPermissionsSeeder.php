<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ========================================
        // CREAR PERMISOS (idempotente)
        // ========================================

        // Permisos de Usuarios
        foreach (['view users', 'create users', 'edit users', 'delete users'] as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Permisos de Tareas
        foreach (['view tasks', 'create tasks', 'edit tasks', 'delete tasks', 'complete tasks', 'grade tasks'] as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Permisos de Recompensas (Marketplace)
        foreach (['view rewards', 'create rewards', 'edit rewards', 'delete rewards', 'redeem rewards', 'approve redemptions'] as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Permisos de Transacciones (AulaChain)
        foreach (['view own transactions', 'view all transactions', 'create transactions', 'transfer ac'] as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Permisos de Facturas SAT
        foreach (['view invoices', 'generate invoices', 'manage tax settings'] as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Permisos de Reportes y Analíticas
        foreach (['view reports', 'view analytics', 'export data'] as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Permisos de Configuración
        foreach (['manage settings', 'manage roles'] as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ========================================
        // CREAR ROLES Y ASIGNAR PERMISOS (idempotente)
        // ========================================

        // ROL: ADMIN
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::all());

        // ROL: DOCENTE
        $docenteRole = Role::firstOrCreate(['name' => 'docente']);
        $docenteRole->syncPermissions([
            'view users',
            'view tasks',
            'create tasks',
            'edit tasks',
            'delete tasks',
            'grade tasks',
            'view rewards',
            'create rewards',
            'edit rewards',
            'delete rewards',
            'approve redemptions',
            'view all transactions',
            'create transactions',
            'view invoices',
            'generate invoices',
            'view reports',
            'view analytics',
            'export data',
        ]);

        // ROL: ALUMNO
        $alumnoRole = Role::firstOrCreate(['name' => 'alumno']);
        $alumnoRole->syncPermissions([
            'view tasks',
            'complete tasks',
            'view rewards',
            'redeem rewards',
            'view own transactions',
            'transfer ac',
            'view invoices',
        ]);
    }
}
