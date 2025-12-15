{{-- resources/views/admin/autos/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Catálogo de Autos') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-4 flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Listado de autos</h3>

                        <a href="{{ route('admin.autos.create') }}"
                           class="px-4 py-2 bg-gray-200 text-black text-sm font-semibold rounded border border-gray-400 hover:bg-gray-300">
                            + Nuevo Auto
                        </a>
                    </div>

                    <table class="min-w-full border-collapse text-sm">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="px-3 py-2 text-left">ID</th>
                                <th class="px-3 py-2 text-left">Marca</th>
                                <th class="px-3 py-2 text-left">Modelo</th>
                                <th class="px-3 py-2 text-left">Año</th>
                                <th class="px-3 py-2 text-left">Versión</th>
                                <th class="px-3 py-2 text-left">Comentarios</th>
                                <th class="px-3 py-2 text-left">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($autos as $auto)
                                <tr class="border-b">
                                    <td class="px-3 py-2">{{ $auto->getId() }}</td>
                                    <td class="px-3 py-2">{{ $auto->getMarca() }}</td>
                                    <td class="px-3 py-2">{{ $auto->getModelo() }}</td>
                                    <td class="px-3 py-2">{{ $auto->getAnio() }}</td>
                                    <td class="px-3 py-2">{{ $auto->getVersion() }}</td>
                                    <td class="px-3 py-2">{{ $auto->getComentarios() }}</td>
                                    <td class="px-3 py-2">
                                        <a href="{{ route('admin.autos.edit', $auto->getId()) }}"
                                           class="px-3 py-1 bg-gray-700 text-white rounded">
                                           Editar
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-3 py-4 text-center text-gray-500">
                                        No hay autos registrados.
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
