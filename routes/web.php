<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\ParteController;
use App\Http\Controllers\Admin\AutoController;
use App\Http\Controllers\Admin\VentaController;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\InventarioPublicoController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\CarritoController;
use App\Models\Venta;


/*
|--------------------------------------------------------------------------
| Rutas públicas: TIENDA
|--------------------------------------------------------------------------
*/

Route::get('/', [TiendaController::class, 'index'])
    ->name('tienda.index');

Route::get('/tienda', [TiendaController::class, 'index']);

Route::get('/tienda/categorias', [TiendaController::class, 'categorias'])
    ->name('tienda.categorias');

Route::get('/tienda/categoria/{categoria}', [TiendaController::class, 'categoriaPartes'])
    ->name('tienda.categoria.partes');

Route::get('/tienda/parte/{parte}', [TiendaController::class, 'mostrarParte'])
    ->name('tienda.parte.show');


/*
|--------------------------------------------------------------------------
| Dashboard (SOLO ADMIN)
|--------------------------------------------------------------------------
|
| Un usuario normal ni debería llegar aquí, está protegido por el middleware
| 'admin' además de auth/verified/twofactor.
|
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'admin', 'twofactor'])
  ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Rutas autenticadas generales (cualquier usuario logueado)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2FA - configuración inicial
    Route::get('/2fa/setup', [TwoFactorController::class, 'showSetupForm'])
        ->name('twofactor.setup');

    Route::post('/2fa/setup', [TwoFactorController::class, 'enable'])
        ->name('twofactor.enable');

    // 2FA - verificación después de login
    Route::get('/2fa/verify', [TwoFactorController::class, 'showVerifyForm'])
        ->name('twofactor.verify');

    Route::post('/2fa/verify', [TwoFactorController::class, 'verify'])
        ->name('twofactor.verify.post');

    // 2FA - desactivar
    Route::post('/2fa/disable', [TwoFactorController::class, 'disable'])
        ->name('twofactor.disable');

    /*
    |--------------------------------------------------------------------------
    | Carrito de compras (solo usuarios autenticados)
    |--------------------------------------------------------------------------
    */

    Route::get('/carrito', [CarritoController::class, 'index'])
        ->name('carrito.index');

    Route::post('/carrito/agregar/{parte}', [CarritoController::class, 'agregar'])
        ->name('carrito.agregar');

    Route::post('/carrito/actualizar/{parte}', [CarritoController::class, 'actualizar'])
        ->name('carrito.actualizar');

    Route::post('/carrito/eliminar/{parte}', [CarritoController::class, 'eliminar'])
        ->name('carrito.eliminar');

    Route::post('/carrito/vaciar', [CarritoController::class, 'vaciar'])
        ->name('carrito.vaciar');

    Route::get('/carrito/resumen', [CarritoController::class, 'resumen'])
        ->name('carrito.resumen');

    Route::post('/carrito/confirmar', [CarritoController::class, 'confirmarCompra'])
        ->name('carrito.confirmar');

    Route::get('/carrito/factura/{venta}', function (Venta $venta) {
        $venta->load(['detalles.parte', 'usuario', 'cliente']);

        // Calculamos subtotal a partir de los detalles
        $subtotal = 0;
        foreach ($venta->detalles as $detalle) {
            // Si tu tabla tiene una columna "subtotal", úsala;
            // si no, calculamos precio_unitario * cantidad
            $linea = $detalle->subtotal ?? ($detalle->precio_unitario * $detalle->cantidad);
            $subtotal += $linea;
        }

        $itbms = round($subtotal * 0.07, 2);

        return view('carrito.factura', compact('venta', 'subtotal', 'itbms'));
    })->name('carrito.factura');

});


