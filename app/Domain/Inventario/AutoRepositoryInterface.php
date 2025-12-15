<?php

namespace App\Domain\Inventario;

interface AutoRepositoryInterface
{
    /**
     * @return Auto[]
     */
    public function listarTodos(): array;

    public function buscarPorId(int $id): ?Auto;

    public function crear(Auto $auto): Auto;

    public function guardar(Auto $auto): void;
}
