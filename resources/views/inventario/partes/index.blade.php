{{-- resources/views/inventario/partes/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        {{ __('Consulta de Inventario') }}
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-sm">

                    <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                        <div>
                            <h3 class="text-lg font-semibold">
                                Inventario de partes (solo lectura)
                            </h3>
                            <p class="text-xs text-gray-500 mt-1">
                                Consulta las partes disponibles. Puedes filtrar por categoría.
                                Solo el administrador puede realizar cambios en el inventario.
                            </p>
                        </div>

                        {{-- Filtro por categoría --}}
                        <form method="GET" action="{{ route('inventario.partes.index') }}"
                              class="flex items-center gap-2">
                            <label class="text-xs text-gray-600">
                                Categoría:
                            </label>
                            <select name="categoria_id"
                                    class="border rounded px-2 py-1 text-xs">
                                <option value="">Todas</option>
                                @foreach ($categorias as $cat)
                                    <option value="{{ $cat->id }}"
                                        @selected($categoriaId == $cat->id)>
                                        {{ $cat->nombre }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit"
                                    class="px-3 py-1 text-xs rounded bg-gray-900 text-white hover:bg-gray-700">
                                Filtrar
                            </button>
                        </form>
                    </div>

                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="px-3 py-2 text-left">ID</th>
                                <th class="px-3 py-2 text-left">Código</th>
                                <th class="px-3 py-2 text-left">Nombre</th>
                                <th class="px-3 py-2 text-left">Categoría</th>
                                <th class="px-3 py-2 text-left">Auto</th>
                                <th class="px-3 py-2 text-left">Cantidad</th>
                                <th class="px-3 py-2 text-left">Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($partes as $parte)
                                <tr class="border-b">
                                    <td class="px-3 py-2">{{ $parte->id }}</td>
                                    <td class="px-3 py-2">{{ $parte->codigo }}</td>
                                    <td class="px-3 py-2">{{ $parte->nombre }}</td>
                                    <td class="px-3 py-2">
                                        {{ $parte->categoria?->nombre ?? '-' }}
                                    </td>
                                    <td class="px-3 py-2">
                                        @if($parte->auto)
                                            {{ $parte->auto->marca }} {{ $parte->auto->modelo }}
                                            ({{ $parte->auto->anio }})
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">
                                        {{ $parte->cantidad }}
                                        @if($parte->cantidad <= 3)
                                            <span class="ml-1 text-xs text-red-600 font-semibold">
                                                Bajo stock
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">
                                        ${{ number_format($parte->precio, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-3 py-4 text-center text-gray-500">
                                        No hay partes registradas en el inventario.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

