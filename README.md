# ERP Inventario (PHP MVC)

Aplicación ERP simplificada para inventario, ventas y compras construída en PHP 8 con arquitectura MVC ligera.

## Requisitos
- PHP 8+
- MySQL/MariaDB
- Servidor web apuntando a `public/index.php`

## Instalación rápida
1. Crear base de datos y usuario según `config/database.php`.
2. Ejecutar el script `database/schema.sql` para crear tablas y datos de ejemplo.
3. Configurar virtual host/Apache para que el DocumentRoot sea la carpeta `public`.
4. Ajustar opciones en `config/config.php`.

Usuario demo: `admin@example.com` / contraseña `admin123`.

## Estructura
- `public/` front controller y assets.
- `app/core/` router, base Controller/Model, clases de sesión y seguridad.
- `app/controllers/` controladores por módulo.
- `app/models/` modelos de acceso a datos.
- `app/views/` vistas organizadas por módulo y layout principal.
- `database/schema.sql` migración inicial con datos de prueba.

## Módulos
- Autenticación y roles (administrador, vendedor, bodeguero, supervisor).
- Dashboard con ventas, alertas y movimientos.
- Productos e inventario con bodegas.
- Compras, proveedores, clientes y reportes básicos.
