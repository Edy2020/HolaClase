# Despliegue en Render — HolaClase

Este proyecto está configurado para desplegarse en [Render](https://render.com) usando Docker.

## Archivos añadidos para el despliegue

### `Dockerfile`
Construye la imagen del contenedor con:
- **PHP 8.2 + Apache** como servidor web
- **Extensiones PostgreSQL** (`pdo_pgsql`, `pgsql`) para la base de datos en Render
- **Node.js 20** para compilar los assets de Vite/Tailwind (`npm run build`)
- **Composer** para instalar dependencias PHP sin paquetes de desarrollo
- Creación explícita de directorios de `storage/framework/` (git no trackea carpetas vacías)

### `docker-entrypoint.sh`
Script que se ejecuta al iniciar el contenedor:
1. Genera la `APP_KEY` si no está definida
2. Ejecuta las migraciones (`php artisan migrate --force`)
3. Crea el enlace simbólico del storage público
4. Limpia y recarga los cachés de config y rutas

### `bootstrap/app.php`
Configurado para confiar en todos los proxies (`trustProxies(at: '*')`), necesario para que Render genere URLs con HTTPS correctamente detrás de su load balancer.

---

## Variables de entorno requeridas en Render

Configurar en el panel de Render → Environment:

```
APP_NAME=HolaClase
APP_ENV=production
APP_KEY=base64:...          # Generado automáticamente si está vacío
APP_DEBUG=false
APP_URL=https://holaclaseserver.onrender.com

DB_CONNECTION=pgsql
DB_HOST=<host de PostgreSQL en Render>
DB_PORT=5432
DB_DATABASE=<nombre de la base de datos>
DB_USERNAME=<usuario>
DB_PASSWORD=<contraseña>

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=sync
LOG_CHANNEL=stderr
```

## URL de producción

🌐 **https://holaclaseserver.onrender.com**
