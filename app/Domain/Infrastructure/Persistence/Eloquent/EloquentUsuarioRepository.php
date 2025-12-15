<?php

namespace App\Domain\Infrastructure\Persistence\Eloquent;

use App\Domain\Usuarios\Usuario;
use App\Domain\Usuarios\UsuarioRepositoryInterface;
use App\Models\User;

class EloquentUsuarioRepository implements UsuarioRepositoryInterface
{
    public function buscarPorId(int $id): ?Usuario
    {
        $model = User::find($id);

        if (!$model) {
            return null;
        }

        return $this->mapToDomain($model);
    }

    public function buscarPorEmail(string $email): ?Usuario
    {
        $model = User::where('email', $email)->first();

        if (!$model) {
            return null;
        }

        return $this->mapToDomain($model);
    }

    public function guardar(Usuario $usuario): void
    {
        $model = User::find($usuario->getId());

        if (!$model) {
            // normalmente no deberíamos crear aquí, pero lo dejo por si acaso
            $model = new User();
            $model->id = $usuario->getId();
        }

        $model->name       = $usuario->getNombre();
        $model->email      = $usuario->getEmail();
        $model->role       = $usuario->getRole();
        $model->is_active  = $usuario->isActivo();
        $model->secret_2fa = $usuario->getSecret2FA();

        $model->save();
    }

    public function listarTodos(): array
    {
        $models = User::orderBy('id', 'asc')->get();

        return $models
            ->map(fn (User $m) => $this->mapToDomain($m))
            ->toArray();
    }

    private function mapToDomain(User $model): Usuario
    {
        return new Usuario(
            id:        $model->id,
            nombre:    $model->name,
            email:     $model->email,
            role:      $model->role,
            activo:    (bool) $model->is_active,
            secret2FA: $model->secret_2fa
        );
    }
}
