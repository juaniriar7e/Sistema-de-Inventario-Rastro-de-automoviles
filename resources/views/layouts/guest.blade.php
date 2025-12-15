{{-- resources/views/layouts/guest.blade.php --}}
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', config('app.name'))</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">


        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="min-h-screen flex flex-col">

            {{-- barra superior --}}
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8">
                <a href="{{ url('/') }}" class="flex items-center space-x-2">
                    <span class="text-lg font-semibold text-gray-800">
                        Inventario Rastro
                    </span>
                    <span class="text-xs text-gray-500 uppercase tracking-wide">
                        Acceso al sistema
                    </span>
                </a>

                <div class="text-xs text-gray-500">
                    Proyecto final - Sistema de Inventario
                </div>
            </header>

            {{-- contenido invitado --}}
            <main class="flex-1 flex items-center justify-center px-4 py-10">
                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>
            </main>

            <footer class="py-4 text-center text-xs text-gray-500">
                © {{ date('Y') }} Inventario Rastro.
            </footer>
        </div>
    </body>
</html>
