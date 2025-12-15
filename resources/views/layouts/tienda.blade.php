{{-- resources/views/layouts/tienda.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Inventario Rastro | Tienda')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">

    <div class="min-h-screen flex flex-col">

        {{-- NAVBAR HORIZONTAL --}}
        <header class="h-16 bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto h-full px-4 lg:px-8 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('tienda.index') }}" class="flex items-baseline space-x-2">
                        <span class="text-base font-semibold text-gray-900">
                            Inventario Rastro
                        </span>
                        <span class="text-xs uppercase tracking-wide text-gray-500">
                            Tienda pública
                        </span>
                    </a>
                </div>

                <nav class="flex items-center space-x-6 text-sm">
                    <a href="{{ route('tienda.index') }}"
                       class="{{ request()->routeIs('tienda.index') ? 'text-gray-900 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                        Inicio
                    </a>

                    <a href="{{ route('tienda.categorias') }}"
                       class="{{ request()->routeIs('tienda.categorias') ? 'text-gray-900 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                        Categorías
                    </a>

                    {{-- Carrito: si está logueado va al carrito, si no, al login --}}
                    @auth
                        <a href="{{ route('carrito.index') }}"
                           class="{{ request()->routeIs('carrito.index') ? 'text-gray-900 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                            Carrito
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">
                            Carrito
                        </a>
                    @endauth

                    @auth
                        <span class="text-gray-600">
                            {{ Auth::user()->name }}
                        </span>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="px-3 py-1 rounded-md bg-gray-900 text-white text-xs hover:bg-gray-700">
                                Cerrar sesión
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">
                            Iniciar sesión
                        </a>
                        <a href="{{ route('register') }}"
                           class="px-3 py-1 rounded-md bg-gray-900 text-white text-xs hover:bg-gray-700">
                            Registrarse
                        </a>
                    @endauth
                </nav>
            </div>
        </header>

        {{-- CONTENIDO --}}
        <main class="flex-1">
            @yield('content')
        </main>

        {{-- FOOTER --}}
        <footer class="border-t border-gray-200 py-4 text-center text-xs text-gray-500">
            © {{ date('Y') }} Inventario Rastro — Tienda pública.
        </footer>
    </div>

</body>
</html>


