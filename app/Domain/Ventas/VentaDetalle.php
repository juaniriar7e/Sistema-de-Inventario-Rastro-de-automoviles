<?php

namespace App\Domain\Ventas;

class VentaDetalle
{
    public function __construct(
        private int $parteId,
        private int $cantidad,
        private float $precioUnitario,
    ) {}

    public function getParteId(): int
    {
        return $this->parteId;
    }

    public function getCantidad(): int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): void
    {
        $this->cantidad = $cantidad;
    }

    public function getPrecioUnitario(): float
    {
        return $this->precioUnitario;
    }

    public function setPrecioUnitario(float $precio): void
    {
        $this->precioUnitario = $precio;
    }

    public function getSubtotal(): float
    {
        return $this->cantidad * $this->precioUnitario;
    }
}

