{{-- resources/views/tienda/categorias.blade.php --}}
@extends('layouts.tienda')

@section('title', 'Categorías | Inventario Rastro')

@section('content')
    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">

            <h1 class="text-2xl font-semibold text-gray-900 mb-4">
                Categorías de partes
            </h1>

            @if($categorias->isEmpty())
                <p class="text-sm text-gray-600">
                    Aún no hay categorías registradas.
                </p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($categorias as $categoria)
                        <a href="{{ route('tienda.categoria.partes', $categoria->id) }}"
                           class="bg-white rounded-xl shadow-sm px-4 py-3 border border-gray-100 hover:shadow-md transition">
                            <div class="text-sm font-semibold text-gray-900">
                                {{ $categoria->nombre }}
                            </div>
                            @if(!empty($categoria->descripcion))
                                <p class="mt-1 text-xs text-gray-600 line-clamp-2">
                                    {{ $categoria->descripcion }}
                                </p>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
@endsection

