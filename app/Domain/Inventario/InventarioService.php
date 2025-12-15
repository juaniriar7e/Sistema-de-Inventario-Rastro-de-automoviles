<?php

namespace App\Domain\Inventario;

class InventarioService
{
    public function __construct(
        private ParteRepositoryInterface $parteRepo
    ) {}

    /**
     * @return Parte[]
     */
    public function listarPartes(): array
    {
        return $this->parteRepo->listarTodas();
    }

    public function obtenerParte(int $id): Parte
    {
        $parte = $this->parteRepo->buscarPorId($id);

        if (!$parte) {
            throw new \Exception('Parte no encontrada');
        }

        return $parte;
    }

    public function activarParte(int $id): void
    {
        $parte = $this->obtenerParte($id);
        $parte->activar();
        $this->parteRepo->guardar($parte);
    }

    public function desactivarParte(int $id): void
    {
        $parte = $this->obtenerParte($id);
        $parte->desactivar();
        $this->parteRepo->guardar($parte);
    }

    public function actualizarStock(int $id, int $nuevaCantidad): void
    {
        $parte = $this->obtenerParte($id);
        $parte->setCantidad($nuevaCantidad);
        $this->parteRepo->guardar($parte);
    }

    /**
     * Crea una nueva parte a partir de datos del formulario.
     */
    public function crearParteDesdeArray(array $data): Parte
    {
        $parte = new Parte(
            id: 0, // el ID real lo asignará la BD
            categoriaId: (int) $data['categoria_id'],
            autoId: !empty($data['auto_id']) ? (int) $data['auto_id'] : null,
            codigo: $data['codigo'],
            nombre: $data['nombre'],
            descripcion: $data['descripcion'] ?? null,
            costo: (float) ($data['costo'] ?? 0),
            precio: (float) ($data['precio'] ?? 0),
            cantidad: (int) ($data['cantidad'] ?? 0),
            thumbnailPath: $data['thumbnail_path'] ?? null,
            imagenPath: $data['imagen_path'] ?? null,
            fechaRegistro: $data['fecha_registro'] ?? null,
            activo: true,
        );

        return $this->parteRepo->crear($parte);
    }

    /**
     * Actualiza una parte existente con datos del formulario.
     */
    public function actualizarParteDesdeArray(int $id, array $data): void
    {
        $parte = $this->obtenerParte($id);

        if (isset($data['categoria_id'])) {
            $parte->setCategoriaId((int) $data['categoria_id']);
        }

        $parte->setAutoId(!empty($data['auto_id']) ? (int) $data['auto_id'] : null);

        if (isset($data['codigo'])) {
            $parte->setCodigo($data['codigo']);
        }

        if (isset($data['nombre'])) {
            $parte->setNombre($data['nombre']);
        }

        $parte->setDescripcion($data['descripcion'] ?? null);
        $parte->setCosto((float) ($data['costo'] ?? 0));
        $parte->setPrecio((float) ($data['precio'] ?? 0));
        $parte->setCantidad((int) ($data['cantidad'] ?? 0));

        if (array_key_exists('thumbnail_path', $data)) {
            $parte->setThumbnailPath($data['thumbnail_path']);
        }

        if (array_key_exists('imagen_path', $data)) {
            $parte->setImagenPath($data['imagen_path']);
        }

        if (isset($data['fecha_registro'])) {
            $parte->setFechaRegistro($data['fecha_registro']);
        }

        $this->parteRepo->guardar($parte);
    }
}

