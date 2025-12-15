{{-- resources/views/tienda/parte_show.blade.php --}}
@extends('layouts.tienda')

@section('title', (method_exists($parte, 'getNombre') ? $parte->getNombre() : ($parte->nombre ?? 'Parte')) . ' | Inventario Rastro')

@section('content')
    @php
        // Adaptador: funciona si $parte es Eloquent (App\Models\Parte) o Dominio (con getters)
        $nombre = method_exists($parte, 'getNombre') ? $parte->getNombre() : ($parte->nombre ?? '');
        $codigo = method_exists($parte, 'getCodigo') ? $parte->getCodigo() : ($parte->codigo ?? '');
        $descripcion = method_exists($parte, 'getDescripcion') ? $parte->getDescripcion() : ($parte->descripcion ?? null);
        $precio = method_exists($parte, 'getPrecio') ? $parte->getPrecio() : ($parte->precio ?? 0);

        // Existencia / cantidad (tu tienda usa "existencia", admin usa "cantidad")
        $existencia = method_exists($parte, 'getExistencia') ? $parte->getExistencia() : ($parte->existencia ?? ($parte->cantidad ?? 0));

        // Imagen: tu BD guarda en imagen_path
        $imagenPath = method_exists($parte, 'getImagenPath') ? $parte->getImagenPath() : ($parte->imagen_path ?? null);

        // Relaciones (solo Eloquent tiene ->categoria / ->auto)
        $categoriaNombre = isset($parte->categoria) ? (optional($parte->categoria)->nombre ?? '—') : '—';
        $categoriaId = isset($parte->categoria) ? (optional($parte->categoria)->id ?? 0) : 0;

        $autoModelo = isset($parte->auto) ? (optional($parte->auto)->modelo ?? '—') : '—';

        $parteId = method_exists($parte, 'getId') ? $parte->getId() : ($parte->id ?? null);
    @endphp

    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 lg:px-8">

            <div class="bg-white rounded-xl shadow-sm p-6 space-y-4">

                {{-- IMAGEN (TIENDA / COMPRA) --}}
                @if(!empty($imagenPath))
                    <div class="mb-2">
                        <img src="{{ asset('storage/'.$imagenPath) }}"
                             alt="Imagen de {{ $nombre }}"
                             class="w-full max-w-xl h-80 object-cover rounded-xl border">
                    </div>
                @else
                    <div class="text-xs text-gray-500">
                        Este producto no tiene imagen.
                    </div>
                @endif

                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">
                            {{ $nombre }}
                        </h1>
                        <p class="text-sm text-gray-500">
                            Código: {{ $codigo }}
                        </p>
                        <p class="text-sm text-gray-500">
                            Categoría: {{ $categoriaNombre }}
                        </p>
                        <p class="text-sm text-gray-500">
                            Auto: {{ $autoModelo }}
                        </p>
                    </div>

                    <div class="text-right">
                        <div class="text-sm text-gray-500">Precio</div>
                        <div class="text-2xl font-bold text-gray-900">
                            ${{ number_format((float)$precio, 2) }}
                        </div>
                        <div class="mt-1 text-xs text-gray-500">
                            Existencia: {{ (int)$existencia }} unidades
                        </div>
                    </div>
                </div>

                @if(!empty($descripcion))
                    <div class="pt-4 border-t border-gray-100">
                        <h2 class="text-sm font-semibold text-gray-800 mb-1">
                            Descripción
                        </h2>
                        <p class="text-sm text-gray-700 text-justify">
                            {{ $descripcion }}
                        </p>
                    </div>
                @endif

                {{-- Botón volver --}}
                <div class="pt-4 border-t border-gray-100 flex justify-between items-center">
                    <a href="{{ route('tienda.categoria.partes', $categoriaId) }}"
                       class="text-xs text-gray-700 border border-gray-300 rounded px-3 py-1 hover:bg-gray-50">
                        ← Volver a la categoría
                    </a>

                    @auth
                        @if((int)$existencia > 0 && !empty($parteId))
                            <form action="{{ route('carrito.agregar', $parteId) }}" method="POST" class="flex items-center space-x-2">
                                @csrf
                                <input type="number" name="cantidad" value="1" min="1"
                                       class="w-16 text-xs border-gray-300 rounded">
                                <button type="submit"
                                        class="px-4 py-2 text-xs rounded-md bg-gray-900 text-white hover:bg-gray-700">
                                    Agregar al carrito
                                </button>
                            </form>
                        @else
                            <span class="text-xs text-red-500 font-semibold">
                                Sin existencia
                            </span>
                        @endif
                    @else
                        <span class="text-xs text-gray-600">
                            Inicia sesión para agregar al carrito.
                        </span>
                    @endauth
                </div>
            </div>

        </div>
    </div>
@endsection



