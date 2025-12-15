{{-- resources/views/carrito/factura.blade.php --}}
@extends('layouts.tienda')

@section('title', 'Factura de venta #' . $venta->id . ' | ' . config('app.name'))

@section('content')
<section class="py-8">
    <div class="max-w-4xl mx-auto px-4 lg:px-8">
        <div class="bg-white shadow-sm rounded-xl p-6 text-sm text-gray-900">

            <div class="flex justify-between items-start mb-4">
                <div>
                    <h1 class="text-xl font-semibold">
                        Factura de venta #{{ $venta->id }}
                    </h1>
                    <p class="text-xs text-gray-600">
                        Fecha de emisión:
                        {{ optional($venta->fecha_venta)->format('d/m/Y H:i') }}
                    </p>
                </div>

                <div class="text-right text-xs text-gray-600">
                    <div>{{ config('app.name', 'Inventario Rastro') }}</div>
                    <div>Sistema de Inventario de Rastro</div>
                </div>
            </div>

            <div class="mb-4 text-xs text-gray-700 space-y-1">
                <p>
                    <span class="font-semibold">Cliente:</span>
                    {{ optional($venta->cliente)->nombre ?? 'Cliente no vinculado' }}
                </p>
                <p>
                    <span class="font-semibold">Atendido por:</span>
                    {{ optional($venta->usuario)->name ?? 'Usuario no registrado' }}
                </p>
            </div>

            <div class="overflow-x-auto mt-4">
                <table class="min-w-full text-xs border-t border-b border-gray-200">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-3 py-2 text-left">Código</th>
                            <th class="px-3 py-2 text-left">Descripción</th>
                            <th class="px-3 py-2 text-right">Cant.</th>
                            <th class="px-3 py-2 text-right">P. Unitario</th>
                            <th class="px-3 py-2 text-right">Total línea</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($venta->detalles as $detalle)
                            <tr class="border-t border-gray-100">
                                <td class="px-3 py-2 align-middle font-mono">
                                    {{ $detalle->parte->codigo ?? '' }}
                                </td>
                                <td class="px-3 py-2 align-middle">
                                    {{ $detalle->parte->nombre ?? '' }}
                                </td>
                                <td class="px-3 py-2 align-middle text-right">
                                    {{ $detalle->cantidad }}
                                </td>
                                <td class="px-3 py-2 align-middle text-right">
                                    ${{ number_format($detalle->precio_unitario, 2) }}
                                </td>
                                <td class="px-3 py-2 align-middle text-right">
                                    ${{ number_format($detalle->subtotal ?? $detalle->precio_unitario * $detalle->cantidad, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="text-xs text-gray-600">
                    Gracias por su compra.<br>
                    Esta factura incluye el ITBMS del 7% aplicado al subtotal.
                </div>

                <div class="text-sm text-right">
                    <div>Subtotal:
                        <span class="font-semibold">${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div>ITBMS (7%):
                        <span class="font-semibold">${{ number_format($itbms, 2) }}</span>
                    </div>
                    <div class="mt-1 text-base font-semibold">
                        Total:
                        ${{ number_format($venta->total, 2) }}
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-between gap-3">
                <a href="{{ route('tienda.index') }}"
                   class="text-xs px-4 py-2 rounded border border-gray-400 text-gray-800 hover:bg-gray-50">
                    Volver a la tienda
                </a>

                <button type="button"
                        onclick="window.print()"
                        class="text-xs px-4 py-2 rounded bg-gray-900 text-white hover:bg-gray-700">
                    Imprimir / Guardar PDF
                </button>
            </div>

        </div>
    </div>
</section>
@endsection


