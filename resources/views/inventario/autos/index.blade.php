{{-- resources/views/inventario/autos/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        {{ __('Catálogo de Autos (consulta)') }}
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-sm">

                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">
                            Autos registrados (solo lectura)
                        </h3>
                        <p class="text-xs text-gray-500 mt-1">
                            Consulta el catálogo de autos disponibles en el rastro.
                            Solo el administrador puede crear o modificar autos.
                        </p>
                    </div>

                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="px-3 py-2 text-left">ID</th>
                                <th class="px-3 py-2 text-left">Marca</th>
                                <th class="px-3 py-2 text-left">Modelo</th>
                                <th class="px-3 py-2 text-left">Año</th>
                                <th class="px-3 py-2 text-left">Versión</th>
                                <th class="px-3 py-2 text-left">Comentarios</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($autos as $auto)
                                <tr class="border-b">
                                    <td class="px-3 py-2">{{ $auto->id }}</td>
                                    <td class="px-3 py-2">{{ $auto->marca }}</td>
                                    <td class="px-3 py-2">{{ $auto->modelo }}</td>
                                    <td class="px-3 py-2">{{ $auto->anio }}</td>
                                    <td class="px-3 py-2">{{ $auto->version }}</td>
                                    <td class="px-3 py-2">{{ $auto->comentarios }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-3 py-4 text-center text-gray-500">
                                        No hay autos registrados en el catálogo.
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
