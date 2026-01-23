<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

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
        // CREAR PERMISOS
        // ========================================
        
        // Permisos de Usuarios
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        
        // Permisos de Tareas
        Permission::create(['name' => 'view tasks']);
        Permission::create(['name' => 'create tasks']);
        Permission::create(['name' => 'edit tasks']);
        Permission::create(['name' => 'delete tasks']);
        Permission::create(['name' => 'complete tasks']); // Para alumnos
        Permission::create(['name' => 'grade tasks']); // Para docentes
        
        // Permisos de Recompensas (Marketplace)
        Permission::create(['name' => 'view rewards']);
        Permission::create(['name' => 'create rewards']);
        Permission::create(['name' => 'edit rewards']);
        Permission::create(['name' => 'delete rewards']);
        Permission::create(['name' => 'redeem rewards']); // Para alumnos
        Permission::create(['name' => 'approve redemptions']); // Para docentes
        
        // Permisos de Transacciones (AulaChain)
        Permission::create(['name' => 'view own transactions']);
        Permission::create(['name' => 'view all transactions']);
        Permission::create(['name' => 'create transactions']); // Para docentes (ajustes manuales)
        Permission::create(['name' => 'transfer ac']); // P2P para alumnos
        
        // Permisos de Facturas SAT
        Permission::create(['name' => 'view invoices']);
        Permission::create(['name' => 'generate invoices']);
        Permission::create(['name' => 'manage tax settings']);
        
        // Permisos de Reportes y Analíticas
        Permission::create(['name' => 'view reports']);
        Permission::create(['name' => 'view analytics']);
        Permission::create(['name' => 'export data']);
        
        // Permisos de Configuración
        Permission::create(['name' => 'manage settings']);
        Permission::create(['name' => 'manage roles']);
        
        // ========================================
        // CREAR ROLES Y ASIGNAR PERMISOS
        // ========================================
        
        // ROL: ADMIN
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all()); // Todos los permisos
        
        // ROL: DOCENTE
        $docenteRole = Role::create(['name' => 'docente']);
        $docenteRole->givePermissionTo([
            // Usuarios (solo ver)
            'view users',
            
            // Tareas (control completo)
            'view tasks',
            'create tasks',
            'edit tasks',
            'delete tasks',
            'grade tasks',
            
            // Recompensas (control completo)
            'view rewards',
            'create rewards',
            'edit rewards',
            'delete rewards',
            'approve redemptions',
            
            // Transacciones
            'view all transactions',
            'create transactions', // Ajustes manuales de AC
            
            // Facturas
            'view invoices',
            'generate invoices',
            
            // Reportes
            'view reports',
            'view analytics',
            'export data',
        ]);
        
        // ROL: ALUMNO
        $alumnoRole = Role::create(['name' => 'alumno']);
        $alumnoRole->givePermissionTo([
            // Tareas
            'view tasks',
            'complete tasks',
            
            // Recompensas
            'view rewards',
            'redeem rewards',
            
            // Transacciones
            'view own transactions',
            'transfer ac', // Transferencias P2P
            
            // Facturas (solo ver las propias)
            'view invoices',
        ]);
        
        // ========================================
        // ASIGNAR ROLES A USUARIOS EXISTENTES
        // ========================================
        
        // Buscar usuario admin (puedes ajustar el criterio)
        $admin = User::where('email', 'admin@educate.com')->first();
        if ($admin) {
            $admin->assignRole('admin');
        }
        
        // Crear usuarios de ejemplo si no existen
        $this->createSampleUsers();
    }
    
    /**
     * Crear usuario administrador inicial
     * Los docentes serán creados por el admin desde el panel
     * Los alumnos se registrarán mediante el formulario público
     */
    private function createSampleUsers(): void
    {
        // Crear solo el Admin inicial
        if (!User::where('email', 'admin@educate.com')->exists()) {
            $admin = User::create([
                'name' => 'Administrador del Sistema',
                'email' => 'admin@educate.com',
                'password' => bcrypt('admin123'), // Cambiar en producción
                'rfc' => 'XAXX010101000',
            ]);
            $admin->assignRole('admin');
            
            // Crear wallet para admin
            $admin->wallet()->create(['balance' => 10000]);
            
            echo "✅ Usuario Admin creado: admin@educate.com / admin123\n";
        }
        
        // Crear algunos alumnos de ejemplo solo para desarrollo/testing
        if (app()->environment('local')) {
            $alumnos = [
                [
                    'name' => 'Juan Pérez',
                    'email' => 'juan.perez@educate.com',
                    'rfc' => 'PEXJ100520XYZ',
                    'balance' => 150,
                ],
                [
                    'name' => 'María López',
                    'email' => 'maria.lopez@educate.com',
                    'rfc' => 'LOMM110315ABC',
                    'balance' => 220,
                ],
                [
                    'name' => 'Carlos Rodríguez',
                    'email' => 'carlos.rodriguez@educate.com',
                    'rfc' => 'RODC090810DEF',
                    'balance' => 85,
                ],
            ];
            
            foreach ($alumnos as $alumnoData) {
                if (!User::where('email', $alumnoData['email'])->exists()) {
                    $alumno = User::create([
                        'name' => $alumnoData['name'],
                        'email' => $alumnoData['email'],
                        'password' => bcrypt('password'),
                        'rfc' => $alumnoData['rfc'],
                    ]);
                    $alumno->assignRole('alumno');
                    
                    // Crear wallet con balance inicial
                    $alumno->wallet()->create(['balance' => $alumnoData['balance']]);
                }
            }
            
            echo "✅ Alumnos de prueba creados (solo en ambiente local)\n";
        }
    }
}
