{{-- resources/views/admin/categorias/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categorías de Inventario') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

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

                    <div class="mb-4 flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Listado de categorías</h3>

                        <a href="{{ route('admin.categorias.create') }}"
                           class="px-4 py-2 bg-gray-200 text-black text-sm font-semibold rounded border border-gray-400 hover:bg-gray-300">
                            + Nueva Categoría
                        </a>
                    </div>

                    <table class="min-w-full border-collapse text-sm">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="px-3 py-2 text-left">ID</th>
                                <th class="px-3 py-2 text-left">Nombre</th>
                                <th class="px-3 py-2 text-left">Descripción</th>
                                <th class="px-3 py-2 text-left">Estado</th>
                                <th class="px-3 py-2 text-left">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categorias as $categoria)
                                <tr class="border-b">
                                    <td class="px-3 py-2">{{ $categoria->getId() }}</td>
                                    <td class="px-3 py-2">{{ $categoria->getNombre() }}</td>
                                    <td class="px-3 py-2">{{ $categoria->getDescripcion() }}</td>
                                    <td class="px-3 py-2">
                                        @if ($categoria->isActivo())
                                            <span class="text-green-600 font-semibold">Activa</span>
                                        @else
                                            <span class="text-red-600 font-semibold">Inactiva</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 space-x-1">
                                        <a href="{{ route('admin.categorias.edit', $categoria->getId()) }}"
                                           class="px-3 py-1 bg-gray-700 text-white rounded">
                                           Editar
                                        </a>

                                        @if ($categoria->isActivo())
                                            <form action="{{ route('admin.categorias.desactivar', $categoria->getId()) }}"
                                                  method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="px-3 py-1 bg-red-600 text-white rounded">
                                                    Desactivar
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.categorias.activar', $categoria->getId()) }}"
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
                                    <td colspan="5" class="px-3 py-4 text-center text-gray-500">
                                        No hay categorías registradas.
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
