{{-- resources/views/tienda/index.blade.php --}}
@extends('layouts.tienda')

@section('title', 'Inicio | Inventario Rastro')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Columna izquierda: texto principal --}}
            <div class="lg:col-span-2">
                <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    Partes de autos del rastro<br>
                    disponibles para consulta pública.
                </h1>

                <p class="text-sm text-gray-600 mb-4 text-justify">
                    Esta tienda permite a los posibles compradores visualizar las partes de autos con las que
                    cuenta el rastro. Desde aquí pueden explorar el catálogo, revisar existencias y conocer el
                    costo de cada ítem antes de realizar una compra a través de un usuario autenticado.
                </p>

                <ul class="text-sm text-gray-700 space-y-1 mb-6">
                    <li>• Vista pública del inventario de partes.</li>
                    <li>• Navegación por categorías según el tipo de parte del auto.</li>
                    <li>• Detalle de cada parte: código, descripción, costo y unidades existentes.</li>
                </ul>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('tienda.categorias') }}"
                       class="inline-flex items-center px-4 py-2 rounded-md bg-gray-900 text-white text-sm hover:bg-gray-700">
                        Ver categorías de partes
                    </a>

                    @auth
                        {{-- Usuario logueado: ir directo a su panel (perfil) --}}
                        <a href="{{ route('profile.edit') }}"
                           class="inline-flex items-center px-4 py-2 rounded-md border border-gray-400 text-sm text-gray-800 hover:bg-gray-50">
                            Ir a mi panel
                        </a>
                    @else
                        {{-- Invitado: invitar a iniciar sesión para comprar --}}
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center px-4 py-2 rounded-md border border-gray-400 text-sm text-gray-800 hover:bg-gray-50">
                            Iniciar sesión para comprar
                        </a>
                    @endauth
                </div>
            </div>

            {{-- Columna derecha: tarjetas de resumen --}}
            <div class="space-y-4">
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <h2 class="text-sm font-semibold text-gray-800 mb-2">
                        Categorías destacadas
                    </h2>

                    @if($categoriasDestacadas->isEmpty())
                        <p class="text-xs text-gray-500">
                            Aún no hay categorías registradas en el sistema.
                        </p>
                    @else
                        <ul class="space-y-1 text-xs text-gray-700">
                            @foreach($categoriasDestacadas as $cat)
                                <li class="flex items-center justify-between">
                                    <a href="{{ route('tienda.categoria.partes', $cat->id) }}"
                                       class="hover:underline">
                                        {{ $cat->nombre }}
                                    </a>
                                    <span class="text-[11px] text-gray-500">
                                        {{ $cat->partes_count }} partes
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="bg-white rounded-xl shadow-sm p-4">
                    <h2 class="text-sm font-semibold text-gray-800 mb-2">
                        Últimas partes registradas
                    </h2>

                    @if($ultimasPartes->isEmpty())
                        <p class="text-xs text-gray-500">
                            Aún no hay partes registradas en el inventario.
                        </p>
                    @else
                        <ul class="space-y-2 text-xs text-gray-700">
                            @foreach($ultimasPartes as $parte)
                                <li class="flex items-center justify-between">
                                    <a href="{{ route('tienda.parte.show', $parte->id) }}"
                                       class="hover:underline">
                                        {{ $parte->codigo }} — {{ $parte->nombre }}
                                    </a>
                                    <span class="text-[11px] text-gray-500">
                                        {{ $parte->existencia }} u.
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection



