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
                                @php
                                    $id = $usuario->getId();
                                    $roleActual = $usuario->getRole();
                                    $esActivo = $usuario->isActivo();
                                @endphp

                                <tr class="border-b align-middle">
                                    <td class="px-4 py-2">{{ $id }}</td>
                                    <td class="px-4 py-2">{{ $usuario->getNombre() }}</td>
                                    <td class="px-4 py-2">{{ $usuario->getEmail() }}</td>

                                    {{-- ROL (editable) --}}
                                    <td class="px-4 py-2">
                                        <form action="{{ route('admin.usuarios.cambiarRol', $id) }}"
                                              method="POST"
                                              class="flex items-center gap-2">
                                            @csrf

                                            <select name="role" class="text-sm border-gray-300 rounded">
                                                <option value="cliente" @selected($roleActual === 'cliente')>cliente</option>
                                                <option value="admin" @selected($roleActual === 'admin')>admin</option>
                                                {{-- Si tienes "operador", descomenta:
                                                <option value="operador" @selected($roleActual === 'operador')>operador</option>
                                                --}}
                                            </select>

                                            <button type="submit"
                                                    class="px-3 py-1 bg-gray-800 text-white text-sm rounded hover:bg-gray-700">
                                                Guardar
                                            </button>
                                        </form>

                                        @error('role')
                                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </td>

                                    {{-- ESTADO --}}
                                    <td class="px-4 py-2">
                                        @if ($esActivo)
                                            <span class="text-green-600 font-semibold">Activo</span>
                                        @else
                                            <span class="text-red-600 font-semibold">Inactivo</span>
                                        @endif
                                    </td>

                                    {{-- ACCIONES --}}
                                    <td class="px-4 py-2">
                                        @if ($esActivo)
                                            <form action="{{ route('admin.usuarios.desactivar', $id) }}"
                                                  method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                        class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                                                    Desactivar
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.usuarios.activar', $id) }}"
                                                  method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                        class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700">
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
