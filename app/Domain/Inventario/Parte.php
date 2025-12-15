<?php

namespace App\Domain\Inventario;

class Parte
{
    public function __construct(
        private int $id,
        private int $categoriaId,
        private ?int $autoId,
        private string $codigo,
        private string $nombre,
        private ?string $descripcion,
        private float $costo,
        private float $precio,
        private int $cantidad,
        private ?string $thumbnailPath,
        private ?string $imagenPath,
        private ?string $fechaRegistro, // lo manejamos como string 'Y-m-d' por simplicidad
        private bool $activo = true,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getCategoriaId(): int
    {
        return $this->categoriaId;
    }

    public function setCategoriaId(int $categoriaId): void
    {
        $this->categoriaId = $categoriaId;
    }

    public function getAutoId(): ?int
    {
        return $this->autoId;
    }

    public function setAutoId(?int $autoId): void
    {
        $this->autoId = $autoId;
    }

    public function getCodigo(): string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): void
    {
        $this->codigo = $codigo;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function getCosto(): float
    {
        return $this->costo;
    }

    public function setCosto(float $costo): void
    {
        $this->costo = $costo;
    }

    public function getPrecio(): float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): void
    {
        $this->precio = $precio;
    }

    public function getCantidad(): int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): void
    {
        $this->cantidad = $cantidad;
    }

    public function incrementarCantidad(int $cantidad): void
    {
        $this->cantidad += $cantidad;
    }

    public function disminuirCantidad(int $cantidad): void
    {
        $this->cantidad = max(0, $this->cantidad - $cantidad);
    }

    public function getThumbnailPath(): ?string
    {
        return $this->thumbnailPath;
    }

    public function setThumbnailPath(?string $path): void
    {
        $this->thumbnailPath = $path;
    }

    public function getImagenPath(): ?string
    {
        return $this->imagenPath;
    }

    public function setImagenPath(?string $path): void
    {
        $this->imagenPath = $path;
    }

    public function getFechaRegistro(): ?string
    {
        return $this->fechaRegistro;
    }

    public function setFechaRegistro(?string $fecha): void
    {
        $this->fechaRegistro = $fecha;
    }

    public function isActivo(): bool
    {
        return $this->activo;
    }

    public function activar(): void
    {
        $this->activo = true;
    }

    public function desactivar(): void
    {
        $this->activo = false;
    }
}
