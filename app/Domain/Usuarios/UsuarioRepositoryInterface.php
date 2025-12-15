<?php

namespace App\Domain\Usuarios;

interface UsuarioRepositoryInterface
{
    public function buscarPorId(int $id): ?Usuario;

    public function buscarPorEmail(string $email): ?Usuario;

    /**
     * Guarda los cambios de un usuario en la base de datos.
     */
    public function guardar(Usuario $usuario): void;

    /**
     * Devuelve todos los usuarios del sistema.
     *
     * @return Usuario[]
     */
    public function listarTodos(): array;
}
