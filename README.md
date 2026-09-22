# KANG Sistema de Inventarios

Aplicación web multi-tenant para el control de inventarios, construida con Laravel y Livewire. Cada empresa registrada administra sus propios productos y movimientos de stock de forma aislada, con roles de **Administrador** y **Operario**.

## Características

- **Multi-tenant por empresa**: productos y movimientos aislados por `company_id`.
- **Autenticación con Livewire**: login reactivo con redirección según el rol.
- **Registro de empresas**: al crear una cuenta se crea la empresa y su primer Administrador.
- **Gestión de productos**: CRUD completo con búsqueda por nombre, SKU o categoría y SKU único por empresa.
- **Movimientos de inventario**: entradas y salidas con actualización automática del stock, control de stock insuficiente y filtrado por tipo.
- **Gestión de operarios**: los Administradores crean/eliminan operarios de su propia empresa.
- **Dashboard**: métricas (productos, unidades en stock, stock bajo), stock por categoría y movimientos recientes.
- **Autorización por permisos**: menú y rutas protegidas según el permiso del usuario.

## Stack tecnológico

| Capa | Tecnología |
| --- | --- |
| Framework | Laravel 13 (PHP 8.5) |
| UI reactiva | Livewire 4 (componentes basados en clases) |
| Estilos | Tailwind CSS |
| Roles y permisos | spatie/laravel-permission |
| Base de datos | MariaDB (vía Docker), SQLite para tests |
| Tests | Pest / PHPUnit |

## Roles y permisos

| Rol | Permisos |
| --- | --- |
| Administrador | `manage products`, `register movements`, `manage operators` |
| Operario | `register movements` |

El login redirige según el permiso: los administradores van a `/dashboard` y los operarios directamente a `movements.index`.

## Requisitos

- PHP 8.5 y Composer
- Node.js y npm
- MariaDB/MySQL (o el contenedor Docker incluido en `docker-compose.yml`)
- Laravel Herd (opcional, para servir la aplicación)

## Instalación

```bash
# 1. Clonar el repositorio
git clone git@github.com:KellyAcosta2005/InventorySystem-FS-VI.git
cd InventorySystem-FS-VI

# 2. Instalar dependencias
composer install
npm install

# 3. Configurar el entorno
cp .env.example .env
php artisan key:generate

# 4. Levantar la base de datos (con Docker) y configurar .env
docker compose up -d
#   DB_CONNECTION=mysql
#   DB_HOST=127.0.0.1
#   DB_PORT=3306
#   DB_DATABASE=deposito_kang
#   DB_USERNAME=kang_user
#   DB_PASSWORD=<tu_password>

# 5. Migrar y sembrar la base de datos
php artisan migrate --seed

# 6. Compilar assets
npm run build

# 7. Servir la aplicación
composer run dev   # o php artisan serve
```

### Usuario de prueba (seeder)

| Campo | Valor |
| --- | --- |
| Nombre | Test User |
| Email | `test@example.com` |
| Contraseña | `password` |

## Estructura del proyecto

```
app/
├── Http/
│   ├── Controllers/    # AuthController, ProductController, MovementController, OperatorController
│   └── Requests/       # ProductRequest, StoreMovementRequest
├── Livewire/           # Componente de Login
├── Models/             # User, Company, Product, Movement
└── Services/           # MovementService (registro de movimientos + stock)
config/                 # livewire.php, permission.php
database/
├── factories/          # Factories para tests
├── migrations/         # Tablas companies, products, movements, permisos
└── seeders/            # RolePermissionSeeder, DatabaseSeeder
resources/views/        # Vistas Blade (layouts, auth, products, movements, operators, livewire)
routes/web.php          # Definición de rutas y middleware
tests/Feature/          # Suite de tests (Pest)
```

## Tests

```bash
php artisan test
```

La suite cubre: autenticación y autorización, registro de empresas, gestión de operarios, aislamiento multi-tenant, `MovementService`, filtrado y búsqueda de productos/movimientos, redirecciones por rol, dashboard y health check (`/up`). Los tests se ejecutan sobre una base SQLite en memoria.