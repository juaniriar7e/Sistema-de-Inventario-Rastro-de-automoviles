<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Domain\Usuarios\UsuarioRepositoryInterface;
use App\Domain\Infrastructure\Persistence\Eloquent\EloquentUsuarioRepository;
use App\Domain\Inventario\ParteRepositoryInterface;
use App\Domain\Infrastructure\Persistence\Eloquent\EloquentParteRepository;
use App\Domain\Inventario\CategoriaRepositoryInterface;
use App\Domain\Infrastructure\Persistence\Eloquent\EloquentCategoriaRepository;
use App\Domain\Inventario\AutoRepositoryInterface;
use App\Domain\Infrastructure\Persistence\Eloquent\EloquentAutoRepository;
use App\Domain\Ventas\VentaRepositoryInterface;
use App\Domain\Infrastructure\Persistence\Eloquent\EloquentVentaRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Binding para usuarios
        $this->app->bind(
            \App\Domain\Usuarios\UsuarioRepositoryInterface::class,
            \App\Domain\Infrastructure\Persistence\Eloquent\EloquentUsuarioRepository::class
        );

        // Binding para partes de inventario
        $this->app->bind(
            ParteRepositoryInterface::class,
            EloquentParteRepository::class
        );

        // Binding para categorías de inventario
        $this->app->bind(
            CategoriaRepositoryInterface::class,
            EloquentCategoriaRepository::class
        );
        
        // Autos
        $this->app->bind(
            AutoRepositoryInterface::class,
            EloquentAutoRepository::class
        );
        // Ventas
        $this->app->bind(
            VentaRepositoryInterface::class,
            EloquentVentaRepository::class
        );

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       Schema::defaultStringLength(191); //
    }
}
