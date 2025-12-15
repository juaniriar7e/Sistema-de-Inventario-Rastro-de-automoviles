<?php

namespace App\Domain\Infrastructure\Persistence\Eloquent;

use App\Domain\Inventario\Categoria as CategoriaDomain;
use App\Domain\Inventario\CategoriaRepositoryInterface;
use App\Models\Categoria as CategoriaModel;

class EloquentCategoriaRepository implements CategoriaRepositoryInterface
{
    public function listarTodas(): array
    {
        $models = CategoriaModel::orderBy('nombre')->get();

        return $models
            ->map(fn (CategoriaModel $m) => $this->mapToDomain($m))
            ->toArray();
    }

    public function listarActivas(): array
    {
        $models = CategoriaModel::where('is_active', true)
            ->orderBy('nombre')
            ->get();

        return $models
            ->map(fn (CategoriaModel $m) => $this->mapToDomain($m))
            ->toArray();
    }

    public function buscarPorId(int $id): ?CategoriaDomain
    {
        $model = CategoriaModel::find($id);

        if (!$model) {
            return null;
        }

        return $this->mapToDomain($model);
    }

    public function crear(CategoriaDomain $categoria): CategoriaDomain
    {
        $model = new CategoriaModel();
        $this->fillModelFromDomain($model, $categoria);
        $model->save();

        return new CategoriaDomain(
            id: $model->id,
            nombre: $categoria->getNombre(),
            descripcion: $categoria->getDescripcion(),
            activo: $categoria->isActivo(),
        );
    }

    public function guardar(CategoriaDomain $categoria): void
    {
        $model = CategoriaModel::find($categoria->getId());

        if (!$model) {
            $model = new CategoriaModel();
            $model->id = $categoria->getId();
        }

        $this->fillModelFromDomain($model, $categoria);
        $model->save();
    }

    private function mapToDomain(CategoriaModel $model): CategoriaDomain
    {
        return new CategoriaDomain(
            id: $model->id,
            nombre: $model->nombre,
            descripcion: $model->descripcion,
            activo: (bool) $model->is_active
        );
    }

    private function fillModelFromDomain(CategoriaModel $model, CategoriaDomain $categoria): void
    {
        $model->nombre     = $categoria->getNombre();
        $model->descripcion = $categoria->getDescripcion();
        $model->is_active  = $categoria->isActivo();
    }
}
