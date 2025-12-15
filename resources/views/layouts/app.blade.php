{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', config('app.name', 'Inventario Rastro'))</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="min-h-screen flex">

            {{-- SIDEBAR --}}
            <aside class="w-64 bg-gray-900 text-gray-100 flex flex-col">
                <div class="h-16 flex items-center px-4 border-b border-gray-700">
                    <span class="text-lg font-semibold">
                        Inventario Rastro
                    </span>
                </div>

                @php
                    $user = Auth::user();
                @endphp

                <nav class="flex-1 px-3 py-4 text-sm space-y-1 overflow-y-auto">

                    {{-- SOLO ADMIN: dashboard + módulo de administración --}}
                    @if($user && $user->role === 'admin')
                        <a href="{{ route('dashboard') }}"
                           class="flex items-center px-3 py-2 rounded
                                  {{ request()->routeIs('dashboard') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                            <span>Dashboard</span>
                        </a>

                        <div class="mt-3 text-xs font-semibold text-gray-400 uppercase">
                            Administración
                        </div>

                        <a href="{{ route('admin.usuarios.index') }}"
                           class="flex items-center px-3 py-2 rounded
                                  {{ request()->is('admin/usuarios*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                            <span>Usuarios</span>
                        </a>

                        <a href="{{ route('admin.categorias.index') }}"
                           class="flex items-center px-3 py-2 rounded
                                  {{ request()->is('admin/categorias*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                            <span>Categorías</span>
                        </a>

                        <a href="{{ route('admin.autos.index') }}"
                           class="flex items-center px-3 py-2 rounded
                                  {{ request()->is('admin/autos*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                            <span>Autos</span>
                        </a>

                        <a href="{{ route('admin.partes.index') }}"
                           class="flex items-center px-3 py-2 rounded
                                  {{ request()->is('admin/partes*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                            <span>Partes</span>
                        </a>

                        <a href="{{ route('admin.clientes.index') }}"
                           class="flex items-center px-3 py-2 rounded
                                  {{ request()->is('admin/clientes*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                            <span>Clientes</span>
                        </a>

                        <a href="{{ route('admin.ventas.index') }}"
                           class="flex items-center px-3 py-2 rounded
                                  {{ request()->is('admin/ventas*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                            <span>Ventas</span>
                        </a>
                    @endif

                    {{-- SECCIÓN COMÚN: Mi cuenta --}}
                    <div class="mt-3 text-xs font-semibold text-gray-400 uppercase">
                        Mi cuenta
                    </div>

                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center px-3 py-2 rounded
                              {{ request()->routeIs('profile.edit') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        <span>Perfil</span>
                    </a>

                    <a href="{{ route('twofactor.setup') }}"
                       class="flex items-center px-3 py-2 rounded
                              {{ request()->is('2fa*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                        <span>Configurar 2FA</span>
                    </a>

                        <div class="mt-3 text-xs font-semibold text-gray-400 uppercase">
                            Navegación
                        </div>

                        <a href="{{ route('tienda.index') }}"
                           class="flex items-center px-3 py-2 rounded
                                  {{ request()->routeIs('tienda.index') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                            <span>Volver a la tienda</span>
                        </a>

                </nav>

                {{-- Footer pequeño del sidebar --}}
                <div class="px-4 py-3 border-t border-gray-700 text-xs text-gray-400">
                    © {{ date('Y') }} Inventario Rastro
                </div>
            </aside>

            {{-- CONTENIDO PRINCIPAL --}}
            <div class="flex-1 flex flex-col min-h-screen">

                {{-- TOPBAR --}}
                <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6">
                    <div class="flex items-center space-x-2">
                        @isset($header)
                            <div class="text-lg font-semibold text-gray-800">
                                {{ $header }}
                            </div>
                        @endisset
                    </div>

                    <div class="flex items-center space-x-4 text-sm">
                        <span class="text-gray-600">
                            {{ Auth::user()->name ?? '' }}
                        </span>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="px-3 py-1 text-xs rounded bg-gray-800 text-white hover:bg-gray-700">
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </header>

                {{-- CONTENIDO --}}
                <main class="flex-1">
                    {{ $slot }}
                </main>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>
