<?php

namespace App\Domain\Inventario;

interface CategoriaRepositoryInterface
{
    /**
     * @return Categoria[]
     */
    public function listarTodas(): array;

    /**
     * @return Categoria[]
     */
    public function listarActivas(): array;

    public function buscarPorId(int $id): ?Categoria;

    public function crear(Categoria $categoria): Categoria;

    public function guardar(Categoria $categoria): void;
}
