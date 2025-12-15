{{-- resources/views/twofactor/setup.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Configurar Autenticación de Dos Factores') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">

            @if (session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-sm space-y-4">

                    <p>
                        Para activar la autenticación de dos factores, sigue estos pasos:
                    </p>

                    <ol class="list-decimal list-inside space-y-1">
                        <li>Abre la aplicación <strong>Google Authenticator</strong>, <strong>Microsoft Authenticator</strong> o similar en tu celular.</li>
                        <li>Selecciona la opción <strong>Agregar cuenta</strong> y escanea el siguiente código QR.</li>
                        <li>Ingresa el código de 6 dígitos generado en la app para confirmar.</li>
                    </ol>

                    <div class="mt-4">
                        <p class="font-semibold mb-2">URL otpauth (para generar QR):</p>
                        <code class="block p-2 bg-gray-100 text-xs break-all">
                            {{ $qrData }}
                        </code>
                    </div>

                    <div class="mt-4">
                        <p class="text-sm">
                            También puedes configurar manualmente usando esta clave secreta:
                        </p>
                        <p class="font-mono text-lg mt-1">
                            {{ $secretKey }}
                        </p>
                    </div>

                    <form method="POST" action="{{ route('twofactor.enable') }}" class="mt-6 space-y-3">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Código 2FA (6 dígitos)
                            </label>
                            <input type="text" name="code" maxlength="6"
                                   class="w-full border rounded px-2 py-1 text-sm"
                                   autofocus>
                        </div>

                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white text-sm rounded">
                            Activar 2FA
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
