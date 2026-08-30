# EducaTe

> Plataforma educativa gamificada con economía interna (AulaChain) y educación fiscal SAT para el aula.

**EducaTe** transforma la gestión académica en una experiencia motivadora: estudiantes ganan monedas (AulaChain, ₳) al completar actividades, aprenden a administrar su dinero, hacen su declaración fiscal escolar y canjean recompensas en un marketplace. Todo con tres roles: **admin**, **docente** y **alumno**.

---

## ✨ Módulos principales

| Módulo | Descripción |
|--------|-------------|
| **AulaChain (Economía)** | Wallet, transacciones con retención fiscal del 5%, transferencias P2P, objetivos de ahorro, intereses simbólicos y estadísticas. |
| **Banco Virtual** | Dashboard financiero con ingresos, gastos, impuestos, gráfica de ahorro vs gasto y proyecciones. |
| **Marketplace** | Canje de AulaChains por premios reales o privilegios, con factura de compra. |
| **Exámenes** | Exámenes por clase con preguntas (opción múltiple, verdadero/falso, respuesta corta), pistas pagadas, tiempo límite, anulación por salir de la pestaña y re-habilitación por el docente. |
| **Tareas** | Entrega de archivos, calificación con feedback, bonificaciones (perfecto, calidad, entrega temprana) y penalizaciones (tardía). |
| **Módulo SAT** | Lecciones de educación fiscal, RFC simulado, calculadora de impuestos y simulador de declaración. |
| **Clases / Grupos** | Código de invitación para que los alumnos se unan a una clase. |
| **Auditoría** | Registro de acciones relevantes para el administrador. |
| **Reglamento y Ayuda** | Publicaciones del aula, manual del docente y centro de ayuda. |

---

## 🧰 Stack

- **Backend:** Laravel 12, PHP 8.4
- **Frontend:** Livewire 4, Volt 1 (componentes de archivo único), Flux 2, Tailwind CSS 4, Vite 7
- **Auth:** Laravel Fortify (verificación de email, reset de contraseñas, 2FA)
- **RBAC:** spatie/laravel-permission
- **Tests:** Pest 4
- **Base de datos:** SQLite (por defecto) / compatible con MySQL, PostgreSQL

---

## 🚀 Instalación

```bash
git clone <url-del-repositorio> educate
cd educate

composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed        # crea esquema + roles + datos demo
npm install
npm run build                     # compila assets de Vite
```

Para desarrollo (servidor + cola + Vite):

```bash
composer run dev
```

> Si usas `php artisan serve` sin Vite en modo dev, ten en cuenta que las vistas que
> usan `@vite` requieren `npm run build` previo.

---

## 👥 Credenciales de demostración

Se crean automáticamente con `php artisan migrate --seed`. **Solo para demos; cámbialas en producción** ajustando `APP_ENV` y las variables `.env`:

| Rol | Email | Contraseña |
|-----|-------|------------|
| Admin | `admin@educate.com` | `admin123` |
| Docente | `docente@educate.com` | `docente123` |
| Alumno | `alumno@educate.com` | `alumno123` |

> Los valores se pueden personalizar con `DEMO_ADMIN_EMAIL`, `DEMO_DOCENTE_EMAIL`,
> `DEMO_ALUMNO_EMAIL` y sus respetivas contraseñas en `.env`.

---

## 🏗️ Arquitectura y decisiones

- **`app/Services/EconomyService.php`** — punto único de crédito/débito/transferencia de AulaChains. Todos los movimientos monetarios pasan por aquí, con retención fiscal del 5% (SAT) en puntos base para evitar errores de punto flotante.
- **`app/Enums/TransactionType.php`** — vocabulario único de tipos de transacción (`income`, `expense`, `tax`, `p2p`, `reward`).
- **`app/Support/Money.php`** — aritmética monetaria en **centavos enteros**; convierte a unidades (AC) solo en el borde de entrada/salida.
- **Policies de autorización** (`app/Policies/*`) — el control de acceso se centraliza en Policies y `Gate::authorize()`, no disperso en los controladores.
- **`app/Traits/HasSlug.php`** — generación de slugs única por scope (p. ej. preguntas por `exam_id`).
- **RBAC con spatie/laravel-permission** — tres roles (admin, docente, alumno) con permisos granulares, middleware `role:` y bloque `@role` en las vistas.
- **Componentes Volt** — la lógica reactiva del frontend (banco, marketplace, pistas de examen, preguntas) se encapsula en componentes de archivo único.
- **Fortify** — autenticación headless con email verification y 2FA.

### Estructura de carpetas

```
app/
├── Actions/Fortify/      # Acciones de autenticación personalizadas
├── Enums/                # Tipos de dominio (TransactionType)
├── Http/Controllers/     # Admin, Teacher, Student, Resources, SAT
├── Models/               # Eloquent models
├── Policies/             # Autorización por recurso
├── Services/             # Lógica de negocio compartida (EconomyService)
├── Support/              # Helpers (Money)
└── Traits/               # HasSlug
resources/views/
├── layouts/              # Layout base (sidebar, auth)
├── livewire/             # Componentes Volt (banco, examen, profesor)
├── pages/                # Páginas Livewire (auth, settings)
├── sat-education/        # Módulo educativo SAT
├── student/  teacher/  admin/   # Vistas por rol
```

---

## 🧪 Tests

```bash
php artisan test              # suite completa
php artisan test --compact --filter=EconomyService
```

La suite usa Pest 4 con `RefreshDatabase` y siembra roles automáticamente.

---

## 🛠️ Comandos útiles

```bash
php artisan migrate:fresh --seed   # reset de BD + datos demo
vendor/bin/pint --format agent     # formatear código
php artisan route:list             # listar rutas
```

---

## 📄 Licencia

MIT — construido con fines educativos y de portafolio.
