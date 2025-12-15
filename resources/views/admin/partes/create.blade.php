<x-app-layout>
    <x-slot name="header">
        {{ __('Nueva Parte') }}
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

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
                        <h3 class="text-lg font-semibold">Crear parte</h3>
                        <a href="{{ route('admin.partes.index') }}"
                           class="px-4 py-2 bg-gray-600 text-white text-sm rounded hover:bg-gray-700">
                            Volver al listado
                        </a>
                    </div>

                    <form method="POST" action="{{ route('admin.partes.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Categoría *</label>
                                <select name="categoria_id" class="w-full border rounded px-2 py-1 text-sm">
                                    <option value="">-- Seleccione --</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}"
                                            @selected(old('categoria_id') == $categoria->id)>
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Auto (opcional)</label>
                                <select name="auto_id" class="w-full border rounded px-2 py-1 text-sm">
                                    <option value="">-- Ninguno --</option>
                                    @foreach ($autos as $auto)
                                        <option value="{{ $auto->id }}"
                                            @selected(old('auto_id') == $auto->id)>
                                            {{ $auto->nombre_completo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Código *</label>
                                <input type="text" name="codigo"
                                       value="{{ old('codigo') }}"
                                       class="w-full border rounded px-2 py-1 text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                                <input type="text" name="nombre"
                                       value="{{ old('nombre') }}"
                                       class="w-full border rounded px-2 py-1 text-sm">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                                <textarea name="descripcion" rows="3"
                                          class="w-full border rounded px-2 py-1 text-sm">{{ old('descripcion') }}</textarea>
                            </div>

                            {{-- IMAGEN DE LA PARTE --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Imagen del producto</label>
                                <input type="file" name="imagen" accept="image/*"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <p class="mt-1 text-xs text-gray-500">
                                    Formatos permitidos: JPG, PNG, WEBP. Tamaño máx: 2MB.
                                </p>

                                @error('imagen')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Costo</label>
                                <input type="number" step="0.01" min="0" name="costo"
                                       value="{{ old('costo', 0) }}"
                                       class="w-full border rounded px-2 py-1 text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Precio</label>
                                <input type="number" step="0.01" min="0" name="precio"
                                       value="{{ old('precio', 0) }}"
                                       class="w-full border rounded px-2 py-1 text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Cantidad</label>
                                <input type="number" min="0" name="cantidad"
                                       value="{{ old('cantidad', 0) }}"
                                       class="w-full border rounded px-2 py-1 text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de registro</label>
                                <input type="date" name="fecha_registro"
                                       value="{{ old('fecha_registro') }}"
                                       class="w-full border rounded px-2 py-1 text-sm">
                            </div>

                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white text-sm rounded">
                                Guardar Parte
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
