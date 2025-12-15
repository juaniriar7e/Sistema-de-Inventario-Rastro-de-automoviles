{{-- resources/views/admin/ventas/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        {{ __('Nueva Venta') }}
    </x-slot>


    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                    {{ session('error') }}
                </div>
            @endif

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
                        <h3 class="text-lg font-semibold">Registrar venta</h3>
                        <a href="{{ route('admin.ventas.index') }}"
                        class="px-4 py-2 bg-gray-600 text-white text-sm rounded hover:bg-gray-700">
                            Volver al listado
                        </a>
                    </div>
                    <form method="POST" action="{{ route('admin.ventas.store') }}">
                        @csrf

                        {{-- Cliente opcional (por ahora solo ID, se puede ampliar luego) --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Cliente (opcional)
                            </label>
                            <select name="cliente_id"
                                    class="w-full border rounded px-2 py-1 text-sm">
                                <option value="">Mostrador (sin cliente registrado)</option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}"
                                        @selected(old('cliente_id') == $cliente->id)>
                                        [{{ $cliente->id }}] {{ $cliente->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <h3 class="font-semibold mb-2">Detalles de la venta</h3>
                        <p class="text-xs text-gray-500 mb-4">
                            Selecciona las partes y cantidades. Si dejas el precio vacío, se usará el precio actual de la parte.
                        </p>

                        <div class="space-y-3">
                            @for ($i = 0; $i < 5; $i++)
                                <div class="grid grid-cols-12 gap-2 items-end border-b pb-3">
                                    <div class="col-span-6">
                                        <label class="block text-xs font-medium text-gray-700 mb-1">
                                            Parte
                                        </label>
                                        <select name="partes[{{ $i }}][parte_id]"
                                                class="w-full border rounded px-2 py-1 text-sm">
                                            <option value="">-- Seleccionar parte --</option>
                                            @foreach ($partes as $parte)
                                                <option value="{{ $parte->id }}"
                                                    @selected(old("partes.$i.parte_id") == $parte->id)>
                                                    [{{ $parte->codigo }}] {{ $parte->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-span-3">
                                        <label class="block text-xs font-medium text-gray-700 mb-1">
                                            Cantidad
                                        </label>
                                        <input type="number" min="1"
                                               name="partes[{{ $i }}][cantidad]"
                                               value="{{ old("partes.$i.cantidad") }}"
                                               class="w-full border rounded px-2 py-1 text-sm">
                                    </div>

                                    <div class="col-span-3">
                                        <label class="block text-xs font-medium text-gray-700 mb-1">
                                            Precio unitario
                                        </label>
                                        <input type="number" step="0.01" min="0"
                                               name="partes[{{ $i }}][precio_unitario]"
                                               value="{{ old("partes.$i.precio_unitario") }}"
                                               class="w-full border rounded px-2 py-1 text-sm"
                                               placeholder="Auto">
                                    </div>
                                </div>
                            @endfor
                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white text-sm rounded">
                                Guardar Venta
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
