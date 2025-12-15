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

            {{-- Barra superior sencilla --}}
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8">
                <div class="flex items-center space-x-2">
                    <span class="text-xl font-semibold text-gray-800">
                        Inventario Rastro
                    </span>
                    <span class="text-xs text-gray-500 uppercase tracking-wide">
                        Sistema de Inventario
                    </span>
                </div>

                <div class="space-x-3 text-sm">
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 bg-gray-900 text-white rounded hover:bg-gray-700">
                        Iniciar sesión
                    </a>
                    <a href="{{ route('register') }}"
                       class="px-4 py-2 border border-gray-400 text-gray-800 rounded bg-white hover:bg-gray-50">
                        Registrarse
                    </a>
                </div>
            </header>

            {{-- Contenido principal --}}
            <main class="flex-1">
                <div class="max-w-6xl mx-auto px-6 lg:px-8 py-16 grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

                    {{-- Lado izquierdo: texto --}}
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                            Controla tu inventario de partes automotrices de forma sencilla.
                        </h1>

                        <p class="text-sm text-gray-600 mb-4 leading-relaxed">
                            Este sistema permite gestionar el <strong>inventario de un rastro</strong>:
                            autos, partes, categorías, clientes y ventas.
                            Incluye autenticación segura con <strong>2FA (código QR)</strong> y un
                            panel de administración para usuarios autorizados.
                        </p>

                        <ul class="text-sm text-gray-700 space-y-1 mb-6">
                            <li>• Registro y consulta de autos y partes por categoría.</li>
                            <li>• Gestión de clientes y ventas con descuento automático de stock.</li>
                            <li>• Acceso restringido por rol <strong>admin</strong>.</li>
                            <li>• Seguridad mediante <strong>autenticación de dos factores</strong>.</li>
                        </ul>

                        <div class="space-x-3">
                            <a href="{{ route('login') }}"
                               class="inline-block px-5 py-2 bg-gray-900 text-white text-sm rounded hover:bg-gray-700">
                                Ingresar al sistema
                            </a>

                            <a href="{{ route('register') }}"
                               class="inline-block px-5 py-2 border border-gray-400 bg-white text-sm rounded text-gray-800 hover:bg-gray-50">
                                Crear nuevo usuario
                            </a>
                        </div>
                    </div>

                    {{-- Lado derecho: “tarjeta” resumen --}}
                    <div class="bg-white shadow-lg rounded-2xl p-6 md:p-8 border border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-800 mb-3">
                            Resumen del sistema
                        </h2>

                        <dl class="space-y-3 text-sm text-gray-700">
                            <div class="flex justify-between">
                                <dt>Módulos principales</dt>
                                <dd class="text-right">
                                    Usuarios, Categorías, Autos, Partes, Clientes, Ventas
                                </dd>
                            </div>
                            <div class="flex justify-between">
                                <dt>Rol administrador</dt>
                                <dd class="text-right">
                                    Acceso completo a la gestión
                                </dd>
                            </div>
                            <div class="flex justify-between">
                                <dt>Seguridad</dt>
                                <dd class="text-right">
                                    Login + 2FA con código de autenticador
                                </dd>
                            </div>
                            <div class="flex justify-between">
                                <dt>Objetivo académico</dt>
                                <dd class="text-right">
                                    Proyecto final de Sistema de Inventario en PHP (Laravel)
                                </dd>
                            </div>
                        </dl>

                        <p class="mt-6 text-xs text-gray-500 text-justify">
                            Nota: Esta página de inicio se incluye como presentación del sistema,
                            indicando el contexto y las funcionalidades desarrolladas según la rúbrica
                            del examen final.
                        </p>
                    </div>
                </div>
            </main>

            <footer class="py-4 text-center text-xs text-gray-500">
                © {{ date('Y') }} Sistema de Inventario - Rastro.
            </footer>
        </div>
    </body>
</html>
