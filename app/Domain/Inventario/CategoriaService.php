<?php

namespace App\Domain\Inventario;

class CategoriaService
{
    public function __construct(
        private CategoriaRepositoryInterface $categoriaRepo
    ) {}

    /**
     * @return Categoria[]
     */
    public function listarCategorias(): array
    {
        return $this->categoriaRepo->listarTodas();
    }

    /**
     * @return Categoria[]
     */
    public function listarCategoriasActivas(): array
    {
        return $this->categoriaRepo->listarActivas();
    }

    public function obtenerCategoria(int $id): Categoria
    {
        $categoria = $this->categoriaRepo->buscarPorId($id);

        if (!$categoria) {
            throw new \Exception('Categoría no encontrada');
        }

        return $categoria;
    }

    public function crearCategoria(string $nombre, ?string $descripcion = null): Categoria
    {
        $categoria = new Categoria(
            id: 0,
            nombre: $nombre,
            descripcion: $descripcion,
            activo: true
        );

        return $this->categoriaRepo->crear($categoria);
    }

    public function actualizarCategoria(int $id, string $nombre, ?string $descripcion = null): void
    {
        $categoria = $this->obtenerCategoria($id);
        $categoria->setNombre($nombre);
        $categoria->setDescripcion($descripcion);

        $this->categoriaRepo->guardar($categoria);
    }

    public function activarCategoria(int $id): void
    {
        $categoria = $this->obtenerCategoria($id);
        $categoria->activar();
        $this->categoriaRepo->guardar($categoria);
    }

    public function desactivarCategoria(int $id): void
    {
        $categoria = $this->obtenerCategoria($id);
        $categoria->desactivar();
        $this->categoriaRepo->guardar($categoria);
    }
}
