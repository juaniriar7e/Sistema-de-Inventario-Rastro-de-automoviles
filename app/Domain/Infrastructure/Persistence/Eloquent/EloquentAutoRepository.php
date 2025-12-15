<?php

namespace App\Domain\Infrastructure\Persistence\Eloquent;

use App\Domain\Inventario\Auto as AutoDomain;
use App\Domain\Inventario\AutoRepositoryInterface;
use App\Models\Auto as AutoModel;

class EloquentAutoRepository implements AutoRepositoryInterface
{
    public function listarTodos(): array
    {
        $models = AutoModel::orderBy('marca')
            ->orderBy('modelo')
            ->orderBy('anio', 'desc')
            ->get();

        return $models
            ->map(fn (AutoModel $m) => $this->mapToDomain($m))
            ->toArray();
    }

    public function buscarPorId(int $id): ?AutoDomain
    {
        $model = AutoModel::find($id);

        if (!$model) {
            return null;
        }

        return $this->mapToDomain($model);
    }

    public function crear(AutoDomain $auto): AutoDomain
    {
        $model = new AutoModel();
        $this->fillModelFromDomain($model, $auto);
        $model->save();

        return new AutoDomain(
            id: $model->id,
            marca: $auto->getMarca(),
            modelo: $auto->getModelo(),
            anio: $auto->getAnio(),
            version: $auto->getVersion(),
            comentarios: $auto->getComentarios(),
        );
    }

    public function guardar(AutoDomain $auto): void
    {
        $model = AutoModel::find($auto->getId());

        if (!$model) {
            $model = new AutoModel();
            $model->id = $auto->getId();
        }

        $this->fillModelFromDomain($model, $auto);
        $model->save();
    }

    private function mapToDomain(AutoModel $model): AutoDomain
    {
        return new AutoDomain(
            id: $model->id,
            marca: $model->marca,
            modelo: $model->modelo,
            anio: $model->anio,
            version: $model->version,
            comentarios: $model->comentarios,
        );
    }

    private function fillModelFromDomain(AutoModel $model, AutoDomain $auto): void
    {
        $model->marca       = $auto->getMarca();
        $model->modelo      = $auto->getModelo();
        $model->anio        = $auto->getAnio();
        $model->version     = $auto->getVersion();
        $model->comentarios = $auto->getComentarios();
    }
}
