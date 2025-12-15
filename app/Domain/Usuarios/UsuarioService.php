<?php

namespace App\Domain\Usuarios;

class UsuarioService
{
    public function __construct(
        private UsuarioRepositoryInterface $usuarioRepo
    ) {}

    /**
     * Lista todos los usuarios.
     *
     * @return Usuario[]
     */
    public function listarUsuarios(): array
    {
        return $this->usuarioRepo->listarTodos();
    }

    public function activarUsuario(int $id): void
    {
        $usuario = $this->usuarioRepo->buscarPorId($id);

        if (!$usuario) {
            throw new \Exception('Usuario no encontrado');
        }

        $usuario->activar();
        $this->usuarioRepo->guardar($usuario);
    }

    public function desactivarUsuario(int $id): void
    {
        $usuario = $this->usuarioRepo->buscarPorId($id);

        if (!$usuario) {
            throw new \Exception('Usuario no encontrado');
        }

        $usuario->desactivar();
        $this->usuarioRepo->guardar($usuario);
    }
}
