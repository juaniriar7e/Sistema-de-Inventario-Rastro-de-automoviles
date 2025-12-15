{{-- resources/views/admin/clientes/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        {{ __('Nuevo Cliente') }}
    </x-slot>


    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-sm">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Registrar cliente</h3>
                        <a href="{{ route('admin.clientes.index') }}"
                        class="px-4 py-2 bg-gray-600 text-white text-sm rounded hover:bg-gray-700">
                            Volver al listado
                        </a>
                    </div>
                    <form method="POST" action="{{ route('admin.clientes.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Nombre *
                            </label>
                            <input type="text" name="nombre"
                                   value="{{ old('nombre') }}"
                                   class="w-full border rounded px-2 py-1 text-sm">
                        </div>

                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Email
                            </label>
                            <input type="email" name="email"
                                   value="{{ old('email') }}"
                                   class="w-full border rounded px-2 py-1 text-sm">
                        </div>

                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Teléfono
                            </label>
                            <input type="text" name="telefono"
                                   value="{{ old('telefono') }}"
                                   class="w-full border rounded px-2 py-1 text-sm">
                        </div>

                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Cédula
                            </label>
                            <input type="text" name="cedula"
                                   value="{{ old('cedula') }}"
                                   class="w-full border rounded px-2 py-1 text-sm">
                        </div>

                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Dirección
                            </label>
                            <textarea name="direccion" rows="3"
                                      class="w-full border rounded px-2 py-1 text-sm">{{ old('direccion') }}</textarea>
                        </div>

                        <div class="mt-4">
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white text-sm rounded">
                                Guardar Cliente
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
