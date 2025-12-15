{{-- resources/views/admin/usuarios/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administración de Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

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

                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr class="border-b">
                                <th class="px-4 py-2 text-left">ID</th>
                                <th class="px-4 py-2 text-left">Nombre</th>
                                <th class="px-4 py-2 text-left">Email</th>
                                <th class="px-4 py-2 text-left">Rol</th>
                                <th class="px-4 py-2 text-left">Estado</th>
                                <th class="px-4 py-2 text-left">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($usuarios as $usuario)
                                <tr class="border-b">
                                    <td class="px-4 py-2">{{ $usuario->getId() }}</td>
                                    <td class="px-4 py-2">{{ $usuario->getNombre() }}</td>
                                    <td class="px-4 py-2">{{ $usuario->getEmail() }}</td>
                                    <td class="px-4 py-2">{{ $usuario->getRole() }}</td>
                                    <td class="px-4 py-2">
                                        @if ($usuario->isActivo())
                                            <span class="text-green-600 font-semibold">Activo</span>
                                        @else
                                            <span class="text-red-600 font-semibold">Inactivo</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        @if ($usuario->isActivo())
                                            <form action="{{ route('admin.usuarios.desactivar', $usuario->getId()) }}"
                                                  method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="px-3 py-1 bg-red-600 text-white text-sm rounded">
                                                    Desactivar
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.usuarios.activar', $usuario->getId()) }}"
                                                  method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="px-3 py-1 bg-green-600 text-white text-sm rounded">
                                                    Activar
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                                        No hay usuarios registrados.
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