/*
|--------------------------------------------------------------------------
| Rutas solo ADMIN (auth + admin + twofactor)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin', 'twofactor'])->group(function () {

    // Consulta interna de inventario
    Route::get('/inventario/partes', [InventarioPublicoController::class, 'indexPartes'])
        ->name('inventario.partes.index');

    Route::get('/inventario/autos', [InventarioPublicoController::class, 'indexAutos'])
        ->name('inventario.autos.index');

    // Grupo /admin
    Route::prefix('admin')->name('admin.')->group(function () {

        // EXPORTAR PARTES A EXCEL
        Route::get('/partes/exportar/excel', [ParteController::class, 'exportarExcel'])
            ->name('partes.export.excel');

        // USUARIOS
        Route::get('/usuarios', [UsuarioController::class, 'index'])
            ->name('usuarios.index');

        Route::post('/usuarios/{id}/activar', [UsuarioController::class, 'activar'])
            ->name('usuarios.activar');

        Route::post('/usuarios/{id}/desactivar', [UsuarioController::class, 'desactivar'])
            ->name('usuarios.desactivar');

        // PARTES
        Route::get('/partes', [ParteController::class, 'index'])
            ->name('partes.index');

        Route::get('/partes/crear', [ParteController::class, 'create'])
            ->name('partes.create');

        Route::post('/partes', [ParteController::class, 'store'])
            ->name('partes.store');

        Route::get('/partes/{id}/editar', [ParteController::class, 'edit'])
            ->name('partes.edit');

        Route::put('/partes/{id}', [ParteController::class, 'update'])
            ->name('partes.update');

        Route::post('/partes/{id}/activar', [ParteController::class, 'activar'])
            ->name('partes.activar');

        Route::post('/partes/{id}/desactivar', [ParteController::class, 'desactivar'])
            ->name('partes.desactivar');

        // CATEGORÍAS
        Route::get('/categorias', [CategoriaController::class, 'index'])
            ->name('categorias.index');

        Route::get('/categorias/crear', [CategoriaController::class, 'create'])
            ->name('categorias.create');

        Route::post('/categorias', [CategoriaController::class, 'store'])
            ->name('categorias.store');

        Route::get('/categorias/{id}/editar', [CategoriaController::class, 'edit'])
            ->name('categorias.edit');

        Route::put('/categorias/{id}', [CategoriaController::class, 'update'])
            ->name('categorias.update');

        Route::post('/categorias/{id}/activar', [CategoriaController::class, 'activar'])
            ->name('categorias.activar');

        Route::post('/categorias/{id}/desactivar', [CategoriaController::class, 'desactivar'])
            ->name('categorias.desactivar');

        // AUTOS
        Route::get('/autos', [AutoController::class, 'index'])
            ->name('autos.index');

        Route::get('/autos/crear', [AutoController::class, 'create'])
            ->name('autos.create');

        Route::post('/autos', [AutoController::class, 'store'])
            ->name('autos.store');

        Route::get('/autos/{id}/editar', [AutoController::class, 'edit'])
            ->name('autos.edit');

        Route::put('/autos/{id}', [AutoController::class, 'update'])
            ->name('autos.update');

        // VENTAS
        Route::get('/ventas', [VentaController::class, 'index'])
            ->name('ventas.index');

        Route::get('/ventas/crear', [VentaController::class, 'create'])
            ->name('ventas.create');

        Route::post('/ventas', [VentaController::class, 'store'])
            ->name('ventas.store');

        Route::get('/ventas/{id}', [VentaController::class, 'show'])
            ->name('ventas.show');

        // CLIENTES
        Route::get('/clientes', [ClienteController::class, 'index'])
            ->name('clientes.index');

        Route::get('/clientes/crear', [ClienteController::class, 'create'])
            ->name('clientes.create');

        Route::post('/clientes', [ClienteController::class, 'store'])
            ->name('clientes.store');

        Route::get('/clientes/{id}/editar', [ClienteController::class, 'edit'])
            ->name('clientes.edit');

        Route::put('/clientes/{id}', [ClienteController::class, 'update'])
            ->name('clientes.update');

    });

    Route::get('/admin/sb2', function () {
            return view('admin.sb2');
        })->name('admin.sb2');
    
});


/*
|--------------------------------------------------------------------------
| Rutas de autenticación (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';


