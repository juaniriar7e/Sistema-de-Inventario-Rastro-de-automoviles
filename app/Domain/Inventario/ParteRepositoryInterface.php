<?php

namespace App\Domain\Inventario;

interface ParteRepositoryInterface
{
    /**
     * @return Parte[]
     */
    public function listarTodas(): array;

    public function buscarPorId(int $id): ?Parte;

    public function guardar(Parte $parte): void;

    public function crear(Parte $parte): Parte;
}
