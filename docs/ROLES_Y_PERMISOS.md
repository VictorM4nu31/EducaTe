# Sistema de Roles y Permisos - EducaTe

## 📋 Roles Disponibles

### 1. **Admin** (Administrador)

- Acceso completo a todas las funcionalidades del sistema
- Puede gestionar usuarios, roles y permisos
- Acceso a configuración del sistema

### 2. **Docente** (Profesor)

- Crear, editar y eliminar tareas
- Calificar tareas de alumnos
- Gestionar recompensas del marketplace
- Aprobar canjes de recompensas
- Ver todas las transacciones
- Crear ajustes manuales de AulaChain
- Generar facturas SAT
- Acceso a reportes y analíticas

### 3. **Alumno** (Estudiante)

- Ver y completar tareas
- Ver y canjear recompensas
- Ver sus propias transacciones
- Realizar transferencias P2P
- Ver sus propias facturas

---

## 🔐 Permisos Disponibles

### Usuarios

- `view users` - Ver usuarios
- `create users` - Crear usuarios
- `edit users` - Editar usuarios
- `delete users` - Eliminar usuarios

### Tareas

- `view tasks` - Ver tareas
- `create tasks` - Crear tareas
- `edit tasks` - Editar tareas
- `delete tasks` - Eliminar tareas
- `complete tasks` - Completar tareas (alumnos)
- `grade tasks` - Calificar tareas (docentes)

### Recompensas

- `view rewards` - Ver recompensas
- `create rewards` - Crear recompensas
- `edit rewards` - Editar recompensas
- `delete rewards` - Eliminar recompensas
- `redeem rewards` - Canjear recompensas (alumnos)
- `approve redemptions` - Aprobar canjes (docentes)

### Transacciones

- `view own transactions` - Ver propias transacciones
- `view all transactions` - Ver todas las transacciones
- `create transactions` - Crear transacciones (ajustes manuales)
- `transfer ac` - Transferir AulaChain (P2P)

### Facturas SAT

- `view invoices` - Ver facturas
- `generate invoices` - Generar facturas
- `manage tax settings` - Gestionar configuración fiscal

### Reportes

- `view reports` - Ver reportes
- `view analytics` - Ver analíticas
- `export data` - Exportar datos

### Configuración

- `manage settings` - Gestionar configuración
- `manage roles` - Gestionar roles y permisos

---

## 💻 Uso en el Código

### Verificar Roles

```php
// En controladores o vistas
if (auth()->user()->hasRole('admin')) {
    // Código para admin
}

if (auth()->user()->hasRole(['admin', 'docente'])) {
    // Código para admin o docente
}

// Usando helpers
if (is_admin()) {
    // Es admin
}

if (is_docente()) {
    // Es docente
}

if (is_alumno()) {
    // Es alumno
}
```

### Verificar Permisos

```php
// En controladores
if (auth()->user()->can('create tasks')) {
    // Puede crear tareas
}

// Usando helpers
if (can_manage_tasks()) {
    // Puede gestionar tareas
}

if (can_manage_rewards()) {
    // Puede gestionar recompensas
}

if (can_view_analytics()) {
    // Puede ver analíticas
}
```

### En Blade Templates

```blade
@role('admin')
    <p>Solo visible para administradores</p>
@endrole

@hasanyrole('admin|docente')
    <p>Visible para admin o docente</p>
@endhasanyrole

@can('create tasks')
    <button>Crear Tarea</button>
@endcan

@if(is_docente())
    <div>Panel de Docente</div>
@endif

<!-- Badge de rol -->
{!! user_role_badge() !!}
```

### Proteger Rutas

```php
// En routes/web.php
use App\Http\Middleware\EnsureUserHasRole;

Route::middleware(['auth', EnsureUserHasRole::class.':admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
});

Route::middleware(['auth', EnsureUserHasRole::class.':admin,docente'])->group(function () {
    Route::resource('/tasks', TaskController::class);
});

// O usando Spatie directamente
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/settings', [SettingsController::class, 'index']);
});

Route::middleware(['auth', 'permission:create tasks'])->group(function () {
    Route::post('/tasks', [TaskController::class, 'store']);
});
```

---

## 👥 Usuarios de Prueba

Después de ejecutar el seeder, tendrás estos usuarios disponibles:

| Email                        | Contraseña | Rol     | RFC           |
| ---------------------------- | ---------- | ------- | ------------- |
| admin@educate.com            | password   | Admin   | XAXX010101000 |
| docente@educate.com          | password   | Docente | GAGM850315ABC |
| juan.perez@educate.com       | password   | Alumno  | PEXJ100520XYZ |
| maria.lopez@educate.com      | password   | Alumno  | LOMM110315ABC |
| carlos.rodriguez@educate.com | password   | Alumno  | RODC090810DEF |

---

## 🚀 Comandos Útiles

```bash
# Ejecutar el seeder de roles
php artisan db:seed --class=RolesAndPermissionsSeeder

# Limpiar caché de permisos
php artisan permission:cache-reset

# Ver todos los roles
php artisan tinker
>>> \Spatie\Permission\Models\Role::all();

# Ver todos los permisos
>>> \Spatie\Permission\Models\Permission::all();

# Asignar rol a usuario
>>> $user = User::find(1);
>>> $user->assignRole('admin');

# Dar permiso a usuario
>>> $user->givePermissionTo('create tasks');
```

---

## 📚 Documentación Adicional

Para más información sobre el paquete Spatie Laravel Permission:
https://spatie.be/docs/laravel-permission/v6/introduction
