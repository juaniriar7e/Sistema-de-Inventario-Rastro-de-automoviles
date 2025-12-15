<x-app-layout>
    <x-slot name="header">
        {{ __('Editar Parte') }}
    </x-slot>

    @php
        // Adaptador: funciona si $parte es Eloquent (App\Models\Parte) o Dominio (con getters)
        $id          = method_exists($parte, 'getId') ? $parte->getId() : ($parte->id ?? null);
        $categoriaId = method_exists($parte, 'getCategoriaId') ? $parte->getCategoriaId() : ($parte->categoria_id ?? null);
        $autoId      = method_exists($parte, 'getAutoId') ? $parte->getAutoId() : ($parte->auto_id ?? null);
        $codigo      = method_exists($parte, 'getCodigo') ? $parte->getCodigo() : ($parte->codigo ?? '');
        $nombre      = method_exists($parte, 'getNombre') ? $parte->getNombre() : ($parte->nombre ?? '');
        $descripcion = method_exists($parte, 'getDescripcion') ? $parte->getDescripcion() : ($parte->descripcion ?? '');
        $costo       = method_exists($parte, 'getCosto') ? $parte->getCosto() : ($parte->costo ?? 0);
        $precio      = method_exists($parte, 'getPrecio') ? $parte->getPrecio() : ($parte->precio ?? 0);
        $cantidad    = method_exists($parte, 'getCantidad') ? $parte->getCantidad() : ($parte->cantidad ?? 0);

        // fecha_registro puede venir como string o Carbon
        $fechaRaw = method_exists($parte, 'getFechaRegistro') ? $parte->getFechaRegistro() : ($parte->fecha_registro ?? null);
        if ($fechaRaw instanceof \Carbon\CarbonInterface) {
            $fechaRegistro = $fechaRaw->format('Y-m-d');
        } else {
            // si viene "2025-12-14 00:00:00" o similar, recortamos
            $fechaRegistro = $fechaRaw ? substr((string) $fechaRaw, 0, 10) : '';
        }

        // Imagen: tu BD guarda la ruta en imagen_path (según tu screenshot)
        $imagenPath = method_exists($parte, 'getImagenPath') ? $parte->getImagenPath() : ($parte->imagen_path ?? null);
    @endphp

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
                        <h3 class="text-lg font-semibold">Editar parte</h3>
                        <a href="{{ route('admin.partes.index') }}"
                           class="px-4 py-2 bg-gray-600 text-white text-sm rounded hover:bg-gray-700">
                            Volver al listado
                        </a>
                    </div>

                    {{-- IMPORTANTE: aquí va el ID correcto (sin getId en Eloquent) --}}
                    <form method="POST"
                          action="{{ route('admin.partes.update', $id) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Categoría *</label>
                                <select name="categoria_id" class="w-full border rounded px-2 py-1 text-sm">
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}"
                                            @selected(old('categoria_id', $categoriaId) == $categoria->id)>
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
                                            @selected(old('auto_id', $autoId) == $auto->id)>
                                            {{ $auto->nombre_completo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Código *</label>
                                <input type="text" name="codigo"
                                       value="{{ old('codigo', $codigo) }}"
                                       class="w-full border rounded px-2 py-1 text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                                <input type="text" name="nombre"
                                       value="{{ old('nombre', $nombre) }}"
                                       class="w-full border rounded px-2 py-1 text-sm">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                                <textarea name="descripcion" rows="3"
                                          class="w-full border rounded px-2 py-1 text-sm">{{ old('descripcion', $descripcion) }}</textarea>
                            </div>

                            {{-- IMAGEN --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Imagen del producto</label>

                                @if (!empty($imagenPath))
                                    <div class="mt-2">
                                        <p class="text-xs text-gray-500 mb-2">Imagen actual:</p>
                                        <img src="{{ asset('storage/' . $imagenPath) }}"
                                             alt="Imagen de {{ $nombre }}"
                                             class="w-40 h-40 object-cover rounded-md border">
                                    </div>
                                @else
                                    <p class="mt-2 text-xs text-gray-500">Este producto aún no tiene imagen.</p>
                                @endif

                                <div class="mt-3">
                                    <input type="file" name="imagen" accept="image/*"
                                           class="block w-full border-gray-300 rounded-md shadow-sm">
                                    <p class="mt-1 text-xs text-gray-500">
                                        Si seleccionas una imagen nueva, reemplazará la actual.
                                    </p>

                                    @error('imagen')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Costo</label>
                                <input type="number" step="0.01" min="0" name="costo"
                                       value="{{ old('costo', $costo) }}"
                                       class="w-full border rounded px-2 py-1 text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Precio</label>
                                <input type="number" step="0.01" min="0" name="precio"
                                       value="{{ old('precio', $precio) }}"
                                       class="w-full border rounded px-2 py-1 text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Cantidad</label>
                                <input type="number" min="0" name="cantidad"
                                       value="{{ old('cantidad', $cantidad) }}"
                                       class="w-full border rounded px-2 py-1 text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de registro</label>
                                <input type="date" name="fecha_registro"
                                       value="{{ old('fecha_registro', $fechaRegistro) }}"
                                       class="w-full border rounded px-2 py-1 text-sm">
                            </div>

                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white text-sm rounded">
                                Actualizar Parte
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

