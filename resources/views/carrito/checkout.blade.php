{{-- resources/views/carrito/checkout.blade.php --}}
@extends('layouts.tienda')

@section('title', 'Resumen de compra | ' . config('app.name'))

@section('content')
<section class="py-8">
    <div class="max-w-4xl mx-auto px-4 lg:px-8">
        <div class="bg-white shadow-sm rounded-xl p-6 text-sm text-gray-900">

            <h1 class="text-xl font-semibold mb-4">
                Resumen de compra (Factura)
            </h1>

            <p class="text-xs text-gray-600 mb-4 text-justify">
                Este resumen muestra la descripción de la compra, las partes seleccionadas, la fecha de emisión
                (tomando como referencia la fecha actual del sistema) y el cálculo del impuesto ITBMS del 7%.
                Al confirmar la compra, el sistema registrará la venta, aplicará el 7% de ITBMS y actualizará
                las existencias en el inventario.
            </p>

            @if(empty($carrito))
                <p class="text-sm text-gray-600">
                    El carrito está vacío. Regresa a la tienda para agregar partes antes de generar una factura.
                </p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs border-t border-b border-gray-200">
                        <thead class="bg-gray-50 text-gray-600">
                            <tr>
                                <th class="px-3 py-2 text-left">Código</th>
                                <th class="px-3 py-2 text-left">Descripción</th>
                                <th class="px-3 py-2 text-right">Cantidad</th>
                                <th class="px-3 py-2 text-right">Precio</th>
                                <th class="px-3 py-2 text-right">Total línea</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($carrito as $item)
                                <tr class="border-t border-gray-100">
                                    <td class="px-3 py-2 align-middle font-mono">
                                        {{ $item['codigo'] }}
                                    </td>
                                    <td class="px-3 py-2 align-middle">
                                        {{ $item['nombre'] }}
                                    </td>
                                    <td class="px-3 py-2 align-middle text-right">
                                        {{ $item['cantidad'] }}
                                    </td>
                                    <td class="px-3 py-2 align-middle text-right">
                                        ${{ number_format($item['precio'], 2) }}
                                    </td>
                                    <td class="px-3 py-2 align-middle text-right">
                                        ${{ number_format($item['precio'] * $item['cantidad'], 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="text-xs text-gray-600">
                        Fecha de emisión: {{ now()->format('d/m/Y H:i') }}<br>
                        * Una vez confirmada la compra, esta información se guardará como una venta en el sistema.
                    </div>

                    <div class="text-sm text-right">
                        <div>Subtotal: <span class="font-semibold">${{ number_format($subtotal, 2) }}</span></div>
                        <div>ITBMS (7%): <span class="font-semibold">${{ number_format($itbms, 2) }}</span></div>
                        <div class="mt-1 text-base font-semibold">
                            Total a pagar: ${{ number_format($total, 2) }}
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-between gap-3">
                    <a href="{{ route('carrito.index') }}"
                       class="text-xs px-4 py-2 rounded border border-gray-400 text-gray-800 hover:bg-gray-50">
                        Volver al carrito
                    </a>

                    {{-- Botón real para confirmar la compra --}}
                    <form action="{{ route('carrito.confirmar') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="text-xs px-4 py-2 rounded bg-gray-900 text-white hover:bg-gray-700">
                            Confirmar compra
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection


