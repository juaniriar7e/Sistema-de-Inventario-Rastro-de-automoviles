<?php

namespace App\Domain\Ventas;

class Venta
{
    /**
     * @param VentaDetalle[] $detalles
     */
    public function __construct(
        private int $id,
        private ?int $clienteId,
        private int $userId,
        private string $fechaVenta, // 'Y-m-d H:i:s'
        private string $estado,
        private array $detalles = [],
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getClienteId(): ?int
    {
        return $this->clienteId;
    }

    public function setClienteId(?int $clienteId): void
    {
        $this->clienteId = $clienteId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getFechaVenta(): string
    {
        return $this->fechaVenta;
    }

    public function setFechaVenta(string $fecha): void
    {
        $this->fechaVenta = $fecha;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }

    /**
     * @return VentaDetalle[]
     */
    public function getDetalles(): array
    {
        return $this->detalles;
    }

    /**
     * @param VentaDetalle[] $detalles
     */
    public function setDetalles(array $detalles): void
    {
        $this->detalles = $detalles;
    }

    public function agregarDetalle(VentaDetalle $detalle): void
    {
        $this->detalles[] = $detalle;
    }

    public function getTotal(): float
    {
        return array_reduce(
            $this->detalles,
            fn (float $carry, VentaDetalle $d) => $carry + $d->getSubtotal(),
            0.0
        );
    }
}
