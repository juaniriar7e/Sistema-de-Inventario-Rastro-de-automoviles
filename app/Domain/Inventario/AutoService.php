<?php

namespace App\Domain\Inventario;

class AutoService
{
    public function __construct(
        private AutoRepositoryInterface $autoRepo
    ) {}

    /**
     * @return Auto[]
     */
    public function listarAutos(): array
    {
        return $this->autoRepo->listarTodos();
    }

    public function obtenerAuto(int $id): Auto
    {
        $auto = $this->autoRepo->buscarPorId($id);

        if (!$auto) {
            throw new \Exception('Auto no encontrado');
        }

        return $auto;
    }

    public function crearAutoDesdeArray(array $data): Auto
    {
        $auto = new Auto(
            id: 0,
            marca: $data['marca'],
            modelo: $data['modelo'],
            anio: !empty($data['anio']) ? (int) $data['anio'] : null,
            version: $data['version'] ?? null,
            comentarios: $data['comentarios'] ?? null,
        );

        return $this->autoRepo->crear($auto);
    }

    public function actualizarAutoDesdeArray(int $id, array $data): void
    {
        $auto = $this->obtenerAuto($id);

        $auto->setMarca($data['marca']);
        $auto->setModelo($data['modelo']);
        $auto->setAnio(!empty($data['anio']) ? (int) $data['anio'] : null);
        $auto->setVersion($data['version'] ?? null);
        $auto->setComentarios($data['comentarios'] ?? null);

        $this->autoRepo->guardar($auto);
    }
}
