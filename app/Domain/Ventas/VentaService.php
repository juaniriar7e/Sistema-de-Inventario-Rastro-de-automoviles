<?php

namespace App\Domain\Ventas;

use App\Models\Parte;
use Illuminate\Support\Facades\Auth;
use Exception;

class VentaService
{
    public function __construct(
        private VentaRepositoryInterface $ventaRepo
    ) {}

    /**
     * Crea una nueva venta a partir de los datos del formulario.
     *
     * @param int|null $clienteId
     * @param array $detallesData arreglo de items:
     *  [
     *      ['parte_id' => 1, 'cantidad' => 2, 'precio_unitario' => 10],
     *      ...
     *  ]
     * @throws Exception
     */
    public function crearVenta(?int $clienteId, array $detallesData): Venta
    {
        $user = Auth::user();

        if (!$user) {
            throw new Exception('Usuario no autenticado');
        }

        $detalles = [];

        foreach ($detallesData as $item) {
            if (empty($item['parte_id']) || empty($item['cantidad'])) {
                // fila vacía, se ignora
                continue;
            }

            $parteId  = (int) $item['parte_id'];
            $cantidad = (int) $item['cantidad'];

            if ($cantidad <= 0) {
                continue;
            }

            // Si el precio viene vacío, usamos el precio actual de la parte
            $precio = null;

            if (isset($item['precio_unitario']) && $item['precio_unitario'] !== '') {
                $precio = (float) $item['precio_unitario'];
            } else {
                $parte = Parte::find($parteId);

                if (!$parte) {
                    throw new Exception("La parte con ID {$parteId} no existe.");
                }

                $precio = (float) $parte->precio;
            }

            $detalles[] = new VentaDetalle(
                parteId: $parteId,
                cantidad: $cantidad,
                precioUnitario: $precio
            );
        }

        if (empty($detalles)) {
            throw new Exception('Debe agregar al menos una parte a la venta.');
        }

        $venta = new Venta(
            id: 0,
            clienteId: $clienteId,
            userId: $user->id,
            fechaVenta: now()->format('Y-m-d H:i:s'),
            estado: 'COMPLETADA',
            detalles: $detalles,
        );

        return $this->ventaRepo->guardarVenta($venta);
    }
}
