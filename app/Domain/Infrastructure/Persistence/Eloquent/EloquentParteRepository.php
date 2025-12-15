<?php

namespace App\Domain\Infrastructure\Persistence\Eloquent;

use App\Domain\Inventario\Parte;
use App\Domain\Inventario\ParteRepositoryInterface;
use App\Models\Parte as ParteModel;

class EloquentParteRepository implements ParteRepositoryInterface
{
    public function listarTodas(): array
    {
        $models = ParteModel::with(['categoria', 'auto'])
            ->orderBy('id', 'asc')
            ->get();

        return $models
            ->map(fn (ParteModel $m) => $this->mapToDomain($m))
            ->toArray();
    }

    public function buscarPorId(int $id): ?Parte
    {
        $model = ParteModel::find($id);

        if (!$model) {
            return null;
        }

        return $this->mapToDomain($model);
    }

    public function guardar(Parte $parte): void
    {
        $model = ParteModel::find($parte->getId());

        if (!$model) {
            // no debería pasar para actualizar, pero lo contemplamos
            $model = new ParteModel();
        }

        $this->fillModelFromDomain($model, $parte);
        $model->save();
    }

    public function crear(Parte $parte): Parte
    {
        $model = new ParteModel();
        $this->fillModelFromDomain($model, $parte);
        $model->save();

        // Actualizamos el ID en la instancia de dominio
        return new Parte(
            id: $model->id,
            categoriaId: $parte->getCategoriaId(),
            autoId: $parte->getAutoId(),
            codigo: $parte->getCodigo(),
            nombre: $parte->getNombre(),
            descripcion: $parte->getDescripcion(),
            costo: $parte->getCosto(),
            precio: $parte->getPrecio(),
            cantidad: $parte->getCantidad(),
            thumbnailPath: $parte->getThumbnailPath(),
            imagenPath: $parte->getImagenPath(),
            fechaRegistro: $parte->getFechaRegistro(),
            activo: $parte->isActivo(),
        );
    }

    private function mapToDomain(ParteModel $model): Parte
    {
        return new Parte(
            id: $model->id,
            categoriaId: $model->categoria_id,
            autoId: $model->auto_id,
            codigo: $model->codigo,
            nombre: $model->nombre,
            descripcion: $model->descripcion,
            costo: (float) $model->costo,
            precio: (float) $model->precio,
            cantidad: (int) $model->cantidad,
            thumbnailPath: $model->thumbnail_path,
            imagenPath: $model->imagen_path,
            fechaRegistro: $model->fecha_registro?->format('Y-m-d'),
            activo: (bool) $model->is_active,
        );
    }

    private function fillModelFromDomain(ParteModel $model, Parte $parte): void
    {
        $model->categoria_id   = $parte->getCategoriaId();
        $model->auto_id        = $parte->getAutoId();
        $model->codigo         = $parte->getCodigo();
        $model->nombre         = $parte->getNombre();
        $model->descripcion    = $parte->getDescripcion();
        $model->costo          = $parte->getCosto();
        $model->precio         = $parte->getPrecio();
        $model->cantidad       = $parte->getCantidad();
        $model->thumbnail_path = $parte->getThumbnailPath();
        $model->imagen_path    = $parte->getImagenPath();
        $model->fecha_registro = $parte->getFechaRegistro();
        $model->is_active      = $parte->isActivo();
    }
}
