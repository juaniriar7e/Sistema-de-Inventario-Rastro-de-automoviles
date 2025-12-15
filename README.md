# Sistema de Inventario Rastro de Automóviles

Sistema web para gestión de inventario y ventas de partes de autos, con tienda pública y carrito de compras. Incluye panel de administración (CRUD), control de stock, registro de ventas, factura/resumen de compra, exportación a Excel, y seguridad con 2FA.

## Características principales

### Panel Admin
- CRUD de **Categorías**, **Autos**, **Partes**, **Clientes** y **Ventas**
- Activar/Desactivar registros (estado)
- Dashboard con métricas/gráficas (Chart.js)
- Exportación de partes a **Excel**
- Gestión de usuarios (según implementación)

### Tienda pública
- Catálogo por categorías
- Página de detalle de parte
- Visualización de imagen del producto
- Carrito de compras y checkout/resumen
- Confirmación de compra y generación de venta

### Seguridad
- Autenticación
- Verificación por email (si está habilitada)
- **Two-Factor Authentication (2FA)** para admin

## Tecnologías
- **Laravel 12**
- Blade + TailwindCSS
- MySQL
- Chart.js (CDN)
- (Opcional) Laravel Breeze para auth

## Requisitos
- PHP 8.3+
- Composer
- MySQL / MariaDB
- Node.js + npm (si compilas assets)

## Instalación

1) Clonar repo:
```bash
git clone https://github.com/juaniriar7e/Sistema-de-Inventario-Rastro-de-automoviles.git
cd Sistema-de-Inventario-Rastro-de-automoviles
```

## Instalar dependencias:

```bash
composer install
```

### Configurar entorno:

```bash
cp .env.example .env
php artisan key:generate
```

### Ajustar DB en .env:
    - DB_DATABASE
    - DB_USERNAME
    - DB_PASSWORD

### Migraciones:

```bash
php artisan migrate
```

### Storage (para imágenes):

```bash
php artisan storage:link
```

### (Opcional) Assets:

```bash
npm install
npm run dev
```

Levantar servidor:

php artisan serve

---

## Notas sobre imágenes

Las imágenes de partes se guardan en storage/app/public/... y se sirven desde public/storage mediante php artisan storage:link.

## Estructura general

resources/views/admin/... vistas del panel admin
resources/views/tienda/... vistas de la tienda
app/Http/Controllers/... controladores (Admin + Tienda + Carrito)
routes/web.php rutas públicas, auth y admin

---

Autor
Juan Iriarte
20-14-7325
1SF131
juan.iriarte1@utp.ac.pa
