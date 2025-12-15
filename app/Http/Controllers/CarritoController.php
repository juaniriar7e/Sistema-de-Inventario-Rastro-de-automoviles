<?php

namespace App\Http\Controllers;

use App\Models\Parte;
use App\Models\Venta;
use App\Models\VentaDetalle;
use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = session('carrito', []);

        $subtotal = 0;
        foreach ($carrito as $item) {
            $subtotal += $item['precio'] * $item['cantidad'];
        }

        $itbms = round($subtotal * 0.07, 2);
        $total = $subtotal + $itbms;

        return view('carrito.index', compact('carrito', 'subtotal', 'itbms', 'total'));
    }

    public function agregar(\Illuminate\Http\Request $request, Parte $parte)
    {
        $cantidad = (int) $request->input('cantidad', 1);
        if ($cantidad < 1) $cantidad = 1;

        $carrito = session('carrito', []);

        if (isset($carrito[$parte->id])) {
            $carrito[$parte->id]['cantidad'] += $cantidad;
        } else {
            $carrito[$parte->id] = [
                'id'       => $parte->id,
                'codigo'   => $parte->codigo,
                'nombre'   => $parte->nombre,
                'precio'   => $parte->precio,
                'cantidad' => $cantidad,
            ];
        }

        session(['carrito' => $carrito]);

        return redirect()->route('carrito.index')
            ->with('success', 'Parte agregada al carrito correctamente.');
    }

    public function actualizar(\Illuminate\Http\Request $request, Parte $parte)
    {
        $cantidad = (int) $request->input('cantidad', 1);

        $carrito = session('carrito', []);

        if (!isset($carrito[$parte->id])) {
            return redirect()->route('carrito.index')
                ->with('error', 'La parte no existe en el carrito.');
        }

        if ($cantidad <= 0) {
            unset($carrito[$parte->id]);
        } else {
            $carrito[$parte->id]['cantidad'] = $cantidad;
        }

        session(['carrito' => $carrito]);

        return redirect()->route('carrito.index')
            ->with('success', 'Carrito actualizado.');
    }

    public function eliminar(Parte $parte)
    {
        $carrito = session('carrito', []);

        if (isset($carrito[$parte->id])) {
            unset($carrito[$parte->id]);
            session(['carrito' => $carrito]);
        }

        return redirect()->route('carrito.index')
            ->with('success', 'Parte eliminada del carrito.');
    }

    public function vaciar()
    {
        session()->forget('carrito');

        return redirect()->route('carrito.index')
            ->with('success', 'Carrito vaciado.');
    }

    public function resumen()
    {
        $carrito = session('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('carrito.index')
                ->with('error', 'El carrito está vacío.');
        }

        $subtotal = 0;
        foreach ($carrito as $item) {
            $subtotal += $item['precio'] * $item['cantidad'];
        }

        $itbms = round($subtotal * 0.07, 2);
        $total = $subtotal + $itbms;

        return view('carrito.checkout', compact('carrito', 'subtotal', 'itbms', 'total'));
    }

    public function confirmarCompra()
    {
        $carrito = session('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('carrito.index')
                ->with('error', 'El carrito está vacío.');
        }

        try {
            DB::transaction(function () use ($carrito) {

                // 1) Validar stock con lock (evita compras simultáneas)
                foreach ($carrito as $item) {
                    $parte = Parte::lockForUpdate()->findOrFail($item['id']);
                    $cantidadSolicitada = (int) $item['cantidad'];

                    if ($cantidadSolicitada < 1) {
                        throw new \Exception("Cantidad inválida para {$parte->codigo}.");
                    }

                    if ((int) $parte->cantidad < $cantidadSolicitada) {
                        throw new \Exception("No hay existencias suficientes para {$parte->codigo} — {$parte->nombre}.");
                    }
                }

                // 2) Calcular totales
                $subtotal = 0;
                foreach ($carrito as $item) {
                    $subtotal += ((float)$item['precio']) * ((int)$item['cantidad']);
                }

                $itbms = round($subtotal * 0.07, 2);
                $total = $subtotal + $itbms;

                // 3) Registrar / asociar cliente (SIN duplicar por email)
                $user = Auth::user();

                $cliente = Cliente::firstOrCreate(
                    ['email' => $user->email],
                    [
                        'nombre'    => $user->name,
                        'telefono'  => null,
                        'cedula'    => null,
                        'direccion' => null,
                    ]
                );

                // 4) Crear la venta
                $venta = Venta::create([
                    'user_id'  => $user->id,
                    'cliente_id'  => $cliente->id,
                    'fecha_venta' => now(),
                    'subtotal'    => $subtotal,
                    'itbms'       => $itbms,
                    'total'       => $total,
                    'estado'      => 'COMPLETADA',
                ]);

                // 5) Crear detalles + descontar inventario
                foreach ($carrito as $item) {
                    $parte = Parte::lockForUpdate()->findOrFail($item['id']);
                    $cantidadSolicitada = (int) $item['cantidad'];
                    $precioUnitario = (float) $item['precio'];
                    $sub = $precioUnitario * $cantidadSolicitada;

                    VentaDetalle::create([
                        'venta_id'        => $venta->id,
                        'parte_id'        => $parte->id,
                        'cantidad'        => $cantidadSolicitada,
                        'precio_unitario' => $precioUnitario,
                        'subtotal'        => $sub,
                    ]);

                    // ✅ Descontar stock
                    $parte->decrement('cantidad', $cantidadSolicitada);
                }

                // 6) Vaciar carrito
                session()->forget('carrito');
            });

            return redirect()->route('carrito.index')
                ->with('success', 'Compra confirmada. Venta registrada y stock actualizado.');

        } catch (\Throwable $e) {
            return redirect()->route('carrito.index')
                ->with('error', 'Ocurrió un error al confirmar la compra: ' . $e->getMessage());
        }
    }
}
