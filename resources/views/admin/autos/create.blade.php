{{-- resources/views/admin/autos/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        {{ __('Nuevo Auto') }}
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
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Crear autos</h3>
                        <a href="{{ route('admin.autos.index') }}"
                        class="px-4 py-2 bg-gray-600 text-white text-sm rounded hover:bg-gray-700">
                            Volver al listado
                        </a>
                    </div>
                    <form method="POST" action="{{ route('admin.autos.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Marca *
                            </label>
                            <input type="text" name="marca"
                                   value="{{ old('marca') }}"
                                   class="w-full border rounded px-2 py-1 text-sm">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Modelo *
                            </label>
                            <input type="text" name="modelo"
                                   value="{{ old('modelo') }}"
                                   class="w-full border rounded px-2 py-1 text-sm">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Año
                            </label>
                            <input type="number" name="anio"
                                   value="{{ old('anio') }}"
                                   class="w-full border rounded px-2 py-1 text-sm">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Versión
                            </label>
                            <input type="text" name="version"
                                   value="{{ old('version') }}"
                                   class="w-full border rounded px-2 py-1 text-sm">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Comentarios
                            </label>
                            <textarea name="comentarios" rows="3"
                                      class="w-full border rounded px-2 py-1 text-sm">{{ old('comentarios') }}</textarea>
                        </div>

                        <div class="mt-4">
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white text-sm rounded">
                                Guardar Auto
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
