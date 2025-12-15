{{-- resources/views/carrito/index.blade.php --}}
@extends('layouts.tienda')

@section('title', 'Carrito de compras | ' . config('app.name'))

@section('content')
<section class="py-8">
    <div class="max-w-5xl mx-auto px-4 lg:px-8">

        @if(session('success'))
            <div class="mb-4 text-xs px-4 py-3 rounded bg-green-100 text-green-800 border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 text-xs px-4 py-3 rounded bg-red-100 text-red-800 border border-red-200">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white shadow-sm rounded-xl p-6 text-sm text-gray-900">
            <h1 class="text-xl font-semibold mb-4">
                Carrito de compras
            </h1>

            @if(empty($carrito))
                <p class="text-sm text-gray-600">
                    Tu carrito está vacío. Navega por la tienda y agrega partes para realizar una compra virtual.
                </p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs border-t border-b border-gray-200">
                        <thead class="bg-gray-50 text-gray-600">
                            <tr>
                                <th class="px-3 py-2 text-left">Código</th>
                                <th class="px-3 py-2 text-left">Nombre</th>
                                <th class="px-3 py-2 text-right">Precio</th>
                                <th class="px-3 py-2 text-center">Cantidad</th>
                                <th class="px-3 py-2 text-right">Subtotal</th>
                                <th class="px-3 py-2 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($carrito as $item)
                                <tr class="border-t border-gray-100">
                                    <td class="px-3 py-2 align-middle">
                                        <span class="font-mono">{{ $item['codigo'] }}</span>
                                    </td>
                                    <td class="px-3 py-2 align-middle">
                                        {{ $item['nombre'] }}
                                    </td>
                                    <td class="px-3 py-2 align-middle text-right">
                                        ${{ number_format($item['precio'], 2) }}
                                    </td>
                                    <td class="px-3 py-2 align-middle text-center">
                                        <form method="POST" action="{{ route('carrito.actualizar', $item['id']) }}" class="inline-flex items-center justify-center">
                                            @csrf
                                            <input type="number" name="cantidad" min="1" value="{{ $item['cantidad'] }}"
                                                   class="w-16 text-xs border-gray-300 rounded-md shadow-sm focus:ring-gray-500 focus:border-gray-500">
                                            <button type="submit"
                                                    class="ml-2 text-[11px] px-2 py-1 rounded border border-gray-300 hover:bg-gray-50">
                                                Actualizar
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-3 py-2 align-middle text-right">
                                        ${{ number_format($item['precio'] * $item['cantidad'], 2) }}
                                    </td>
                                    <td class="px-3 py-2 align-middle text-center">
                                        <form method="POST" action="{{ route('carrito.eliminar', $item['id']) }}">
                                            @csrf
                                            <button type="submit"
                                                    class="text-[11px] px-2 py-1 rounded border border-red-300 text-red-700 hover:bg-red-50">
                                                Quitar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="text-xs text-gray-600">
                        Puedes actualizar las cantidades o quitar partes del carrito antes de continuar.
                    </div>

                    <div class="text-sm text-right">
                        <div>Subtotal: <span class="font-semibold">${{ number_format($subtotal, 2) }}</span></div>
                        <div>ITBMS (7%): <span class="font-semibold">${{ number_format($itbms, 2) }}</span></div>
                        <div class="mt-1 text-base font-semibold">
                            Total: ${{ number_format($total, 2) }}
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap justify-between gap-3">
                    <form method="POST" action="{{ route('carrito.vaciar') }}">
                        @csrf
                        <button type="submit"
                                class="text-xs px-4 py-2 rounded border border-gray-400 text-gray-800 hover:bg-gray-50">
                            Vaciar carrito
                        </button>
                    </form>

                    <a href="{{ route('carrito.resumen') }}"
                       class="text-xs px-4 py-2 rounded bg-gray-900 text-white hover:bg-gray-700">
                        Ver resumen de factura
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
