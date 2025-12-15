{{-- resources/views/tienda/categoria_partes.blade.php --}}
@extends('layouts.tienda')

@section('title', 'Partes de ' . $categoria->nombre . ' | Inventario Rastro')

@section('content')
    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 space-y-6">

            <div>
                <h1 class="text-2xl font-semibold text-gray-900">
                    Partes de la categoría: {{ $categoria->nombre }}
                </h1>
                @if(!empty($categoria->descripcion))
                    <p class="mt-1 text-sm text-gray-600">
                        {{ $categoria->descripcion }}
                    </p>
                @endif
                <div class="mt-4 flex flex-wrap gap-2">
                    <a href="{{ route('tienda.categorias') }}"
                    class="inline-flex items-center px-3 py-2 rounded-md border border-gray-300 text-sm text-gray-700 hover:bg-gray-50">
                        Volver a categorías
                    </a>

                    <a href="{{ route('tienda.index') }}"
                    class="inline-flex items-center px-3 py-2 rounded-md border border-gray-300 text-sm text-gray-700 hover:bg-gray-50">
                        Regresar a la tienda
                    </a>
                </div>
            </div>

            @if($partes->isEmpty())
                <p class="text-sm text-gray-600">
                    No hay partes registradas en esta categoría.
                </p>
            @else
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-4 py-2 text-left">Código</th>
                                <th class="px-4 py-2 text-left">Nombre</th>
                                <th class="px-4 py-2 text-left">Auto</th>
                                <th class="px-4 py-2 text-right">Precio</th>
                                <th class="px-4 py-2 text-center">Existencia</th>
                                <th class="px-4 py-2 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($partes as $parte)
                                <tr>
                                    <td class="px-4 py-2 text-gray-700">
                                        {{ $parte->codigo }}
                                    </td>
                                    <td class="px-4 py-2 text-gray-700">
                                        {{ $parte->nombre }}
                                    </td>
                                    <td class="px-4 py-2 text-gray-600">
                                        {{ optional($parte->auto)->modelo ?? '—' }}
                                    </td>
                                    <td class="px-4 py-2 text-right text-gray-700">
                                        ${{ number_format($parte->precio, 2) }}
                                    </td>
                                    <td class="px-4 py-2 text-center text-gray-700">
                                        {{ $parte->existencia }}
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <a href="{{ route('tienda.parte.show', $parte->id) }}"
                                           class="text-xs text-gray-700 border border-gray-300 rounded px-2 py-1 hover:bg-gray-50">
                                            Ver detalle
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
@endsection
