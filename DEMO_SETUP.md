# 🎓 EducaTe - Demo Setup

## Instalación

```bash
php artisan migrate:fresh --seed
```

## Credenciales de Demo

| Rol | Email | Password | Saldo |
|-----|-------|----------|-------|
| Admin | admin@demo.educate.com | demo123 | ₳ 50,000 |
| Docente | docente@demo.educate.com | demo123 | ₳ 5,000 |
| Alumno | alumno@demo.educate.com | demo123 | ₳ 1,250 |

## Datos Creados

- **3 Grupos**: Historia, Matemáticas, Ciencias
- **11 Tareas**: 3 básicas + 4 intermedias + 4 avanzadas
- **14 Recompensas**: Snacks, privilegios, educación, experiencias
- **4 Usuarios**: 1 admin original + 3 demo

## Cómo Acceder

1. Navega a `http://localhost:8000`
2. Haz clic en botón "Demo" (navbar derecho)
3. Selecciona un usuario y copia sus credenciales
4. Haz clic en "Ir a Login"
5. Pega las credenciales y accede

## Características de Demo

✅ Modal con 3 tipos de usuario  
✅ Credenciales copiables con 1 click  
✅ Registro deshabilitado (solo acceso vía demo)  
✅ 2FA no disponible en cuentas demo  
✅ Datos extensos y realistas  
✅ Responsive y dark mode compatible  

## Notas

- Los datos se reinician con `migrate:fresh`
- Las cuentas demo son públicas (intencional)
- No afecta al admin original (admin@educate.com)
- 2FA muestra mensaje: "No disponible en demo"

