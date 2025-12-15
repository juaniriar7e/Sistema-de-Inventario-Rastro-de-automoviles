{{-- resources/views/admin/clientes/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        {{ __('Clientes') }}
    </x-slot>


    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-sm">
                    <div class="mb-4 flex justify-between items-center">
                            <h3 class="text-lg font-semibold">Listado de clientes</h3>

                            <a href="{{ route('admin.clientes.create') }}"
                            class="px-4 py-2 bg-gray-200 text-black text-sm font-semibold rounded border border-gray-400 hover:bg-gray-300">
                                + Nuevo Cliente
                            </a>
                        </div>
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="px-3 py-2 text-left">ID</th>
                                <th class="px-3 py-2 text-left">Nombre</th>
                                <th class="px-3 py-2 text-left">Email</th>
                                <th class="px-3 py-2 text-left">Teléfono</th>
                                <th class="px-3 py-2 text-left">Cédula</th>
                                <th class="px-3 py-2 text-left">Dirección</th>
                                <th class="px-3 py-2 text-left">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($clientes as $cliente)
                                <tr class="border-b">
                                    <td class="px-3 py-2">{{ $cliente->id }}</td>
                                    <td class="px-3 py-2">{{ $cliente->nombre }}</td>
                                    <td class="px-3 py-2">{{ $cliente->email }}</td>
                                    <td class="px-3 py-2">{{ $cliente->telefono }}</td>
                                    <td class="px-3 py-2">{{ $cliente->cedula }}</td>
                                    <td class="px-3 py-2">{{ $cliente->direccion }}</td>
                                    <td class="px-3 py-2">
                                        <a href="{{ route('admin.clientes.edit', $cliente->id) }}"
                                           class="px-3 py-1 bg-gray-700 text-white rounded">
                                           Editar
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-3 py-4 text-center text-gray-500">
                                        No hay clientes registrados.
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
