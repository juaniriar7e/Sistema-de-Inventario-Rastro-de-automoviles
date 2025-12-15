<?php

namespace App\Domain\Ventas;

interface VentaRepositoryInterface
{
    public function guardarVenta(Venta $venta): Venta;
}
