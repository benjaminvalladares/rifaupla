# Rifa UPLA - Prueba 1 PHP y Servicios Web

Proyecto con dos partes: una API REST (`/api`) y un sistema web con sesiones (raíz).

## Cómo ejecutarlo

Requiere PHP 8+. Desde esta carpeta:

```
php -S localhost:8000
```

- Sistema web: http://localhost:8000/index.php
- API REST: http://localhost:8000/api/

Credenciales (web y API): usuario `userupla`, contraseña `upla123`.

## API REST (Postman)

Postman conserva la cookie de sesión automáticamente entre peticiones.

| # | Servicio | Método | URL | Parámetros |
|---|----------|--------|-----|------------|
| 1 | Iniciar sesión | POST | /api/login.php | usuario, clave |
| 2 | Listar participantes | GET | /api/participantes.php | - |
| 3 | Listar premios | GET | /api/premios.php | - |
| 4 | Registrar participante | POST | /api/registrar.php | nombre, apellido, numero_rifa |
| 5 | Actualizar participante | POST | /api/actualizar.php | id, y nombre / apellido / numero_rifa |
| 6 | Eliminar participante | GET | /api/eliminar.php?id=1 | id |
| 7 | Cerrar sesión | GET | /api/logout.php | - |

Los servicios 2 a 6 devuelven 401 si no hay sesión iniciada.
Datos en `api/data/participantes.json` y `api/data/premios.json`.

## Sistema web

- `index.php`: login con usuario, contraseña y CAPTCHA (suma aleatoria guardada en sesión).
- `panel.php`: página protegida con el menú.
- `rifa.php`: reserva de números ($2.000 c/u), persistente en sesión (F5 no pierde datos).
- `buscar.php`: búsqueda por GET (nombre, apellido, ciudad, categoría).
- `subir_comprobante.php`: sube archivos a `/comprobantes/` (protegido).
- `archivos.php`: lista los archivos cargados (protegido).
- `salir.php`: destruye la sesión y vuelve a `index.php`.

Participante de prueba para buscar: Universidad / Playa Ancha / Valparaiso / Grupo A.
