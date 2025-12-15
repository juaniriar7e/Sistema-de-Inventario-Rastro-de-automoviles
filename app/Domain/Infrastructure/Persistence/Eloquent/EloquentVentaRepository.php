<?php

namespace App\Domain\Infrastructure\Persistence\Eloquent;

use App\Domain\Ventas\Venta;
use App\Domain\Ventas\VentaDetalle as VentaDetalleDomain;
use App\Domain\Ventas\VentaRepositoryInterface;
use App\Models\Venta as VentaModel;
use App\Models\VentaDetalle as VentaDetalleModel;
use App\Models\Parte as ParteModel;
use Illuminate\Support\Facades\DB;
use Exception;

class EloquentVentaRepository implements VentaRepositoryInterface
{
    public function guardarVenta(Venta $venta): Venta
    {
        return DB::transaction(function () use ($venta) {

            // Si id = 0, nueva venta
            $ventaModel = $venta->getId() > 0
                ? VentaModel::find($venta->getId())
                : new VentaModel();

            $ventaModel->cliente_id  = $venta->getClienteId();
            $ventaModel->user_id     = $venta->getUserId();
            $ventaModel->fecha_venta = $venta->getFechaVenta();
            $ventaModel->estado      = $venta->getEstado();
            $ventaModel->total       = $venta->getTotal();
            $ventaModel->save();

            // Si es edición, borramos detalles anteriores
            if ($venta->getId() > 0) {
                $ventaModel->detalles()->delete();
            }

            foreach ($venta->getDetalles() as $detalle) {
                /** @var VentaDetalleDomain $detalle */

                // 1) Crear detalle de venta
                $detalleModel = new VentaDetalleModel();
                $detalleModel->venta_id        = $ventaModel->id;
                $detalleModel->parte_id        = $detalle->getParteId();
                $detalleModel->cantidad        = $detalle->getCantidad();
                $detalleModel->precio_unitario = $detalle->getPrecioUnitario();
                $detalleModel->subtotal        = $detalle->getSubtotal();
                $detalleModel->save();

                // 2) Actualizar stock de la parte
                $parte = ParteModel::find($detalle->getParteId());

                if (!$parte) {
                    throw new Exception("La parte con ID {$detalle->getParteId()} no existe.");
                }

                if ($parte->cantidad < $detalle->getCantidad()) {
                    throw new Exception("No hay stock suficiente para la parte {$parte->codigo}.");
                }

                $parte->cantidad = $parte->cantidad - $detalle->getCantidad();
                $parte->save();
            }

            // Devolvemos una nueva instancia de dominio con el ID real
            return new Venta(
                id: $ventaModel->id,
                clienteId: $venta->getClienteId(),
                userId: $venta->getUserId(),
                fechaVenta: $venta->getFechaVenta(),
                estado: $venta->getEstado(),
                detalles: $venta->getDetalles(),
            );
        });
    }
}

