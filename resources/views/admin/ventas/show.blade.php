{{-- resources/views/admin/ventas/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        {{ __('Detalle de Venta') }}
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6 text-gray-900 text-sm">

                    {{-- título interno + botón volver --}}
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Información general</h3>
                        <a href="{{ route('admin.ventas.index') }}"
                           class="px-4 py-2 bg-gray-600 text-white text-sm rounded hover:bg-gray-700">
                            Volver al listado
                        </a>
                    </div>

                    <p><strong>ID:</strong> {{ $venta->id }}</p>
                    <p><strong>Fecha:</strong> {{ $venta->fecha_venta?->format('d/m/Y H:i') ?? $venta->fecha_venta }}</p>
                    <p><strong>Cliente:</strong> {{ $venta->cliente?->nombre ?? 'Mostrador' }}</p>
                    <p><strong>Usuario:</strong> {{ $venta->usuario?->name ?? '-' }}</p>
                    <p><strong>Estado:</strong> {{ $venta->estado }}</p>
                    <p><strong>Total:</strong> ${{ number_format($venta->total, 2) }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-sm">
                    <h3 class="text-lg font-semibold mb-3">Partes vendidas</h3>

                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="px-3 py-2 text-left">Parte</th>
                                <th class="px-3 py-2 text-left">Cantidad</th>
                                <th class="px-3 py-2 text-left">Precio unitario</th>
                                <th class="px-3 py-2 text-left">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($venta->detalles as $det)
                            <tr class="border-b">
                                <td class="px-3 py-2">
                                    [{{ $det->parte?->codigo ?? '-' }}] {{ $det->parte?->nombre ?? '—' }}
                                </td>
                                <td class="px-3 py-2">{{ $det->cantidad }}</td>
                                <td class="px-3 py-2">
                                    ${{ number_format($det->precio_unitario, 2) }}
                                </td>
                                <td class="px-3 py-2">
                                    ${{ number_format($det->subtotal ?? ($det->cantidad * $det->precio_unitario), 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-3 text-center text-gray-500">
                                    No hay detalles registrados para esta venta.
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

