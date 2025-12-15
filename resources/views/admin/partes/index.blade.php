{{-- resources/views/admin/partes/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inventario de Partes') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- MENSAJES --}}
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- AQUÍ VA EL BOTÓN, SIEMPRE VISIBLE --}}
                    <div class="mb-4 flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Listado de partes</h3>

                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.partes.create') }}"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold rounded-md
                                border border-gray-300 bg-white text-gray-800 hover:bg-gray-50 shadow-sm">
                            + Nueva Parte
                        </a>

                        <a href="{{ route('admin.partes.export.excel') }}"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold rounded-md
                                border border-green-700 bg-green-600 text-white hover:bg-green-700 shadow-sm">
                            Exportar Excel
                        </a>
                    </div>

                    </div>

                    <table class="min-w-full border-collapse text-sm">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="px-3 py-2 text-left">ID</th>
                                <th class="px-3 py-2 text-left">Código</th>
                                <th class="px-3 py-2 text-left">Nombre</th>
                                <th class="px-3 py-2 text-left">Categoría</th>
                                <th class="px-3 py-2 text-left">Auto</th>
                                <th class="px-3 py-2 text-left">Cantidad</th>
                                <th class="px-3 py-2 text-left">Precio</th>
                                <th class="px-3 py-2 text-left">Estado</th>
                                <th class="px-3 py-2 text-left">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($partes as $parte)
                                <tr class="border-b">
                                    <td class="px-3 py-2">{{ $parte->getId() }}</td>
                                    <td class="px-3 py-2">{{ $parte->getCodigo() }}</td>
                                    <td class="px-3 py-2">{{ $parte->getNombre() }}</td>
                                    <td class="px-3 py-2">
                                        @php
                                            $cat = $categorias[$parte->getCategoriaId()] ?? null;
                                        @endphp
                                        {{ $cat?->nombre ?? '-' }}
                                    </td>
                                    <td class="px-3 py-2">
                                        @php
                                            $auto = $parte->getAutoId()
                                                ? ($autos[$parte->getAutoId()] ?? null)
                                                : null;
                                        @endphp
                                        {{ $auto?->nombre_completo ?? '-' }}
                                    </td>
                                    <td class="px-3 py-2">{{ $parte->getCantidad() }}</td>
                                    <td class="px-3 py-2">${{ number_format($parte->getPrecio(), 2) }}</td>
                                    <td class="px-3 py-2">
                                        @if ($parte->isActivo())
                                            <span class="text-green-600 font-semibold">Activo</span>
                                        @else
                                            <span class="text-red-600 font-semibold">Inactivo</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 space-x-1">
                                        <a href="{{ route('admin.partes.edit', $parte->getId()) }}"
                                           class="px-3 py-1 bg-gray-700 text-white rounded">
                                           Editar
                                        </a>

                                        @if ($parte->isActivo())
                                            <form action="{{ route('admin.partes.desactivar', $parte->getId()) }}"
                                                  method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="px-3 py-1 bg-red-600 text-white rounded">
                                                    Desactivar
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.partes.activar', $parte->getId()) }}"
                                                  method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="px-3 py-1 bg-green-600 text-white rounded">
                                                    Activar
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-3 py-4 text-center text-gray-500">
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


