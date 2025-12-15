{{-- resources/views/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        {{ __('Panel principal') }}
    </x-slot>

    @php
        $user = Auth::user();
    @endphp

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if($user && $user->role === 'admin')
                {{-- =======================
                    DASHBOARD DE ADMIN
                ======================= --}}

                @php
                    // 1) Ventas por mes (últimos 12 meses)
                    $ventasPorMes = \Illuminate\Support\Facades\DB::table('ventas')
                        ->selectRaw("DATE_FORMAT(fecha_venta, '%Y-%m') as mes, SUM(total) as total")
                        ->whereNotNull('fecha_venta')
                        ->groupBy('mes')
                        ->orderBy('mes')
                        ->limit(12)
                        ->get();

                    $labelsMeses = $ventasPorMes->pluck('mes')->map(function($m){
                        return \Carbon\Carbon::createFromFormat('Y-m', $m)->format('M');
                    })->toArray();

                    $dataVentas = $ventasPorMes->pluck('total')->map(fn($v) => (float)$v)->toArray();

                    // 2) Stock por categoría
                    $stockPorCategoria = \Illuminate\Support\Facades\DB::table('partes')
                        ->join('categorias', 'categorias.id', '=', 'partes.categoria_id')
                        ->selectRaw("categorias.nombre as categoria, SUM(partes.cantidad) as stock")
                        ->groupBy('categorias.nombre')
                        ->orderByDesc('stock')
                        ->limit(8)
                        ->get();

                    $labelsCategorias = $stockPorCategoria->pluck('categoria')->toArray();
                    $dataStock = $stockPorCategoria->pluck('stock')->map(fn($v) => (int)$v)->toArray();

                    // 3) TOP Partes más vendidas
                    $topPartes = \Illuminate\Support\Facades\DB::table('venta_detalles as vd')
                        ->join('ventas as v', 'v.id', '=', 'vd.venta_id')
                        ->join('partes as p', 'p.id', '=', 'vd.parte_id')
                        ->where('v.estado', 'COMPLETADA')
                        ->selectRaw("CONCAT(p.codigo,' - ',p.nombre) as parte, SUM(vd.cantidad) as total_cantidad")
                        ->groupBy('p.codigo','p.nombre')
                        ->orderByDesc('total_cantidad')
                        ->limit(10)
                        ->get();

                    $labelsTopPartes = $topPartes->pluck('parte')->toArray();
                    $dataTopPartes   = $topPartes->pluck('total_cantidad')->map(fn($v) => (int)$v)->toArray();

                    // 4) Total vendido por categoría
                    $ventasPorCategoria = \Illuminate\Support\Facades\DB::table('venta_detalles as vd')
                        ->join('ventas as v', 'v.id', '=', 'vd.venta_id')
                        ->join('partes as p', 'p.id', '=', 'vd.parte_id')
                        ->join('categorias as c', 'c.id', '=', 'p.categoria_id')
                        ->where('v.estado', 'COMPLETADA')
                        ->selectRaw("c.nombre as categoria, SUM(COALESCE(vd.subtotal, vd.precio_unitario * vd.cantidad)) as total_vendido")
                        ->groupBy('c.nombre')
                        ->orderByDesc('total_vendido')
                        ->limit(8)
                        ->get();

                    $labelsVentasCat = $ventasPorCategoria->pluck('categoria')->toArray();
                    $dataVentasCat   = $ventasPorCategoria->pluck('total_vendido')->map(fn($v) => (float)$v)->toArray();
                @endphp

                {{-- ====== FILA 1 (2 columnas) ====== --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
                    {{-- Línea (ocupa 2) --}}
                    <div class="lg:col-span-2 bg-white shadow-sm rounded-xl p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-sm font-semibold text-gray-800">Earnings Overview</h3>
                            <span class="text-xs text-gray-500">Últimos 12 meses</span>
                        </div>
                        <div class="w-full">
                            <canvas id="chartVentasMes" height="110"></canvas>
                        </div>
                    </div>

                    {{-- Dona Stock --}}
                    <div class="bg-white shadow-sm rounded-xl p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-sm font-semibold text-gray-800">Revenue Sources</h3>
                            <span class="text-xs text-gray-500">Stock</span>
                        </div>
                        <div class="w-full">
                            <canvas id="chartStockCategoria" height="220"></canvas>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">
                            Distribución del stock por categoría (top 8).
                        </p>
                    </div>
                </div>

                {{-- ====== FILA 2 (2 columnas) ====== --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                    {{-- Top partes --}}
                    <div class="bg-white shadow-sm rounded-xl p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-sm font-semibold text-gray-800">Partes más vendidas</h3>
                            <span class="text-xs text-gray-500">Top 10</span>
                        </div>
                        <div class="w-full">
                            <canvas id="chartTopPartes" height="140"></canvas>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">
                            Ranking por cantidad vendida.
                        </p>
                    </div>

                    {{-- Total vendido por categoría --}}
                    <div class="bg-white shadow-sm rounded-xl p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-sm font-semibold text-gray-800">Total vendido por categoría</h3>
                            <span class="text-xs text-gray-500">Top 8</span>
                        </div>
                        <div class="w-full">
                            <canvas id="chartVentasCategoria" height="180"></canvas>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">
                            Suma de subtotales por categoría.
                        </p>
                    </div>
                </div>

                {{-- ====== FILA 3: Tarjetas de resumen ====== --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                    <div class="bg-white shadow-sm rounded-xl p-4">
                        <div class="text-xs text-gray-500 uppercase font-semibold">Inventario</div>
                        <div class="mt-2 text-2xl font-bold text-gray-800">Gestiona tus partes</div>
                        <p class="mt-1 text-xs text-gray-500">
                            Agrega, edita y controla el stock de partes por categoría y auto.
                        </p>
                        <div class="mt-3">
                            <a href="{{ route('admin.partes.index') }}"
                               class="inline-block text-xs px-3 py-1 rounded bg-gray-900 text-white hover:bg-gray-700">
                                Ir a partes
                            </a>
                        </div>
                    </div>

                    <div class="bg-white shadow-sm rounded-xl p-4">
                        <div class="text-xs text-gray-500 uppercase font-semibold">Ventas</div>
                        <div class="mt-2 text-2xl font-bold text-gray-800">Registra ventas</div>
                        <p class="mt-1 text-xs text-gray-500">
                            Crea ventas usando las partes en inventario y descuenta stock automáticamente.
                        </p>
                        <div class="mt-3">
                            <a href="{{ route('admin.ventas.create') }}"
                               class="inline-block text-xs px-3 py-1 rounded bg-gray-900 text-white hover:bg-gray-700">
                                Nueva venta
                            </a>
                        </div>
                    </div>

                    <div class="bg-white shadow-sm rounded-xl p-4">
                        <div class="text-xs text-gray-500 uppercase font-semibold">Seguridad</div>
                        <div class="mt-2 text-2xl font-bold text-gray-800">2FA activado</div>
                        <p class="mt-1 text-xs text-gray-500">
                            Protege el acceso al panel de administración con autenticación de dos factores.
                        </p>
                        <div class="mt-3">
                            <a href="{{ route('twofactor.setup') }}"
                               class="inline-block text-xs px-3 py-1 rounded bg-gray-900 text-white hover:bg-gray-700">
                                Configurar 2FA
                            </a>
                        </div>
                    </div>
                </div>

                {{-- ====== FILA 4: Accesos rápidos ====== --}}
                <div class="bg-white shadow-sm rounded-xl p-6 mt-6">
                    <h3 class="text-base font-semibold text-gray-800 mb-4">Accesos rápidos</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-sm">
                        <a href="{{ route('admin.categorias.index') }}"
                           class="border rounded-lg px-4 py-3 hover:bg-gray-50 flex items-center justify-between">
                            <span>Categorías</span>
                            <span class="text-xs text-gray-500">Ver / crear</span>
                        </a>

                        <a href="{{ route('admin.autos.index') }}"
                           class="border rounded-lg px-4 py-3 hover:bg-gray-50 flex items-center justify-between">
                            <span>Autos</span>
                            <span class="text-xs text-gray-500">Catálogo</span>
                        </a>

                        <a href="{{ route('admin.clientes.index') }}"
                           class="border rounded-lg px-4 py-3 hover:bg-gray-50 flex items-center justify-between">
                            <span>Clientes</span>
                            <span class="text-xs text-gray-500">Gestión</span>
                        </a>
                    </div>
                </div>

                @push('scripts')
                    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
                    <script>
                        const labelsMeses      = @json($labelsMeses);
                        const dataVentas       = @json($dataVentas);

                        const labelsCategorias = @json($labelsCategorias);
                        const dataStock        = @json($dataStock);

                        const labelsTopPartes  = @json($labelsTopPartes ?? []);
                        const dataTopPartes    = @json($dataTopPartes ?? []);

                        const labelsVentasCat  = @json($labelsVentasCat ?? []);
                        const dataVentasCat    = @json($dataVentasCat ?? []);

                        const ctx1 = document.getElementById('chartVentasMes');
                        if (ctx1) {
                            new Chart(ctx1, {
                                type: 'line',
                                data: {
                                    labels: labelsMeses.length ? labelsMeses : ['Sin datos'],
                                    datasets: [{
                                        label: 'Total ventas',
                                        data: dataVentas.length ? dataVentas : [0],
                                        tension: 0.35,
                                        fill: true,
                                        pointRadius: 3
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: { legend: { display: false } },
                                    scales: { y: { beginAtZero: true } }
                                }
                            });
                        }

                        const ctx2 = document.getElementById('chartStockCategoria');
                        if (ctx2) {
                            new Chart(ctx2, {
                                type: 'doughnut',
                                data: {
                                    labels: labelsCategorias.length ? labelsCategorias : ['Sin categorías'],
                                    datasets: [{ data: dataStock.length ? dataStock : [1] }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: { legend: { position: 'bottom' } }
                                }
                            });
                        }

                        const ctx3 = document.getElementById('chartTopPartes');
                        if (ctx3) {
                            new Chart(ctx3, {
                                type: 'bar',
                                data: {
                                    labels: labelsTopPartes.length ? labelsTopPartes : ['Sin datos'],
                                    datasets: [{
                                        label: 'Cantidad vendida',
                                        data: dataTopPartes.length ? dataTopPartes : [0],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: { legend: { display: false } },
                                    scales: { y: { beginAtZero: true } }
                                }
                            });
                        }

                        const ctx4 = document.getElementById('chartVentasCategoria');
                        if (ctx4) {
                            new Chart(ctx4, {
                                type: 'doughnut',
                                data: {
                                    labels: labelsVentasCat.length ? labelsVentasCat : ['Sin datos'],
                                    datasets: [{ data: dataVentasCat.length ? dataVentasCat : [1] }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: { legend: { position: 'bottom' } }
                                }
                            });
                        }
                    </script>
                @endpush

            @else
                {{-- DASHBOARD DE USUARIO NORMAL --}}
                <div class="bg-white shadow-sm rounded-xl p-6 text-sm text-gray-800">
                    <h2 class="text-lg font-semibold mb-2">Bienvenido al Sistema de Inventario</h2>
                    <p class="text-sm text-gray-600 mb-4 text-justify">
                        Tu usuario no cuenta con permisos de administración.
                        Solo el personal autorizado puede gestionar autos, partes, clientes y ventas.
                    </p>

                    <p class="text-sm text-gray-600 mb-2">Desde tu cuenta puedes:</p>
                    <ul class="list-disc list-inside text-sm text-gray-700 space-y-1">
                        <li>Actualizar tu información de perfil.</li>
                        <li>Configurar o revisar la autenticación de dos factores (2FA).</li>
                        <li>Solicitar al administrador la asignación de un rol con más permisos, si corresponde.</li>
                    </ul>

                    <div class="mt-4 space-x-3">
                        <a href="{{ route('profile.edit') }}"
                           class="inline-block px-4 py-2 bg-gray-900 text-white text-xs rounded hover:bg-gray-700">
                            Ir a mi perfil
                        </a>
                        <a href="{{ route('twofactor.setup') }}"
                           class="inline-block px-4 py-2 border border-gray-400 text-xs rounded hover:bg-gray-50">
                            Configurar 2FA
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
