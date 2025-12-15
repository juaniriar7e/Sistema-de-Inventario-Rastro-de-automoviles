{{-- resources/views/admin/ventas/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        {{ __('Ventas') }}
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-sm">
                    <div class="mb-4 flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Listado de ventas</h3>

                        <a href="{{ route('admin.ventas.create') }}"
                        class="px-4 py-2 bg-gray-200 text-black text-sm font-semibold rounded border border-gray-400 hover:bg-gray-300">
                            + Nueva Venta
                        </a>
                    </div>
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="px-3 py-2 text-left">ID</th>
                                <th class="px-3 py-2 text-left">Fecha</th>
                                <th class="px-3 py-2 text-left">Cliente</th>
                                <th class="px-3 py-2 text-left">Usuario</th>
                                <th class="px-3 py-2 text-left">Total</th>
                                <th class="px-3 py-2 text-left">Estado</th>
                                <th class="px-3 py-2 text-left">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ventas as $venta)
                                <tr class="border-b">
                                    <td class="px-3 py-2">{{ $venta->id }}</td>
                                    <td class="px-3 py-2">
                                        {{ $venta->fecha_venta?->format('d/m/Y H:i') ?? $venta->fecha_venta }}
                                    </td>
                                    <td class="px-3 py-2">
                                        {{ $venta->cliente?->nombre ?? 'Mostrador' }}
                                    </td>
                                    <td class="px-3 py-2">
                                        {{ $venta->usuario?->name ?? '-' }}
                                    </td>
                                    <td class="px-3 py-2">
                                        ${{ number_format($venta->total, 2) }}
                                    </td>
                                    <td class="px-3 py-2">{{ $venta->estado }}</td>
                                    <td class="px-3 py-2">
                                        <a href="{{ route('admin.ventas.show', $venta->id) }}"
                                           class="px-3 py-1 bg-gray-700 text-white rounded">
                                            Ver
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-3 py-4 text-center text-gray-500">
                                        No hay ventas registradas.
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
